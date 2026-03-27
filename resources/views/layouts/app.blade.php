<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>イトヲカシ</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
        <body>
            <!-- Page Content -->
            <main class="max-w-[390px] mx-auto px-4 pb-20">
                @yield('header')
                @yield('content')
            </main>
            
            {{-- 辞書選択モーダル --}}
            <div id="dictSelectModal"
                class="hidden fixed inset-0 z-50 flex items-end justify-center"
                style="background:rgba(0,0,0,0.4);"
                onclick="if(event.target===this)this.classList.add('hidden')">

                <div class="w-full max-w-[390px] rounded-t-2xl pb-8"
                    style="background:#FEF8F0;">

                    {{-- ハンドル + ×ボタン --}}
                    <div class="flex items-center justify-between px-4 pt-3 pb-2">
                        <div class="w-6"></div>
                        <div class="w-10 h-1 rounded-full" style="background:#E0D4C0;"></div>
                        <button onclick="document.getElementById('dictSelectModal').classList.add('hidden')"
                                class="w-6 h-6 flex items-center justify-center text-[#9A8A7A]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <p class="text-sm font-bold text-[#2E1A08] px-6 mb-4">どの辞書に言葉を追加しますか？</p>

                    <div class="flex flex-col gap-2 px-4 max-h-64 overflow-y-auto">
                        @auth
                            @foreach(auth()->user()->dictionaryUsers()->with('dictionary')->orderByDesc('last_accessed_at')->get() as $du)
                                @if($du->dictionary && !$du->dictionary->trashed())
                                    <x-dict-modal-item :dictionary="$du->dictionary" />
                                @endif
                            @endforeach
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Bottom Tab Bar -->
            <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[390px] bg-[#FEF8F0] border-t border-[#E0D4C0] h-14 flex items-center justify-around z-50">
                
                <a href="{{ route('dictionaries.index') }}" class="w-16 flex flex-col items-center gap-0.5 text-[#9A8A7A] text-xs hover:text-[#E8A030] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M231.65,194.55,198.46,36.75a16,16,0,0,0-19-12.39L132.65,34.42a16.08,16.08,0,0,0-12.3,19l33.19,157.8A16,16,0,0,0,169.16,224a16.25,16.25,0,0,0,3.38-.36l46.81-10.06A16.09,16.09,0,0,0,231.65,194.55ZM136,50.15c0-.06,0-.09,0-.09l46.8-10,3.33,15.87L139.33,66Zm6.62,31.47,46.82-10.05,3.34,15.9L146,97.53Zm6.64,31.57,46.82-10.06,13.3,63.24-46.82,10.06ZM216,197.94l-46.8,10-3.33-15.87L212.67,182,216,197.85C216,197.91,216,197.94,216,197.94ZM104,32H56A16,16,0,0,0,40,48V208a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V48A16,16,0,0,0,104,32ZM56,48h48V64H56Zm0,32h48v96H56Zm48,128H56V192h48v16Z"></path>
                    </svg>
                    本棚                   
                </a>    


                <a href="{{ route('notifications.index') }}" class="w-16 flex flex-col items-center gap-0.5 text-[#9A8A7A] text-xs hover:text-[#E8A030] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"></path>
                    </svg>               
                    通知                  
                </a>    

                <button onclick="document.getElementById('dictSelectModal').classList.remove('hidden')"
                        class="w-16 flex flex-col items-center justify-center w-16 h-16 bg-[#E8A030] rounded-full text-white -mt-4 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4" />
                    </svg>
                </button>

                <a href="{{ route('search.index') }}" class="w-16 flex flex-col items-center gap-0.5 text-[#9A8A7A] text-xs hover:text-[#E8A030] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path>
                    </svg>            
                        さがす          
                </a>    

                <a href="{{ route('dashboard')
                  }}" class="w-16 flex flex-col items-center gap-0.5 text-[#9A8A7A] text-xs hover:text-[#E8A030] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120Zm97.76,66.41a79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75,88,88,0,1,1,131.52,0Z"></path>
                    </svg>
                    マイページ
                </a>
            </nav>

            <!-- ボトムタブ分の余白 -->
            <div class="h-14"></div>
    </body>
</html>
