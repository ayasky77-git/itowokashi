<x-guest-layout>
    <div class="w-full flex flex-col items-center justify-center pt-16 px-4 pb-10">        
        <x-auth-logo subtitle="Community Dictionary" />

        <x-auth-card>
            <x-auth-session-status class="mb-4 text-xs" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block">メールアドレス</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
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

                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-[#E0D4C0] text-[#E8A030] focus:ring-0 w-3.5 h-3.5">
                        <span class="text-[10px] text-[#9A8A7A]">ログイン状態を保持</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-[10px] text-[#9A8A7A] underline">パスワードを忘れた方</a>
                </div>

                <button type="submit" class="w-full rounded-xl py-3.5 text-sm font-bold text-white mb-6" style="background:#E8A030;">
                    ログイン
                </button>

                <p class="text-center text-[11px] text-[#9A8A7A]">
                    アカウントをお持ちでない方は<a href="{{ route('register') }}" class="text-[#E8A030] font-bold ml-1">新規登録</a>
                </p>
            </form>
        </x-auth-card>
    </div>
</x-guest-layout>
