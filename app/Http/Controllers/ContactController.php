<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Product;  // 追加
use Illuminate\Http\Request;

class ContactController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|max:64',
            'email' => 'required|email|max:64',
            'message' => 'required|max:256'
        ]);

        // product_idを追加
        $validated['product_id'] = $product->id;

        // データベースに保存
        Contact::create($validated);

        // 同じページにリダイレクト
        return redirect()
            ->back()
            ->with('success', 'お問い合わせありがとうございます。');
    }

}
