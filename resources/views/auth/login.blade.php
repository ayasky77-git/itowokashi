<x-guest-layout>
    <div class="w-full flex flex-col items-center justify-center pt-16 px-4 pb-10">        
        <x-auth-logo subtitle="Login" />
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
                            @error('email')
                                <p class="text-xs text-[#C0392B] mt-1">{{ $message }}</p>
                            @enderror                           
                </div>

                <div class="mb-5">
                    <label class="text-xs font-bold text-[#2E1A08] mb-2 block">パスワード</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none pr-10"
                            style="background:#F6F2EC; border:1px solid #E0D4C0;">
                        <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9A8A7A]">
                            <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 256 256" class="hidden">
                                <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.52,133.52,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,112Z"/>
                            </svg>
                            <svg id="eye-off-password" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M53.92,34.62A8,8,0,1,0,42.08,45.38L61.32,66.55C25,88.84,9.38,123.2,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208a127.11,127.11,0,0,0,52.07-10.8l22,24.18a8,8,0,1,0,11.84-10.76Zm47.33,75.84,41.67,45.85a32,32,0,0,1-41.67-45.85ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.16,133.16,0,0,1,25,128c4.69-8.79,19.66-33.39,47.35-49.38l18,19.75a48,48,0,0,0,63.66,70l14.67,16.14A112,112,0,0,1,128,192Zm6-95.43a8,8,0,0,1,3-15.72,48.16,48.16,0,0,1,38.77,42.64,8,8,0,0,1-7.22,8.71,6.39,6.39,0,0,1-.75,0,8,8,0,0,1-8-7.26A32.09,32.09,0,0,0,134,96.57Zm113.28,34.69c-.42.94-10.55,23.37-33.36,43.8a8,8,0,1,1-10.67-11.92A134.14,134.14,0,0,0,231,128a133.16,133.16,0,0,0-23.07-30.75C185.67,75.19,158.78,64,128,64a118.37,118.37,0,0,0-19.36,1.57A8,8,0,1,1,106,49.79,134,134,0,0,1,128,48c34.88,0,66.57,13.26,91.66,38.35,18.83,18.83,27.3,37.62,27.65,38.41A8,8,0,0,1,247.31,131.26Z"/>
                            </svg>
                        </button>
                    </div>
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

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const eye = document.getElementById('eye-' + id);
        const eyeOff = document.getElementById('eye-off-' + id);
        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.remove('hidden');
            eyeOff.classList.add('hidden');
        } else {
            input.type = 'password';
            eye.classList.add('hidden');
            eyeOff.classList.remove('hidden');
        }
    }
</script>
