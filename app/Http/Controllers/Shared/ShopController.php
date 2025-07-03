<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\CooperativeProduct;
use App\Models\CooperativeTransaction;
use App\Models\CooperativeTransactionDetail;
use App\Models\LocationStock;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * Display available products for purchase.
     */
    public function index()
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        $products = CooperativeProduct::with(['locationStocks' => function($q) use ($locationId) {
            $q->where('location_id', $locationId);
        }])
        ->where('is_active', true)
        ->get()
        ->filter(function($product) {
            return $product->locationStocks->isNotEmpty() && $product->locationStocks->first()->available_quantity > 0;
        });

        return view('shared.shop.index', compact('products'));
    }

    /**
     * Show product details.
     */
    public function show(CooperativeProduct $product)
    {
        $user = auth()->user();
        $locationId = $user->location_id;

        $locationStock = $product->locationStocks()
            ->where('location_id', $locationId)
            ->first();

        if (!$locationStock || $locationStock->available_quantity <= 0) {
            return redirect()->route('shop.index')
                ->with('error', 'Produk tidak tersedia di lokasi Anda.');
        }

        return view('shared.shop.show', compact('product', 'locationStock'));
    }

    /**
     * Add product to cart (session-based cart).
     */
    public function addToCart(Request $request, CooperativeProduct $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();
        $locationId = $user->location_id;

        $locationStock = $product->locationStocks()
            ->where('location_id', $locationId)
            ->first();

        if (!$locationStock || !$locationStock->hasSufficientStock($request->quantity)) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = session()->get('cart', []);
        $productId = $product->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->selling_price,
                'quantity' => $request->quantity,
                'unit' => $product->unit,
                'image_path' => $product->image_path,
            ];
        }

        // Check if total quantity in cart exceeds available stock
        if ($cart[$productId]['quantity'] > $locationStock->available_quantity) {
            $cart[$productId]['quantity'] = $locationStock->available_quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('warning', 'Kuantitas disesuaikan dengan stok yang tersedia.');
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Show cart contents.
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('shared.shop.cart', compact('cart', 'total'));
    }

    /**
     * Update cart item quantity.
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:cooperative_products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if ($request->quantity == 0) {
            unset($cart[$productId]);
        } else {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $request->quantity;
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Process checkout.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,savings_deduction',
        ]);

        $user = auth()->user();
        $member = $user->member;

        if (!$member) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Keranjang kosong.');
        }

        DB::transaction(function () use ($request, $user, $member, $cart) {
            $totalAmount = 0;

            // Calculate total and validate stock
            foreach ($cart as $item) {
                $product = CooperativeProduct::find($item['product_id']);
                $locationStock = $product->locationStocks()
                    ->where('location_id', $user->location_id)
                    ->first();

                if (!$locationStock || !$locationStock->hasSufficientStock($item['quantity'])) {
                    throw new \Exception("Stok tidak mencukupi untuk produk: {$product->name}");
                }

                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Create transaction
            $transaction = CooperativeTransaction::create([
                'transaction_number' => CooperativeTransaction::generateTransactionNumber('sale'),
                'member_id' => $member->id,
                'location_id' => $user->location_id,
                'type' => 'sale',
                'total_amount' => $totalAmount,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'final_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'transaction_date' => now(),
                'notes' => 'Pembelian melalui sistem online',
                'processed_by' => $user->id,
            ]);

            // Create transaction details and update stock
            foreach ($cart as $item) {
                $product = CooperativeProduct::find($item['product_id']);
                
                CooperativeTransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'discount_per_item' => 0,
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Update stock
                $locationStock = $product->locationStocks()
                    ->where('location_id', $user->location_id)
                    ->first();
                
                $locationStock->confirmStockUsage($item['quantity']);
            }

            // Clear cart
            session()->forget('cart');
        });

        return redirect()->route('shop.index')
            ->with('success', 'Pembelian berhasil diproses.');
    }
}
