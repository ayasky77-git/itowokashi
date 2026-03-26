<section>
    <header class="mb-6">
        {{-- タイトルを読みやすい濃い茶色に --}}
        <h2 class="text-lg font-bold text-[#2E1A08] tracking-wider">
            {{ __('プロフィール情報') }}
        </h2>
        {{-- 説明文を優しい茶色に --}}
        <p class="mt-1 text-xs text-[#9A8A7A] leading-relaxed">
            {{ __("お名前とメールアドレスを更新できます。") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- お名前入力欄 --}}
        <div>
            <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">お名前</label>
            <input name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                   class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none focus:ring-0 shadow-inner"
                   style="background:#F6F2EC; border:1px solid #E0D4C0;">
            <x-input-error class="mt-2 text-[10px]" :messages="$errors->get('name')" />
        </div>

        {{-- メールアドレス入力欄 --}}
        <div>
            <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">メールアドレス</label>
            <input name="email" type="email" value="{{ old('email', $user->email) }}" required
                   class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none focus:ring-0 shadow-inner"
                   style="background:#F6F2EC; border:1px solid #E0D4C0;">
            <x-input-error class="mt-2 text-[10px]" :messages="$errors->get('email')" />
        </div>

        {{-- ボタンをオレンジ（#E8A030）に統一 --}}
        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm active:scale-[0.98] transition-all"
                    style="background:#E8A030;">
                {{ __('保存する') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-xs text-[#9A8A7A] font-bold">
                    {{ __('✓ 保存完了') }}
                </p>
            @endif
        </div>
    </form>
</section>