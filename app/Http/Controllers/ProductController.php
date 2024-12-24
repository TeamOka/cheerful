<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    // ダッシュボード（HOME）の表示を
    public function home()
    {
        // 商品のリストを取得
        $products = Product::all();

        // ビューにデータを渡す
        return view('home', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'tag' => 'nullable|array',
            'tag.*' => 'string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像のバリデーション
        ]);

        $product = new Product();
        $product->title = $request->product_name;
        $product->description = $request->description ?? ''; // デフォルト値を設定
        $product->user_id = auth()->id();
        $product->tag = implode(',', $request->tag ?? []); // タグを設定

        // 画像の処理
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName); // 画像を保存
            $product->image = 'images/' . $imageName; // データベースに保存する画像のパスを設定
        } else {
            $product->image = 'https://picsum.photos/200';  //デフォルト画像を設定
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '商品が登録されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // ビューにデータを渡す
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //編集画面を表示
        return view('products.edit', compact('product'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function mylist()
    {
        // 出品リストを取得するロジック
        $products = Product::all(); // 例としてすべての製品を取得

        return view('products.mylist', compact('products'));
    }
}
