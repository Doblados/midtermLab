<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();
        return view('shop', compact('products'));
    }

    public function create()
    {
        return view('add-product');
    }

    public function update(string $id)
    {
        $product = Product::findOrFail($id);
        return view('product.update-product', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            Log::debug("Image path: " . $imagePath);
        }
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image); 
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            $validated['image'] = $product->image;
        }

        $product->update($validated);
        return redirect()->route('shop.index')->with('success', 'Product updated successfully!');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
    
        Product::create($validated);
    
        return redirect()->route('shop.index')->with('success', 'Product added successfully!');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('shop.index')->with('success', 'Product deleted!');
    }
}
