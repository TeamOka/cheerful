<!-- resources/views/tweets/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('商品編集') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700 mr-2">詳細に戻る</a>
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="product_name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">商品名</label>
                            <input type="text" name="product_name" id="product_name" value="{{ $product->title}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <!-- 後で画像の処理をする。 -->
                            <label for="image" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">商品画像</label>
                            <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">商品説明</label>
                            <input type="text" name="description" id="description" value="{{ $product->description }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <div class="mb-4">
                                <label for="tag" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">タグ</label>
                                <select name="tag[]" id="tag" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="tag1" {{ in_array('tag1', explode(',', $product->tag)) ? 'selected' : '' }}>仲間募集中！</option>
                                    <option value="tag2" {{ in_array('tag2', explode(',', $product->tag)) ? 'selected' : '' }}>スポンサー募集中！</option>
                                </select>
                            </div>
                            @error('product_name')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                            @error('update')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                            @error('description')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>