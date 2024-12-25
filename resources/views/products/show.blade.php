<!-- resources/views/products/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="tracking-widest font-ubuntu font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700 mr-2">ホームに戻る</a>
                    <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $product->title }}</p>
                    <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="w-52 h-auto mb-2">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $product->user->name }}</p>
                    <p class="text-gray-800 dark:text-gray-300">{{ $product->description }}</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">タグ:
                        @if($product->tag)
                        @php
                        $tags = explode(',', $product->tag);
                        $tagNames = [];
                        foreach ($tags as $tag) {
                        if ($tag === 'tag1') {
                        $tagNames[] = '仲間募集中！';
                        } elseif ($tag === 'tag2') {
                        $tagNames[] = 'スポンサー募集中！';
                        }
                        }
                        @endphp
                        {{ implode(', ', $tagNames) }} <!-- タグ名をカンマ区切りで表示 -->
                        @else
                        なし
                        @endif
                    </p>
                    <div class="text-gray-600 dark:text-gray-400 text-sm">
                        <p>作成日時: {{ $product->created_at->format('Y-m-d H:i') }}</p>
                        <p>更新日時: {{ $product->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                    @if (auth()->id() == $product->user_id)
                    <div class="flex mt-4">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
                        </form>
                        
                    </div>
                    @endif

                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-bold mb-6 dark:text-gray-200">この商品について問い合わせる</h2>

                        @if (session('success'))
                            <div class="mb-4 text-green-600 dark:text-green-400">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('products.contact.store', $product) }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    お名前
                                </label>
                                <input type="text" name="name" id="name" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    メールアドレス
                                </label>
                                <input type="email" name="email" id="email" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- お問い合わせの種類（新規追加） --}}
                            <div class="mb-4">
                                <label for="inquiry_type" class="block text-gray-700 text-sm font-bold mb-2">
                                    お問い合わせの種類
                                </label>
                                <select name="inquiry_type" id="inquiry_type" 
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                    required>
                                    <option value="">選択してください</option>
                                    <option value="member" {{ old('inquiry_type') == 'member' ? 'selected' : '' }}>仲間になリたい</option>
                                    <option value="sponsor" {{ old('inquiry_type') == 'sponsor' ? 'selected' : '' }}>スポンサーになる</option>
                                </select>
                                @error('inquiry_type')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="message" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                    お問い合わせ内容
                                </label>
                                <textarea name="message" id="message" rows="4"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    送信する
                                </button>
                            </div>
                        </form>

                    <div class="flex mt-4">
                        @if ($product->cheered->contains(auth()->id()))
                        <form action="{{ route('products.discheer', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">dislike {{$product->cheered->count()}}</button>
                        </form>
                        @else
                        <form action="{{ route('products.cheer', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-blue-500 hover:text-blue-700">like {{$product->cheered->count()}}</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>