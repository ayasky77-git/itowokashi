@props(['word', 'showReaction' => true])

@php
    $data = is_string($word->dictionary_data)
        ? json_decode($word->dictionary_data, true)
        : (array)$word->dictionary_data;
    $meaning  = $data['meaning']  ?? null;
    $origin   = $data['origin']   ?? null;
    $example  = $data['example']  ?? null;
    $reacted = auth()->check()
        ? $word->reactions()->where('user_id', auth()->id())->whereDate('reacted_on', today())->exists()
        : false;
    $reactionCount = $word->reactions()->count();
@endphp

<div class="rounded-2xl px-6 py-8 relative overflow-hidden"
     style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.07);">

    {{-- 辞書名バッジ --}}
    @if($word->dictionary)
    <span class="inline-block text-[10px] text-[#9A8A7A] rounded-full px-3 py-0.5 mb-4"
          style="background:#F2E8D8;">
        {{ $word->dictionary->title }}
    </span>
    @endif

    {{-- 見出し語 --}}
    <h2 class="font-serif text-3xl font-bold text-[#2E1A08] tracking-wider mb-1">
        {{ $word->headword }}
    </h2>
    <p class="text-xs text-[#9A8A7A] tracking-widest mb-5">【{{ $word->reading }}】</p>

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
    <p class="text-xs text-[#665A50] leading-relaxed mb-4">「{{ $example }}」</p>
    @endif

    {{-- をかしボタン --}}
    @if($showReaction && auth()->check())
    <div class="text-center mt-6">
        <form method="POST" action="{{ route('reactions.store', ['dictionary' => $word->dictionary_id, 'word' => $word->id]) }}">
            @csrf
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-sm font-bold text-white"
                    style="background:{{ $reacted ? '#C8A878' : '#E8A030' }};">
                ✦ をかし
            </button>
        </form>
        <p class="text-[11px] text-[#9A8A7A] mt-2">{{ $reactionCount }}人がをかしと感じています</p>
    </div>
    @endif
</div>