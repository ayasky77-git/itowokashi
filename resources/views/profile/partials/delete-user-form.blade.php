<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-[#2E1A08] tracking-wider">
            {{ __('退会手続き') }}
        </h2>

        <p class="mt-2 text-sm leading-relaxed text-[#9A8A7A]">
            {{ __('アカウントを削除すると、これまでに綴ったすべての言葉やデータが永久に失われます。消去する前に、残しておきたい情報がないか再度ご確認ください。') }}
        </p>
    </header>

    {{-- ログイン画面のボタンと同じサイズ感の「削除ボタン」 --}}
    <button
        class="w-full rounded-xl py-3.5 text-sm font-bold text-[#C0392B] border border-[#C0392B] transition-all active:scale-[0.98]"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('アカウントを削除する') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        {{-- モーダルの中身もログイン画面と同じベージュ背景（#FEF8F0）に --}}
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-[#FEF8F0]">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-[#2E1A08]">
                {{ __('本当に削除しますか？') }}
            </h2>

            <p class="mt-3 text-sm leading-relaxed text-[#9A8A7A]">
                {{ __('確認のため、現在のパスワードを入力してください。') }}
            </p>

            <div class="mt-6">
                {{-- ログイン画面と全く同じスタイルの入力欄 --}}
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none focus:ring-0"
                    style="background:#F6F2EC; border:1px solid #E0D4C0;"
                    placeholder="{{ __('パスワードを入力') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px] text-[#C0392B]" />
            </div>

            <div class="mt-8 flex flex-col gap-3">
                {{-- 削除確定ボタン（ログインボタンと同じ色使い） --}}
                <button type="submit" 
                        class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm"
                        style="background:#C0392B;">
                    {{ __('完全に削除する') }}
                </button>

                {{-- キャンセル --}}
                <button type="button" 
                        class="w-full py-2 text-xs text-[#9A8A7A] underline decoration-[#E0D4C0]"
                        x-on:click="$dispatch('close')">
                    {{ __('キャンセルして戻る') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
