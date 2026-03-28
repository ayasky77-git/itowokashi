@extends('layouts.app')

@section('header')
    <x-page-header title="{{ $dictionary->title }}" :backUrl="route('dictionaries.show',$dictionary)" />
@endsection

@section('content')

@php
    $draftWords = \App\Models\Word::where('dictionary_id', $dictionary->id)
        ->where('status', 'draft')
        ->orderBy('reading')
        ->get();
@endphp

<div class="relative pr-10">

    <x-index-bar :dictionary="$dictionary" :currentInitial="$initial" />

    {{-- 下書きセクション --}}
    @if($draftWords->count() > 0 && $initial === '')
        <div class="rounded-xl mt-4 px-4 py-3 mb-6" style="background:#FEFBE8; border:1px solid #E8DC9A;">
            <p class="text-[10px] font-bold text-[#9A8A7A] tracking-widest mb-3">下書き</p>
            <div class="flex flex-col gap-2">
                @foreach($draftWords as $word)
                @php
                    $nickname = \App\Models\DictionaryUser::where('dictionary_id', $dictionary->id)
                        ->where('user_id', $word->user_id)
                        ->value('nickname') ?? $word->user?->name;
                @endphp
                <a href="{{ route('dictionaries.words.edit', [$dictionary, $word]) }}"
                class="flex items-center justify-between rounded-lg px-3 py-2.5 no-underline"
                style="background:#fff; border:1px solid #E0D4C0;">
                    <div>
                        <span class="font-serif text-sm font-bold text-[#2E1A08]">{{ $word->headword }}</span>
                            <div class="flex items-center gap-1 text-[10px] text-[#9A8A7A]">
                            @if($word->user)
                            <span>作成：{{ $nickname }}</span>
                            <span>/</span>
                            @endif
                            <span>{{ $word->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>
                    <span class="text-[#E0D4C0]">›</span>
                </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- 単語一覧 --}}
    @if($words->isEmpty())
        <div class="text-center py-16">
            <p class="text-sm text-[#9A8A7A]">該当する言葉がありません</p>
        </div>
    @else
    
    @php
        $grouped = $words->groupBy('initial_char');
    @endphp
    @foreach($grouped as $char => $groupWords)
        <div class="mb-6">
            {{-- 見出し文字 --}}
            <div class="flex items-center gap-3 mb-2">
                <span class="text-xs text-[#9A8A7A]">{{ $char }}</span>
                <div class="flex-1 h-px" style="background:#E0D4C0;"></div>
            </div>
            

            <div class="flex flex-col gap-2">
                @foreach($groupWords as $word)
                @php
                    $data = is_string($word->dictionary_data)
                        ? json_decode($word->dictionary_data, true)
                        : (array)($word->dictionary_data ?? []);

                    $nickname = \App\Models\DictionaryUser::where('dictionary_id', $dictionary->id)
                        ->where('user_id', $word->user_id)
                        ->value('nickname') ?? $word->user?->name;
                @endphp
                    <a href="{{ route('dictionaries.words.show', [$dictionary, $word]) }}"
                    class="rounded-xl px-4 py-3 no-underline"
                    style="background:#fff; box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                        <div class="flex items-baseline gap-2 mb-1">
                            <span class="font-serif text-base font-bold text-[#2E1A08]">{{ $word->headword }}</span>
                            <span class="text-[10px] text-[#9A8A7A]">【{{ $word->reading }}】</span>
                            @if(!empty($data['part_of_speech']))
                            <span class="text-[10px] text-[#E8A030] border border-[#E8A030] rounded px-1">{{ mb_substr($data['part_of_speech'], 0, 1) }}</span>                        
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-1 text-[10px] text-[#9A8A7A]">
                            @if($word->user)
                            <span>作成：{{ $nickname }}</span>
                            <span>/</span>
                            @endif
                            <span>{{ $word->created_at->format('Y-m-d') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif

</div>
@endsection