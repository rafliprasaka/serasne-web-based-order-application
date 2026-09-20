<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $title = 'Products';
        $products = Product::with('category')->get();

        return view('admin.products.index', compact('title', 'products'));
    }

    public function create()
    {
        $title = 'Add Product';
        $categories = Category::all();

        return view('admin.products.form', compact('title', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle file upload if provided
        $product_image = null;
        if ($request->hasFile('product_image')) {
            $product_image = $request->file('product_image')->store('product_images', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'product_image' => $product_image,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $title = 'Edit Product';
        $categories = Category::all();

        return view('admin.products.form', compact('title', 'product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Update product image if provided
        if ($request->hasFile('product_image')) {
            // Delete previous image if exists
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            $product_image = $request->file('product_image')->store('product_images', 'public');
            $product->product_image = $product_image;
        }

        $product->category_id = $request->category_id;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete product image if exists
        if ($product->product_image) {
            Storage::disk('public')->delete($product->product_image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
