<x-guest-layout>
    <div class="w-full flex flex-col items-center justify-center pt-16 px-4 pb-10">        
        <x-auth-logo subtitle="New Account" />

        <x-auth-card>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-5">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block">お名前</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                            placeholder="山田太郎"
                            class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                            style="background:#F6F2EC; border:1px solid #E0D4C0;">
                </div>

                <div class="mb-5">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block">メールアドレス</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="example@email.com"
                           class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                           style="background:#F6F2EC; border:1px solid #E0D4C0;">
                </div>

                <div class="mb-5">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block">パスワード</label>
                    <input type="password" name="password" required
                           class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                           style="background:#F6F2EC; border:1px solid #E0D4C0;">
                </div>

                <div class="mb-8">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block">パスワード（確認用）</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                           style="background:#F6F2EC; border:1px solid #E0D4C0;">
                </div>

                <button type="submit" class="w-full rounded-xl py-3.5 text-sm font-bold text-white mb-6" style="background:#E8A030;">
                    新しく始める
                </button>

                <p class="text-center text-[11px] text-[#9A8A7A]">
                    すでにアカウントをお持ちの方は<a href="{{ route('login') }}" class="text-[#E8A030] font-bold ml-1">ログイン</a>
                </p>
            </form>
        </x-auth-card>
    </div>
</x-guest-layout>
