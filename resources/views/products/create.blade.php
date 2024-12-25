 <!-- resources/views/products/create.blade.php -->

            <x-app-layout>
                <x-slot name="header">
                    <h2 class="tracking-widest font-ubuntu font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Challenge') }}
                    </h2>
                </x-slot>


     <div class="py-12">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 text-gray-900 dark:text-gray-100">
                     <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                         @csrf
                         <div class="mb-4">
                             <label for="product_name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">商品名</label>
                             <input type="text" name="product_name" id="product_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('product_name')
                             <span class="text-red-500 text-xs italic">{{ $message }}</span>
                             @enderror
                         </div>
                         <div class="mb-4">
                             <label for="image" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">商品画像</label>
                             <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                             @error('image')
                             <span class="text-red-500 text-xs italic">{{ $message }}</span>
                             @enderror
                         </div>
                         <div class="mb-4">
                             <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">商品説明</label>
                             <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                             @error('description')
                             <span class="text-red-500 text-xs italic">{{ $message }}</span>
                             @enderror
                         </div>
                         <div class="mb-4">
                             <label for="tag" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">タグ</label>
                             <select name="tag[]" id="tag" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                 <option value="tag1">仲間募集中！</option>
                                 <option value="tag2">スポンサー募集中！</option>
                             </select>
                         </div>
                         <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 ease-in-out float-right">商品作成</button>
                     </form>
                     @if ($errors->any())
                     <div class="alert alert-danger">
                         <ul>
                             @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                             @endforeach
                         </ul>
                     </div>
                     @endif
                 </div>
             </div>
         </div>
     </div>
 </x-app-layout>