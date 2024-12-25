<x-app-layout>
    <x-slot name="header">

        <h2 class="tracking-widest font-ubuntu font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cheer List') }}

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($products && $products->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">応援した商品はありません。</p>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($products as $product)
                        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="w-full h-auto mb-2">
                            <h2 class="italic text-xl font-bold text-gray-800 dark:text-gray-300">{{ $product->title }}</h2>
                            <p class="text-gray-800 dark:text-gray-300 m-2 border-2 border-gray-300 rounded-lg p-2">{{ $product->description }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm m-2">投稿者: {{ $product->user->name }}</p>
                            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700 m-2">詳細を見る</a>
                            <div class="flex">
                                @if ($product->cheered->contains(auth()->id()))
                                <form action="{{ route('products.discheer', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 m-2">❤︎ 応援中！</button>
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