<x-guest-layout>
    <div class="w-full flex flex-col items-center justify-center px-4 pt-16 pb-10">

        {{-- ロゴコンポーネント --}}
        <x-auth-logo subtitle="Confirm Password" />

        {{-- カードコンポーネント --}}
        <x-auth-card>
            <div class="mb-6 text-sm leading-relaxed text-[#9A8A7A]">
                {{ __('操作を続ける前にパスワードの確認をお願いいたします。') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                {{-- パスワード入力 --}}
                <div class="mb-8">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">パスワード</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           placeholder="パスワードを入力してください"
                           class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none focus:ring-0"
                           style="background:#F6F2EC; border:1px solid #E0D4C0;">
                    
                    @error('password')
                        <p class="text-[10px] text-[#C0392B] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 確定ボタン --}}
                <button type="submit"
                        class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm active:opacity-80 transition-opacity"
                        style="background:#E8A030;">
                    確認して進む
                </button>

                {{-- キャンセル・戻る（任意で追加） --}}
                <div class="mt-6 text-center">
                    <a href="javascript:history.back()" class="text-[11px] text-[#9A8A7A] underline decoration-[#E0D4C0]">
                        前の画面に戻る
                    </a>
                </div>
            </form>
        </x-auth-card>
    </div>
</x-guest-layout>
