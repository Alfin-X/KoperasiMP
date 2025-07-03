<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CooperativeTransaction;
use App\Models\CooperativeTransactionDetail;
use App\Models\CooperativeProduct;
use App\Models\LocationStock;
use App\Models\Member;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display sales transactions.
     */
    public function index()
    {
        $transactions = CooperativeTransaction::with(['member.user', 'location', 'processedBy'])
            ->where('type', 'sale')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.sales.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $members = Member::with('user')->whereHas('user', function($q) {
            $q->where('is_active', true);
        })->get();
        
        $locations = Location::where('is_active', true)->get();
        $products = CooperativeProduct::where('is_active', true)->get();

        return view('admin.sales.create', compact('members', 'locations', 'products'));
    }

    /**
     * Store a newly created sale.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'location_id' => 'required|exists:locations,id',
            'payment_method' => 'required|in:cash,credit,savings_deduction',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:cooperative_products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Calculate totals
            $totalAmount = 0;
            $productDetails = [];

            foreach ($request->products as $productData) {
                $product = CooperativeProduct::find($productData['product_id']);
                $quantity = $productData['quantity'];
                $unitPrice = $productData['unit_price'];
                $discount = $productData['discount'] ?? 0;
                
                $subtotal = ($unitPrice * $quantity) - ($discount * $quantity);
                $totalAmount += $subtotal;

                $productDetails[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount_per_item' => $discount,
                    'subtotal' => $subtotal,
                ];

                // Check stock availability
                $locationStock = LocationStock::where('location_id', $request->location_id)
                    ->where('product_id', $product->id)
                    ->first();

                if (!$locationStock || !$locationStock->hasSufficientStock($quantity)) {
                    throw new \Exception("Stok tidak mencukupi untuk produk: {$product->name}");
                }
            }

            $discountAmount = $request->discount_amount ?? 0;
            $finalAmount = $totalAmount - $discountAmount;

            // Create transaction
            $transaction = CooperativeTransaction::create([
                'transaction_number' => CooperativeTransaction::generateTransactionNumber('sale'),
                'member_id' => $request->member_id,
                'location_id' => $request->location_id,
                'type' => 'sale',
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'tax_amount' => 0,
                'final_amount' => $finalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'transaction_date' => now(),
                'notes' => $request->notes,
                'processed_by' => auth()->id(),
            ]);

            // Create transaction details and update stock
            foreach ($productDetails as $detail) {
                CooperativeTransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $detail['product']->id,
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                    'discount_per_item' => $detail['discount_per_item'],
                    'subtotal' => $detail['subtotal'],
                ]);

                // Update stock
                $locationStock = LocationStock::where('location_id', $request->location_id)
                    ->where('product_id', $detail['product']->id)
                    ->first();
                
                $locationStock->confirmStockUsage($detail['quantity']);
            }
        });

        return redirect()->route('admin.sales.index')
            ->with('success', 'Transaksi penjualan berhasil dicatat.');
    }

    /**
     * Display the specified sale.
     */
    public function show(CooperativeTransaction $sale)
    {
        $sale->load(['member.user', 'location', 'processedBy', 'details.product']);
        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Get products by location for AJAX.
     */
    public function getProductsByLocation(Location $location)
    {
        $products = CooperativeProduct::with(['locationStocks' => function($q) use ($location) {
            $q->where('location_id', $location->id);
        }])
        ->where('is_active', true)
        ->get()
        ->filter(function($product) {
            return $product->locationStocks->isNotEmpty() && $product->locationStocks->first()->available_quantity > 0;
        })
        ->map(function($product) {
            $stock = $product->locationStocks->first();
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'selling_price' => $product->selling_price,
                'unit' => $product->unit,
                'available_stock' => $stock ? $stock->available_quantity : 0,
            ];
        });

        return response()->json($products);
    }
}
