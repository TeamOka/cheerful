<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('応援した商品一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($products->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">応援した商品はありません。</p>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($products as $product)
                        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="w-full h-auto mb-2">
                            <h2 class="text-xl font-bold">{{ $product->title }}</h2>
                            <p class="text-gray-800 dark:text-gray-300">{{ $product->description }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $product->user->name }}</p>
                            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>