<section>
    <header class="mb-6">
        {{-- タイトルを濃い茶色に --}}
        <h2 class="text-lg font-bold text-[#2E1A08] tracking-wider">
            {{ __('パスワード更新') }}
        </h2>
        {{-- 説明文を優しい茶色に --}}
        <p class="mt-1 text-xs text-[#9A8A7A] leading-relaxed">
            {{ __('安全を保つため、定期的かつ複雑なパスワードへの変更をおすすめします。') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        {{-- 現在のパスワード --}}
        <div>
            <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">現在のパスワード</label>
            <input name="current_password" type="password" autocomplete="current-password"
                   class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none focus:ring-0 shadow-inner"
                   style="background:#F6F2EC; border:1px solid #E0D4C0;"
                   placeholder="現在のパスワードを入力">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[10px]" />
        </div>

        {{-- 新しいパスワード --}}
        <div>
            <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">新しいパスワード</label>
            <input name="password" type="password" autocomplete="new-password"
                   class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none focus:ring-0 shadow-inner"
                   style="background:#F6F2EC; border:1px solid #E0D4C0;"
                   placeholder="新しいパスワードを入力">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[10px]" />
        </div>

        {{-- 新しいパスワード（確認用） --}}
        <div>
            <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">新しいパスワード（確認）</label>
            <input name="password_confirmation" type="password" autocomplete="new-password"
                   class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none focus:ring-0 shadow-inner"
                   style="background:#F6F2EC; border:1px solid #E0D4C0;"
                   placeholder="もう一度入力してください">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[10px]" />
        </div>

        {{-- 更新ボタン --}}
        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm active:scale-[0.98] transition-all"
                    style="background:#E8A030;">
                {{ __('パスワードを変更する') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-xs text-[#9A8A7A] font-bold">
                    {{ __('✓ 変更しました') }}
                </p>
            @endif
        </div>
    </form>
</section>
