<x-guest-layout>
    <div class="w-full flex flex-col items-center justify-center px-4 pt-16 pb-10">

        {{-- ロゴコンポーネント --}}
        <x-auth-logo subtitle="Forgot Password" />

        {{-- カードコンポーネント --}}
        <x-auth-card>
            <div class="mb-6 text-sm leading-relaxed text-[#9A8A7A]">
                {{ __('ご登録のメールアドレスを入力していただければ、新しいパスワードを設定するためのリンクをお送りいたします。') }}
            </div>

            <x-auth-session-status class="mb-6 font-bold text-xs text-[#E8A030] bg-[#FEF8F0] p-3 rounded-lg border border-[#E0D4C0]" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- メールアドレス --}}
                <div class="mb-8">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="example@email.com"
                           class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                           style="background:#F6F2EC; border:1px solid #E0D4C0;">
                    @error('email')
                        <p class="text-[10px] text-[#C0392B] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 送信ボタン --}}
                <button type="submit"
                        class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm active:opacity-80 transition-opacity"
                        style="background:#E8A030;">
                    {{ __('再設定リンクを送信する') }}
                </button>

                {{-- 戻るリンク --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-[11px] text-[#9A8A7A] underline decoration-[#E0D4C0]">
                        ログイン画面に戻る
                    </a>
                </div>
            </form>
        </x-auth-card>
    </div>
</x-guest-layout>
