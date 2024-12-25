<!-- resources/views/products/index.blade.php -->

<x-app-layout>
    <x-slot name="header">

        <h2 class="tracking-widest font-ubuntu font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}

        </h2>
    </x-slot>

    <style>
        @keyframes slide {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 100% 100%;
            }
        }
    </style>

    <div class="main-visual" style="background-image: url('{{ asset('images/mainvisual.jpg') }}'); height: 400px; margin: 20px 5%; background-size: cover; border-radius: 15px; background-position: 0 0; background-repeat: no-repeat; animation: slide 10s linear infinite; overflow: hidden;">
        <div class="main-visual-text mx-4 md:mx-10 lg:mx-20" style="margin-top: 100px; margin-bottom: 100px;">
            <h1 class="text-white text-4xl md:text-6xl lg:text-8xl font-bold m-2 tracking-widest font-ubuntu">Cheerful</h1>
            <p class="text-white text-xl md:text-2xl lg:text-3xl font-bold m-2 font-ubuntu mb-8">誰もがクリエイター！あなたにスポットライトを！</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary w-full sm:w-auto px-4 py-2 mx-2 my-4 text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md transition duration-200">応援をさがす</a>
            <a href="{{ route('products.create') }}" class="btn btn-primary w-full sm:w-auto px-4 py-2 mx-2 my-4 text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 rounded-md transition duration-200">挑戦してみる</a>
            <form method="post" class="flex items-center space-x-2 mt-4">
                <input type="text" name="search" placeholder="挑戦したい内容を検索" class="w-52 p-2 ml-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button type="submit" class="px-4 py-2 ml-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200">検索</button>
            </form>
        </div>
    </div>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 shadow-md rounded-lg">
                    @if ($products->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">出品なし</p>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($products as $product)
                        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="w-full h-auto mb-2">
                            <h2 class="italic text-xl font-bold text-gray-800 dark:text-gray-300 m-2">{{ $product->title }}</h2>
                            <p class="text-gray-800 dark:text-gray-300 text-sm m-2 border-2 border-gray-300 rounded-lg p-2">{{ $product->description }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm m-2">投稿者: {{ $product->user->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm m-2">タグ:
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
                            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700 m-2">詳細を見る</a>
                            <div class="flex">
                                @if ($product->cheered->contains(auth()->id()))
                                <form action="{{ route('products.discheer', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 m-2">❤ 応援中！</button>
                                </form>
                                @else
                                <form action="{{ route('products.cheer', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:text-blue-700 m-2">❤︎ 応援する！</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>