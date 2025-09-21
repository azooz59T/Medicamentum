<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // search for products by name using Wildcard `LIKE`
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }
        
        // Simple price sorting
        if ($request->sort) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
            }
        } else {
            // Default ordering
            $query->orderBy('name', 'asc');
        }
        
        // Paginate results (preserve query parameters)
        $products = $query->paginate(8)->withQueryString();
        
        return view('products.index', compact('products'));
    }

    // Admin index method (GET /admin/products)
    public function adminIndex()
    {
        $products = Product::latest()->paginate(20); // More items per page for admin
        return view('dashboard', compact('products'));
    }

    // Show create form (GET /admin/products/create)
    public function create()
    {
        return view('admin.products.create');
    }

    // Store new product (POST /admin/products)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:999.99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('dashboard')->with('success', 'Product updated successfully!');
    }

    // Show edit form (GET /admin/products/{product}/edit)
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Update product (PUT/PATCH /admin/products/{product})
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:999.99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Product updated successfully!');
    }

    // Delete product (DELETE /admin/products/{product})
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product updated successfully!');
    }

}
