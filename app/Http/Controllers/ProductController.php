<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->getFilteredProducts($request, 8);
        return view('products.index', compact('products'));
    }

    // Admin index method (GET /admin/products)
    public function adminIndex(Request $request)
    {
        $products = $this->getFilteredProducts($request, 20);
        return view('dashboard', compact('products'));
    }

    /**
     * Get filtered and sorted products with pagination
     */
    private function getFilteredProducts(Request $request, int $perPage = 12)
    {
        $query = Product::query();
        
        // Search for products by name using Wildcard `LIKE`
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
        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Log admin activity for product operations
     */
    private function logAdminActivity(string $action, Product $product, array $additionalData = [])
    {
        $logData = [
            'admin_id' => Auth::id(),
            'admin_email' => Auth::user()->email,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'action' => $action,
            'timestamp' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ];

        // Merge any additional data
        $logData = array_merge($logData, $additionalData);

        Log::info("Admin {$action} product: {$product->name}", $logData);
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

        $product = Product::create($validated);

        // Simple logging call
        $this->logAdminActivity('created', $product, [
            'product_data' => $validated
        ]);

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
        $originalData = $product->toArray();

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

        // Simple logging call
        $this->logAdminActivity('updated', $product, [
            'changes' => $product->getChanges(),
            'original_data' => $originalData
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Product updated successfully!');
    }

    // Delete product (DELETE /admin/products/{product})
    public function destroy(Product $product)
    {
        // Log before deletion
        $this->logAdminActivity('deleted', $product, [
            'deletion_type' => 'soft_delete'
        ]);
        
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product updated successfully!');
    }

}
