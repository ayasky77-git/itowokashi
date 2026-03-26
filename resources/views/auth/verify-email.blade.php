<x-guest-layout>
    <div class="w-full flex flex-col items-center justify-center px-4 pt-16 pb-10">

        {{-- ロゴコンポーネント --}}
        <x-auth-logo subtitle="Verify Email" />

        {{-- カードコンポーネント --}}
        <x-auth-card>
            {{-- 説明文 --}}
            <div class="mb-6 text-sm leading-relaxed text-[#9A8A7A]">
                {{ __('ご登録ありがとうございます！お送りしたメールのリンクから、メールアドレスの認証をお願いします。もしメールが届いていない場合は、再送することも可能です。') }}
            </div>

            {{-- 成功メッセージ --}}
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 font-bold text-xs text-[#E8A030] bg-[#FEF8F0] p-3 rounded-lg border border-[#E0D4C0]">
                    {{ __('登録時に入力されたメールアドレスに、新しい認証リンクを送信しました。') }}
                </div>
            @endif

            <div class="flex flex-col gap-4">
                {{-- 再送ボタン --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm active:opacity-80 transition-opacity"
                            style="background:#E8A030;">
                        {{ __('認証メールを再送する') }}
                    </button>
                </form>

                {{-- ログアウト（一旦戻る用） --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center text-xs text-[#9A8A7A] underline decoration-[#E0D4C0]">
                        {{ __('ログアウト') }}
                    </button>
                </form>
            </div>
        </x-auth-card>
    </div>
</x-guest-layout>
