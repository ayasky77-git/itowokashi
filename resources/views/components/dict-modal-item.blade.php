@props(['dictionary'])

<a href="{{ route('dictionaries.words.create', $dictionary) }}"
   class="flex items-center gap-3 rounded-xl px-4 py-3 active:bg-[#F2E8D8] transition-colors"
   style="background:#fff; border:1px solid #E0D4C0;">

    {{-- 表紙ミニチュア --}}
    <div class="relative flex-shrink-0 overflow-hidden"
         style="width:36px; height:52px; background:{{ $dictionary->color_code ?? '#E8A030' }};
                border-radius:2px 4px 4px 2px;
                box-shadow:2px 2px 6px rgba(0,0,0,0.2), inset 2px 0 4px rgba(0,0,0,0.1);">
        <x-dict-pattern :pattern="$dictionary->spine_pattern ?? 'none'" />
    </div>

    {{-- 辞書名 --}}
    <div class="flex-1 min-w-0">
        <p class="text-sm font-bold text-[#2E1A08] truncate">{{ $dictionary->title }}</p>
    </div>

    <svg class="w-4 h-4 flex-shrink-0 text-[#E0D4C0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
</a>