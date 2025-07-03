<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CooperativeProduct;
use App\Models\LocationStock;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = CooperativeProduct::with('locationStocks.location')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $locations = Location::where('is_active', true)->get();
        return view('admin.products.create', compact('locations'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
            'locations' => 'array',
            'locations.*' => 'exists:locations,id',
            'location_stocks' => 'array',
            'location_stocks.*' => 'integer|min:0',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create product
        $product = CooperativeProduct::create([
            'code' => CooperativeProduct::generateProductCode($request->category),
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock_quantity' => $request->stock_quantity,
            'min_stock' => $request->min_stock,
            'unit' => $request->unit,
            'image_path' => $imagePath,
            'is_active' => true,
        ]);

        // Create location stocks
        if ($request->has('locations')) {
            foreach ($request->locations as $index => $locationId) {
                $quantity = $request->location_stocks[$index] ?? 0;
                LocationStock::create([
                    'location_id' => $locationId,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'reserved_quantity' => 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified product.
     */
    public function show(CooperativeProduct $product)
    {
        $product->load('locationStocks.location');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(CooperativeProduct $product)
    {
        $locations = Location::where('is_active', true)->get();
        $product->load('locationStocks');
        return view('admin.products.edit', compact('product', 'locations'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, CooperativeProduct $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        // Update product
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock_quantity' => $request->stock_quantity,
            'min_stock' => $request->min_stock,
            'unit' => $request->unit,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(CooperativeProduct $product)
    {
        // Check if product has transactions
        if ($product->transactionDetails()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah memiliki transaksi.');
        }

        // Delete image
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        // Delete location stocks
        $product->locationStocks()->delete();

        // Delete product
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Update stock for specific location.
     */
    public function updateLocationStock(Request $request, CooperativeProduct $product)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $locationStock = LocationStock::firstOrCreate(
            [
                'location_id' => $request->location_id,
                'product_id' => $product->id,
            ],
            [
                'quantity' => 0,
                'reserved_quantity' => 0,
            ]
        );

        $locationStock->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Stok lokasi berhasil diperbarui.');
    }
}
