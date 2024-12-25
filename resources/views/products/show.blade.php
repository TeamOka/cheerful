<!-- resources/views/tweets/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('商品詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('products.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
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