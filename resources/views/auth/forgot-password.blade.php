<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        パスワードを忘れましたか？登録したメールアドレスに再設定リンクを送ります。
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="mail_address" value="メールアドレス" />
            <x-text-input id="mail_address" class="block mt-1 w-full" type="email" name="mail_address" :value="old('mail_address')" required autofocus />
            <x-input-error :messages="$errors->get('mail_address')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>再設定リンクを送信</x-primary-button>
        </div>
    </form>
</x-guest-layout>
