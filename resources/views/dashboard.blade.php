@extends('layouts.app')

@section('header')
    <x-page-header title="マイページ"></x-page-header>
@endsection

@section('content')
<div class="flex flex-col px-4 pb-32 space-y-4">

    {{-- 1. ユーザープロフィールカード --}}
    <a href="{{ route('profile.edit') }}"
    class="w-full rounded-2xl p-5 shadow-sm border border-[#E0D4C0] flex items-center gap-4 active:bg-[#F6F2EC] transition-colors"
    style="background:#fff;">
        <div class="w-14 h-14 rounded-full flex items-center justify-center text-xl font-bold text-white flex-shrink-0"
            style="background:#E8A030;">
            {{ mb_substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-serif font-bold text-[#2E1A08]">{{ Auth::user()->name }}</h3>
            <p class="text-[10px] text-[#9A8A7A] tracking-widest uppercase">Itowokashi Member</p>
        </div>
        <svg class="w-4 h-4 text-[#E0D4C0] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>


    {{-- 2. メニュー --}}
    <div class="w-full rounded-2xl shadow-sm border border-[#E0D4C0] overflow-hidden" style="background:#fff;">
        <a href="{{ route('invitations.show') }}" class="flex items-center justify-between px-5 py-4 active:bg-[#F6F2EC] transition-colors">
            <span class="text-sm font-bold text-[#2E1A08]">招待コードで辞書に参加</span>
            <svg class="w-4 h-4 text-[#E0D4C0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- 3. スタッツ --}}
    <div class="grid grid-cols-3 gap-3">
        <div class="rounded-2xl p-4 text-center shadow-sm border border-[#E0D4C0]" style="background:#fff;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#E8A030" viewBox="0 0 256 256" class="mx-auto mb-1">
                <path d="M231.65,194.55,198.46,36.75a16,16,0,0,0-19-12.39L132.65,34.42a16.08,16.08,0,0,0-12.3,19l33.19,157.8A16,16,0,0,0,169.16,224a16.25,16.25,0,0,0,3.38-.36l46.81-10.06A16.09,16.09,0,0,0,231.65,194.55ZM136,50.15c0-.06,0-.09,0-.09l46.8-10,3.33,15.87L139.33,66Zm6.62,31.47,46.82-10.05,3.34,15.9L146,97.53Zm6.64,31.57,46.82-10.06,13.3,63.24-46.82,10.06ZM216,197.94l-46.8,10-3.33-15.87L212.67,182,216,197.85C216,197.91,216,197.94,216,197.94ZM104,32H56A16,16,0,0,0,40,48V208a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V48A16,16,0,0,0,104,32ZM56,48h48V64H56Zm0,32h48v96H56Zm48,128H56V192h48v16Z"></path>
            </svg>
            <p class="text-2xl font-bold text-[#2E1A08]">{{ $dictCount }}</p>
            <p class="text-[10px] text-[#9A8A7A]">辞書</p>
        </div>
        <div class="rounded-2xl p-4 text-center shadow-sm border border-[#E0D4C0]" style="background:#fff;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#E8A030" viewBox="0 0 256 256" class="mx-auto mb-1">
                <path d="M248,92.68a15.86,15.86,0,0,0-4.69-11.31L174.63,12.68a16,16,0,0,0-22.63,0L123.57,41.11l-58,21.77A16.06,16.06,0,0,0,55.35,75.23L32.11,214.68A8,8,0,0,0,40,224a8.4,8.4,0,0,0,1.32-.11l139.44-23.24a16,16,0,0,0,12.35-10.17l21.77-58L243.31,104A15.87,15.87,0,0,0,248,92.68Zm-69.87,92.19L63.32,204l47.37-47.37a28,28,0,1,0-11.32-11.32L52,192.7,71.13,77.86,126,57.29,198.7,130ZM112,132a12,12,0,1,1,12,12A12,12,0,0,1,112,132Zm96-15.32L139.31,48l24-24L232,92.68Z"/>
            </svg>
            <p class="text-2xl font-bold text-[#2E1A08]">{{ $wordCount }}</p>
            <p class="text-[10px] text-[#9A8A7A]">言葉</p>
        </div>
        <div class="rounded-2xl p-4 text-center shadow-sm border border-[#E0D4C0]" style="background:#fff;">
            <div class="flex items-center justify-center mb-1" style="height:24px;">
                <span class="font-bold" style="color:#E8A030; font-size:20px; line-height:1;">✦</span>
            </div>
            <p class="text-2xl font-bold text-[#2E1A08]">{{ $reactionCount }}</p>
            <p class="text-[10px] text-[#9A8A7A]">をかし</p>
        </div>
    </div>

    {{-- 4. 最近の活動 --}}
        @if($recentWords->count() > 0)
    <div>
        <p class="text-sm font-bold text-[#2E1A08] mb-3">最近の活動</p>
        <div class="flex flex-col gap-2">
            @foreach($recentWords as $word)
            <a href="{{ route('dictionaries.words.show', [$word->dictionary_id, $word->id]) }}"
            class="block rounded-xl px-4 py-3 border border-[#E0D4C0] active:bg-[#F6F2EC] transition-colors"
            style="background:#fff;">
                <p class="text-[10px] text-[#9A8A7A] mb-0.5">{{ $word->created_at->format('Y年n月j日') }}</p>
                <p class="text-sm text-[#2E1A08]">
                    「{{ $word->dictionary->title }}」に「{{ $word->headword }}」を追加しました
                </p>
            </a>
            @endforeach
        </div>
    </div>
    @endif


    {{-- 5. ログアウト --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full py-4 text-xs font-bold text-[#9A8A7A] underline decoration-[#E0D4C0]">
            ログアウトする
        </button>
    </form>

</div>
@endsection