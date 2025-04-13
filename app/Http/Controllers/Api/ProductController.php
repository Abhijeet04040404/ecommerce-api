<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Cache::remember('products', 3600, function () {
            return Product::with('images')->get();
        });
    
        return response()->json([
            'count' => $products->count(),
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created product with images.
     */
    public function store(ProductFormRequest $request)
    {
        // Validate request data using formrequest
        $validated = $request->validated();
        $product = Product::create($validated);
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('products', 'public');
                $product->images()->create(['url' => 'storage/' . $path]);
            }
        }
    
        Cache::forget('products');
    
        return response()->json([
                'status' => 'success',
                'products' => $product->load('images'),
            ], 201);
    }
    

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return response()->json($product->load('images'));
    }

    /**
     * Update the specified product and optionally its images.
     */
    public function update(ProductFormRequest $request, Product $product)
    {    
        \Log::info('Update request received:', ['request' => $request->all(),]);

        // Validate incoming request
        $validated = $request->validated();

        // Update product fields
        $product->update($validated);

        // If new images are uploaded, replace old ones
        if ($request->hasFile('images')) {
            // Delete existing images from storage and database
            foreach ($product->images as $image) {
                if ($image->url) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $image->url));
                }
                $image->delete();
            }
    
            // Store and save new images
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('products', 'public');
                $product->images()->create([
                    'url' => 'storage/' . $path,
                ]);
            }
        }
    
        // Clear cache if necessary
        Cache::forget('products');
    
        return response()->json([
            'status' => 'success',
            'product' => $product->load('images'),
        ], 200);
    }
    
    /**
     * Remove the specified product and its images from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Cache::forget('products');

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
