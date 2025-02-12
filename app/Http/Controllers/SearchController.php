<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;  // 商品モデル

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');
        
        $products = Product::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(10);
            
        return view('products.index', compact('products'));
    }
}
