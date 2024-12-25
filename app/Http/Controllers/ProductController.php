<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 現在のユーザーが投稿した商品を取得
        $products = Product::where('user_id', Auth::id())->get();

        // ビューに製品データを渡す
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
        if (!Auth::check()) {
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
        $product->user_id = Auth::id();
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
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'tag' => 'nullable|array',
            'tag.*' => 'string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }

        // 画像の処理
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName); // 画像を保存
            $product->image = 'images/' . $imageName; // データベースに保存する画像のパスを設定
        } else {
            $product->image = $product->image; // 画像がない場合は既存の画像を使用
        }

        // 'product_name'を'title'に変更
        $updated = $product->update([
            'title' => $request->input('product_name'),
            'description' => $request->input('description'),
            'tag' => implode(',', $request->input('tag', [])), // タグをカンマ区切りの文字列に変換
            'image' => $product->image, // 更新された画像のパスを使用
        ]);

        // 更新が成功したか確認
        if ($updated) {
            return redirect()->route('products.show', $product);
        } else {
            // 更新に失敗した場合の処理
            return redirect()->back()->withErrors(['update' => '更新に失敗しました。']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 商品を削除
        $product->delete();

        // 削除後にリダイレクト
        return redirect()->route('products.index')->with('success', '商品が削除されました。');
    }

    public function mylist()
    {
        // ユーザーが応援した商品を取得
        $products = Auth::user()->cheers; // cheersメソッドを使用して応援した商品を取得

        return view('products.mylist', compact('products'));
    }

    public function search(Request $request)
    {
        if ($request->input('search') == null) {
            $request->session()->forget('search');
            return redirect()->route('home');
        }

        $request->validate([
            'search' => 'string|max:255',
        ]);

        // 検索ワードを取得
        $searchTerm = $request->input('search');
        $products = Product::where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('description', 'LIKE', "%{$searchTerm}%")
            ->get();

        // 検索ワードをセッションに保存
        session(['search' => $searchTerm]);

        // 検索結果を表示した後、セッションから検索ワードを削除
        $request->session()->forget('search');

        return view('home', compact('products')); // home.blade.php に渡す
    }
}
