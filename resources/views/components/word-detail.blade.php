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
    $prevWord = ($currentIndex !== false && $currentIndex > 0) ? $words[$currentIndex - 1] : null;
    $nextWord = ($currentIndex !== false && $currentIndex < $words->count() - 1) ? $words[$currentIndex + 1] : null;
    $nickname = \App\Models\DictionaryUser::where('dictionary_id', $dictionary->id)
        ->where('user_id', $word->user_id)
        ->value('nickname') ?? $word->user?->name;
    $editorNickname = $word->lastEditor 
        ? (\App\Models\DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', $word->lastEditor->id)
            ->value('nickname') ?? $word->lastEditor->name)
        : null;
@endphp

<div class="rounded-2xl mt-4 px-6 py-8 mb-4 relative overflow-hidden"
     style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.07);">

    {{-- 見出し語 --}}
    <div class="flex items-baseline gap-3 mb-2">
        <h1 class="font-serif text-3xl font-bold text-[#2E1A08]">{{ $word->headword }}</h1>
    </div>
    <p class="text-xs text-[#9A8A7A] tracking-widest mb-2">【{{ $word->reading }}】</p>

    {{-- 品詞 --}}
    @if($partOfSpeech)
        <span class="inline-block text-[10px] font-bold text-[#E8A030] border border-[#E8A030] rounded px-2 py-0.5 mb-2">
            {{ $partOfSpeech }}
        </span>
    @endif

    {{-- 登録者・日付 --}}
    <div class="mb-4 text-xs text-[#9A8A7A]">
        @if($word->user)
        <div>作成：{{ $nickname }} / {{ $word->created_at->format('Y-m-d') }}</div>
        @endif
        @if($word->lastEditor && $word->lastEditor->id !== $word->user?->id)
        <div>更新：{{ $editorNickname }} / {{ $word->updated_at->format('Y-m-d') }}</div>
        @endif
    </div>

    <hr class="border-[#E0D4C0] mb-5">

    @if($word->image_path)
    <img src="{{ asset('storage/' . $word->image_path) }}"
        class="rounded-xl mb-4 block mx-auto"
        style="max-width:100%; height:auto;">
    @endif

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
        <p class="text-sm text-[#665A50] leading-relaxed pl-4">{{ is_array($example) ? implode('', $example) : $example }}</p>
    </div>
    @endif

    @if(!empty($synonyms) || !empty($antonyms))
    @php
        $linkedSynonyms = collect($synonyms)->map(fn($s) => [
            'label' => $s,
            'word' => \App\Models\Word::where('dictionary_id', $dictionary->id)->where('headword', $s)->where('status', 'published')->first()
        ])->filter(fn($s) => $s['word']);

        $linkedAntonyms = collect($antonyms)->map(fn($a) => [
            'label' => $a,
            'word' => \App\Models\Word::where('dictionary_id', $dictionary->id)->where('headword', $a)->where('status', 'published')->first()
        ])->filter(fn($a) => $a['word']);
    @endphp

    @if($linkedSynonyms->count() > 0 || $linkedAntonyms->count() > 0)
    <div class="mb-5">
        <p class="text-[11px] font-bold text-[#E8A030] tracking-widest mb-2">【関連語】</p>
        <div class="flex flex-wrap gap-2 pl-4">
            @foreach($linkedSynonyms as $s)
            <a href="{{ route('dictionaries.words.show', [$dictionary, $s['word']]) }}"
            class="text-xs text-[#E8A030] border border-[#E8A030] rounded-full px-3 py-1">
                {{ $s['label'] }}
            </a>
            @endforeach
            @foreach($linkedAntonyms as $a)
            <a href="{{ route('dictionaries.words.show', [$dictionary, $a['word']]) }}"
            class="text-xs text-[#9A8A7A] border border-[#9A8A7A] rounded-full px-3 py-1">
                {{ $a['label'] }}
            </a>
            @endforeach
        </div>
    </div>
    @endif
    @endif

    @if($word->tags->count() > 0)
    <div class="flex flex-wrap gap-2 mb-4">
        @foreach($word->tags as $tag)
        <span class="text-xs text-[#9A8A7A] bg-[#F2E8D8] rounded-full px-3 py-1"># {{ $tag->name }}</span>
        @endforeach
    </div>
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
    <form id="reaction-form-detail" method="POST" action="{{ route('reactions.store', ['dictionary' => $word->dictionary_id, 'word' => $word->id]) }}">
        @csrf
        <button type="button" id="reaction-btn-detail"
                onclick="toggleReactionDetail()"
                class="flex items-center gap-2 rounded-full px-5 py-2 text-sm font-bold"
                style="background:{{ $reacted ? '#F2E8D8' : '#FEF8F0' }}; color:{{ $reacted ? '#E8A030' : '#9A8A7A' }}; border:1.5px solid {{ $reacted ? '#E8A030' : '#E0D4C0' }}; box-shadow:0 2px 8px rgba(0,0,0,0.10);">
            ✦ <span id="reaction-count-detail">{{ $reactionCount }}</span> をかし
        </button>
    </form>
    <a href="{{ $nextWord ? route('dictionaries.words.show', [$dictionary, $nextWord]) : '#' }}"
       class="text-sm text-[#9A8A7A] {{ !$nextWord ? 'opacity-30 pointer-events-none' : '' }}">
        次 ›
    </a>
</div>
@endif

<script>
async function toggleReactionDetail() {
    const form = document.getElementById('reaction-form-detail');
    const btn = document.getElementById('reaction-btn-detail');
    const res = await fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
    const data = await res.json();
    document.getElementById('reaction-count-detail').textContent = data.count;
    btn.style.background = data.reacted ? '#F2E8D8' : '#FEF8F0';
    btn.style.color = data.reacted ? '#E8A030' : '#9A8A7A';
    btn.style.borderColor = data.reacted ? '#E8A030' : '#E0D4C0';
}
</script>