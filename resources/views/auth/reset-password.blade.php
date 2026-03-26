<x-guest-layout>
    <div class="w-full flex flex-col items-center justify-center px-4 pt-16 pb-10">

        {{-- ロゴコンポーネント --}}
        <x-auth-logo subtitle="Reset Password" />

        {{-- カードコンポーネント --}}
        <x-auth-card>
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- メールアドレス --}}
                <div class="mb-5">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                           class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                           style="background:#F6F2EC; border:1px solid #E0D4C0;">
                    @error('email')
                        <p class="text-[10px] text-[#C0392B] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 新しいパスワード --}}
                <div class="mb-5">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">新しいパスワード</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           placeholder="8文字以上の英数字"
                           class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                           style="background:#F6F2EC; border:1px solid #E0D4C0;">
                    @error('password')
                        <p class="text-[10px] text-[#C0392B] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- パスワード確認 --}}
                <div class="mb-8">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">新しいパスワード（確認用）</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           placeholder="もう一度入力してください"
                           class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                           style="background:#F6F2EC; border:1px solid #E0D4C0;">
                    @error('password_confirmation')
                        <p class="text-[10px] text-[#C0392B] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 更新ボタン --}}
                <button type="submit"
                        class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm active:opacity-80 transition-opacity"
                        style="background:#E8A030;">
                    パスワードを再設定する
                </button>
            </form>
        </x-auth-card>
    </div>
</x-guest-layout>
