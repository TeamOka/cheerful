<!-- resources/views/products/mylist.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('応援リスト') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($products->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">応援リストなし</p>
                    @else
                    @foreach ($products as $product)
                    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-gray-800 dark:text-gray-300">{{ $product->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $product->user->name }}</p>
                        <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>