@props(['word', 'showReaction' => true])

@php
    $data = is_string($word->dictionary_data)
        ? json_decode($word->dictionary_data, true)
        : (array)$word->dictionary_data;
    $meaning  = $data['meaning']  ?? null;
    $origin   = $data['origin']   ?? null;
    $example  = $data['example']  ?? null;
    $partOfSpeech = $data['part_of_speech']  ?? null;
    $reacted = auth()->check()
        ? $word->reactions()->where('user_id', auth()->id())->whereDate('reacted_on', today())->exists()
        : false;
    $reactionCount = $word->reactions()->count();
@endphp

<div class="rounded-2xl px-6 py-8 relative overflow-hidden"
     style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.07);">

    {{-- クリッカブルな上部エリア --}}
    <a href="{{ route('dictionaries.words.show', [$word->dictionary_id, $word->id]) }}" class="block no-underline">

        {{-- 辞書名バッジ --}}
        @if($word->dictionary)
        <span class="inline-block text-[10px] text-[#9A8A7A] rounded-full px-3 py-0.5 mb-2"
            style="background:#F2E8D8;">
            {{ $word->dictionary->title }}
        </span>
        @endif

        {{-- 見出し語 --}}
        <h2 class="font-serif text-3xl font-bold text-[#2E1A08] tracking-wider mb-2">
            {{ $word->headword }}
        </h2>
        <p class="text-xs text-[#9A8A7A] tracking-widest mb-2">【{{ $word->reading }}】</p>

        {{-- 品詞 --}}
        @if($partOfSpeech)
        <span class="inline-block text-[10px] font-bold text-[#E8A030] border border-[#E8A030] rounded px-2 py-0.5 mb-2">
            {{ $partOfSpeech }}
        </span>
        @endif

        <hr class="border-[#E0D4C0] mb-4">

        {{-- 意味 --}}
        @if($meaning)
        <p class="text-[10px] font-bold text-[#E8A030] tracking-widest mb-1">意　味</p>
        <p class="text-sm text-[#2E1A08] leading-relaxed mb-4">{{ $meaning }}</p>
        @endif

        {{-- 語源 --}}
        @if($origin)
        <p class="text-[10px] font-bold text-[#E8A030] tracking-widest mb-1">語　源</p>
        <p class="text-sm text-[#2E1A08] leading-relaxed mb-4">{{ $origin }}</p>
        @endif

        {{-- 用例 --}}
        @if($example)
        <p class="text-[10px] font-bold text-[#E8A030] tracking-widest mb-1">用　例</p>
        <p class="text-xs text-[#665A50] leading-relaxed mb-4">「{{ is_array($example) ? implode('', $example) : $example }}」</p>
        @endif
    </a>

    {{-- をかしボタン --}}
    <div class="text-center mt-6" onclick="event.stopPropagation();">
    @if($showReaction && auth()->check())
    <form id="reaction-form-{{ $word->id }}" method="POST" 
      action="{{ route('reactions.store', ['dictionary' => $word->dictionary_id, 'word' => $word->id]) }}">
        @csrf
        <button type="button" id="reaction-btn-{{ $word->id }}"
                onclick="toggleReaction({{ $word->id }})"
                class="inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-sm font-bold text-white min-w-[140px]"
                style="background:{{ $reacted ? '#C8A878' : '#E8A030' }};">
            ✦ {{ $reacted ? 'をかし済み' : 'をかし' }}
        </button>
    </form>
    <p id="reaction-count-{{ $word->id }}" class="text-[11px] text-[#9A8A7A] mt-2">{{ $reactionCount }}人がをかしと感じています</p>    @endif
    </div>

<script>
    async function toggleReaction(wordId) {
        const form = document.getElementById('reaction-form-' + wordId);
        const btn = document.getElementById('reaction-btn-' + wordId);
        const res = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await res.json();
        btn.style.background = data.reacted ? '#C8A878' : '#E8A030';
        btn.textContent = data.reacted ? '✦ をかし済み' : '✦ をかし';
        document.getElementById('reaction-count-' + wordId).textContent = data.count + '人がをかしと感じています';
    }
</script>
</div>
