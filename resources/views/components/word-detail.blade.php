@props(['word', 'dictionary', 'showNav' => true])

@php
    $data = is_string($word->dictionary_data)
        ? json_decode($word->dictionary_data, true)
        : (array)($word->dictionary_data ?? []);
    $meaning      = $data['meaning']         ?? null;
    $origin       = $data['origin']          ?? null;
    $example      = $data['example']         ?? null;
    $synonyms     = $data['synonyms']        ?? [];
    $antonyms     = $data['antonyms']        ?? [];
    $partOfSpeech = $data['part_of_speech']  ?? null;
    $firstAppeared = $data['first_appeared'] ?? null;

    $reacted = auth()->check()
        ? $word->reactions()->where('user_id', auth()->id())->whereDate('reacted_on', today())->exists()
        : false;
    $reactionCount = $word->reactions()->count();

    $words = \App\Models\Word::where('dictionary_id', $dictionary->id)
        ->where('status', 'published')
        ->orderBy('reading')
        ->get();
    $currentIndex = $words->search(fn($w) => $w->id === $word->id);
    $prevWord = $currentIndex > 0 ? $words[$currentIndex - 1] : null;
    $nextWord = $currentIndex < $words->count() - 1 ? $words[$currentIndex + 1] : null;
@endphp

<div class="rounded-2xl px-6 py-8 mb-4 relative overflow-hidden"
     style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.07);">

    {{-- 見出し語 --}}
    <div class="flex items-baseline gap-3 mb-1">
        <h1 class="font-serif text-3xl font-bold text-[#2E1A08]">{{ $word->headword }}</h1>
        <span class="text-sm text-[#9A8A7A]">【{{ $word->reading }}】</span>
    </div>

    {{-- 品詞 --}}
    @if($partOfSpeech)
    <span class="inline-block text-[10px] font-bold text-[#E8A030] border border-[#E8A030] rounded px-2 py-0.5 mb-3">
        【{{ $partOfSpeech }}】
    </span>
    @endif

    {{-- 登録者・日付 --}}
    <div class="flex items-center gap-2 mb-4 text-xs text-[#9A8A7A]">
        @if($word->user)
        <span>{{ $word->user->name }}</span>
        <span>•</span>
        @endif
        @if($firstAppeared)
        <span>{{ $firstAppeared }}</span>
        @elseif($word->created_at)
        <span>{{ $word->created_at->format('Y-m-d') }}</span>
        @endif
    </div>

    <hr class="border-[#E0D4C0] mb-5">

    @if($meaning)
    <div class="mb-5">
        <p class="text-[11px] font-bold text-[#E8A030] tracking-widest mb-2">【意味】</p>
        <p class="text-sm text-[#2E1A08] leading-relaxed pl-4">{{ $meaning }}</p>
    </div>
    @endif

    @if($origin)
    <div class="mb-5">
        <p class="text-[11px] font-bold text-[#E8A030] tracking-widest mb-2">【語源】</p>
        <p class="text-sm text-[#2E1A08] leading-relaxed pl-4">{{ $origin }}</p>
    </div>
    @endif

    @if($example)
    <div class="mb-5">
        <p class="text-[11px] font-bold text-[#E8A030] tracking-widest mb-2">【用例】</p>
        <p class="text-sm text-[#665A50] leading-relaxed pl-4">「{{ $example }}」</p>
    </div>
    @endif

    @if(!empty($synonyms) || !empty($antonyms))
    <div class="mb-5">
        <p class="text-[11px] font-bold text-[#E8A030] tracking-widest mb-2">【関連語】</p>
        <div class="flex flex-wrap gap-2 pl-4">
            @foreach($synonyms as $s)
            <span class="text-xs text-[#2E1A08] border border-[#E0D4C0] rounded-full px-3 py-1">{{ $s }}</span>
            @endforeach
            @foreach($antonyms as $a)
            <span class="text-xs text-[#9A8A7A] border border-[#E0D4C0] rounded-full px-3 py-1">{{ $a }}</span>
            @endforeach
        </div>
    </div>
    @endif

    @if($word->tags->count() > 0)
    <div class="flex flex-wrap gap-2 mb-4">
        @foreach($word->tags as $tag)
        <span class="text-xs text-[#9A8A7A] bg-[#F2E8D8] rounded-full px-3 py-1"># {{ $tag->name }}</span>
        @endforeach
    </div>
    @endif

    @if($word->image_path)
    <img src="{{ asset('storage/' . $word->image_path) }}"
         class="w-full rounded-xl mb-4 object-cover" style="max-height:200px;">
    @endif

</div>

{{-- 前後ナビ＋をかしボタン --}}
@if($showNav)
<div class="fixed bottom-14 left-1/2 -translate-x-1/2 w-full max-w-[390px] px-4 py-2 my-3 flex items-center justify-between"
     style="background:rgba(254,248,240,0.95);">
    <a href="{{ $prevWord ? route('dictionaries.words.show', [$dictionary, $prevWord]) : '#' }}"
       class="text-sm text-[#9A8A7A] {{ !$prevWord ? 'opacity-30 pointer-events-none' : '' }}">
        ‹ 前
    </a>
    <form method="POST" action="{{ route('reactions.store', ['dictionary' => $word->dictionary_id, 'word' => $word->id]) }}">
        @csrf
        <button type="submit"
                class="flex items-center gap-2 rounded-full px-5 py-2 text-sm font-bold"
                style="background:{{ $reacted ? '#F2E8D8' : '#FEF8F0' }}; color:{{ $reacted ? '#E8A030' : '#9A8A7A' }}; border:1.5px solid {{ $reacted ? '#E8A030' : '#E0D4C0' }}; box-shadow:0 2px 8px rgba(0,0,0,0.10);">
            ✦ {{ $reactionCount }} をかし
        </button>
    </form>
    <a href="{{ $nextWord ? route('dictionaries.words.show', [$dictionary, $nextWord]) : '#' }}"
       class="text-sm text-[#9A8A7A] {{ !$nextWord ? 'opacity-30 pointer-events-none' : '' }}">
        次 ›
    </a>
</div>
@endif