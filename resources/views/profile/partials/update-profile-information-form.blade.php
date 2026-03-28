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

        {{-- ボタン --}}
        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm active:scale-[0.98] transition-all"
                    style="background:#E8A030;">
                {{ __('保存する') }}
            </button>
        </div>

        @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-transition
            x-init="setTimeout(() => show = false, 2500)"
            class="fixed top-4 left-1/2 -translate-x-1/2 z-50 rounded-xl px-5 py-3 text-sm font-bold text-white flex items-center gap-2"
            style="background:#E8A030; box-shadow:0 4px 18px rgba(0,0,0,0.15);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 256 256">
                <path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"/>
            </svg>
            プロフィールを保存しました
        </div>
        @endif
    </form>
</section>