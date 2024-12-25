<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('アカウントを削除') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('アカウントが削除されると、そのリソースとデータはすべて永久に削除されます。アカウントを永久に削除することを確認するために、パスワードを入力してください。') }}
        </p>
    </header>

    <div class="mt-6">
        <x-input-label for="password" value="{{ __('パスワード') }}" class="sr-only" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
        <x-input-error :messages="$errors->deleteAccount->get('password')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-6">
        <x-secondary-button x-on:click="$dispatch('close')">
            {{ __('キャンセル') }}
        </x-secondary-button>

        <x-danger-button class="ml-3">
            {{ __('削除') }}
        </x-danger-button>
    </div>
</section>