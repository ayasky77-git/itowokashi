@extends('layouts.app')

@section('header')
    <x-page-header title="検索" />
@endsection

@section('content')
    {{-- 検索フォーム：編集画面の入力欄と同じスタイル --}}
    <form action="{{ route('search.index') }}" method="GET" class="mt-6 mb-8">
        <label class="text-sm font-bold text-[#2E1A08] mb-2 block">検索ワード</label>
        <div class="flex gap-2">
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                placeholder="例：しもやけ"
                class="flex-1 rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none"
                style="background:#fff; border:1px solid #E0D4C0;">
            
            <button type="submit" 
                class="rounded-lg px-5 py-2.5 text-sm font-bold shadow-sm active:opacity-80 transition-opacity"
                style="background:#E8A030; color:#fff;">
                検索
            </button>
        </div>
    </form>
    
    {{-- 検索結果セクション --}}
    @if(request('keyword'))
        <div class="mb-4 px-1">
            <p class="text-[10px] font-bold text-[#E8A030] tracking-widest uppercase">Search Results</p>
            <p class="text-sm text-[#9A8A7A]">「{{ request('keyword') }}」の結果：{{ $search->count() }}件</p>
        </div>
    @endif

    <div class="space-y-3 mb-10">
        @forelse($search as $word)
            {{-- 結果リスト：編集画面のカードと同じスタイル --}}
            <a href="{{ route('dictionaries.words.show', [$word->dictionary_id, $word->id]) }}" 
               class="block rounded-xl px-4 py-4 shadow-sm active:scale-[0.98] transition-transform"
               style="background:#fff; border:1px solid #E0D4C0;">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-[10px] font-bold text-[#C8A878] mb-0.5">{{ $word->reading }}</p>
                        <h3 class="text-base font-serif font-bold text-[#2E1A08]">{{ $word->headword }}</h3>
                    </div>
                    <div class="text-[#E0D4C0]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5 7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            @if(request('keyword'))
                <div class="py-12 text-center">
                    <p class="text-sm text-[#9A8A7A] italic">その言葉は、まだこの辞書には載っていないようです。</p>
                </div>
            @endif
        @endforelse
    </div>
@endsection