<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

}
