@props([
    'title',
    'backUrl' => null,
])

<div class="flex items-center justify-between -mx-4 px-4 py-3 mb-4"
     style="background:#FEF8F0; border-bottom:1px solid #E0D4C0;">

    {{-- 左：戻るボタン or 空白 --}}
    @if($backUrl)
    <a href="{{ $backUrl }}" class="text-[#9A8A7A] flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15 18-6-6 6-6"/>
        </svg>
    </a>
    @else
    <div class="w-5"></div>
    @endif

    {{-- 中央：タイトル --}}
    <h1 class="font-serif text-base text-[#665A50] tracking-wider">{!! $title !!}</h1>
    
    {{-- 右：スロット or 空白 --}}
    @if($slot->isNotEmpty())
    <div>{{ $slot }}</div>
    @else
    <div class="w-5"></div>
    @endif

</div>