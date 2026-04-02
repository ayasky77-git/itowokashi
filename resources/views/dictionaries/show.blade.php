@extends('layouts.app')

@section('header')
    <x-page-header title="" :backUrl="route('dictionaries.index')">
    @if($userRole === 'admin' || $userRole === 'editor')
        <a href="{{ route('dictionaries.edit', $dictionary) }}" class="text-[#2E1A08]">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </a>
    @endif
    </x-page-header>
@endsection

@section('content')

    {{-- メンバーアイコン＋をかし総数 --}}
    <div class="flex items-center justify-between mb-8 mx-2">
        <div class="flex items-center gap-1">
            @foreach($members as $member)
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white -ml-1 first:ml-0"
                style="background:#9A8A7A;">
                {{ mb_substr($member->user->name ?? '?', 0, 1) }}
            </div>
            @endforeach
            <span class="text-xs text-[#9A8A7A] ml-2">{{ $members->count() }}人</span>
        </div>
        <div class="flex items-center gap-1 rounded-full px-3 py-1"
            style="background:#F2E8D8;">
            <span class="text-xs text-[#E8A030]">✦</span>
            <span class="text-xs font-bold text-[#E8A030]">{{ $totalReactions }}</span>
            <span class="text-xs text-[#9A8A7A]">をかし</span>
        </div>
    </div>

    {{-- 辞書エリア全体を relative で囲む --}}
    <div class="relative">

        <x-index-bar :dictionary="$dictionary" :currentInitial="request('initial', '')" />

        @php
        $defaultColors = ['#E8A030','#D46B3A','#6FA8C4','#7FAF82','#8A7E9A','#C4A46A','#C46A7A','#5A8A90'];
        $color = $dictionary->color_code ?: $defaultColors[0];
        $count = $words->count();

        @endphp



        {{-- 表紙 --}}

        <a href="{{ route('dictionaries.words.index', $dictionary) }}"> 
            <div class="relative mx-auto mb-6" style="width:200px;">
                {{-- 本体 --}}
                <div class="flex flex-col items-center justify-center relative overflow-hidden "
                    style="width:200px; min-height:280px; background:{{ $color }};
                            border-radius:4px 8px 8px 4px;
                            box-shadow: 6px 6px 20px rgba(0,0,0,0.25), inset 4px 0 8px rgba(0,0,0,0.12);
                            padding:24px 20px 60px;">



                    {{-- 柄 --}}
                    <x-dict-pattern :pattern="$dictionary->spine_pattern ?? 'none'" />

                    {{-- タイトル --}}
                    <h1 class="font-serif text-2xl font-bold text-center leading-relaxed mb-2"
                        style="color:rgba(255,255,255,0.95); letter-spacing:0.1em;">
                        {{ $dictionary->title }}
                    </h1>

                    {{-- 語数 --}}
                    <p class="text-[10px] mb-6" style="color:rgba(255,255,255,0.60);">{{ $count }}語収録</p>
                            
                </div>

                {{-- 帯 --}}
                @if($dictionary->obi_text)
                <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center py-3"
                    style="height:80px; background:#F2E8D8; border-radius:0 0 8px 4px;">
                    <span class="text-xs font-bold tracking-widest mx-5 text-center" style="color:{{ $color }};">{{ $dictionary->obi_text }}</span>
                </div>
                @endif
            </div>
        </a>

        {{-- アクションエリア --}}
        <div class="flex flex-col my-8 gap-3 pr-10 pl-10">

            {{-- 言葉を登録 --}}
            <a href="{{ route('dictionaries.words.create', $dictionary) }}"
                class="flex items-center justify-between w-full rounded-xl px-4 py-3 text-sm text-white"
                style="background:#E8A030;">
                    <span>言葉を登録する</span>
                    <span>›</span>
            </a>

            {{-- 下書き --}}
            @if($draftCount > 0)
                <a href="{{ route('dictionaries.words.index', $dictionary) }}"
                    class="flex items-center justify-between w-full rounded-xl px-4 py-3 text-sm text-white"
                    style="background:#fff; border:1px solid #E0D4C0; color:#2E1A08;">
                        <span>{{ $draftCount }}件の下書きを見る </span>
                        <span>›</span>
                </a>
            @endif

            {{-- 招待コードコピー --}}
            <button onclick="navigator.clipboard.writeText('{{ $dictionary->invite_code }}').then(() => alert('招待コードをコピーしました'))"
                    class="flex items-center justify-between w-full rounded-xl px-4 py-3 text-sm"
                    style="background:#fff; border:1px solid #E0D4C0; color:#2E1A08;">
                <span>招待コード：{{ $dictionary->invite_code }}</span>
                <span class="text-[10px] text-[#9A8A7A]">コピー</span>
            </button>

        </div>

        {{-- 前後ナビ --}}
        <div class="fixed bottom-14 left-1/2 -translate-x-1/2 w-full max-w-[390px] px-4 py-2 mt-3 flex items-center justify-between"
            style="background:rgba(254,248,240,0.95);">
            <a href="{{ $prevDictionary ? route('dictionaries.show', $prevDictionary) : '#' }}"
            class="text-sm text-[#9A8A7A] {{ !$prevDictionary ? 'opacity-30 pointer-events-none' : '' }}">
                ‹ 前
            </a>
            <a href="{{ $nextDictionary ? route('dictionaries.show', $nextDictionary) : '#' }}"
            class="text-sm text-[#9A8A7A] {{ !$nextDictionary ? 'opacity-30 pointer-events-none' : '' }}">
                次 ›
            </a>
        </div>
    </div> {{-- relative wrapper --}}

@endsection