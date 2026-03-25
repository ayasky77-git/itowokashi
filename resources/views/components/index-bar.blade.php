@props(['dictionary', 'currentInitial' => ''])

@php
    $indexChars = ['全','あ','か','さ','た','な','は','ま','や','ら','わ','他'];

    $rowMap = [
        'あ' => ['あ','い','う','え','お'],
        'か' => ['か','き','く','け','こ'],
        'さ' => ['さ','し','す','せ','そ'],
        'た' => ['た','ち','つ','て','と'],
        'な' => ['な','に','ぬ','ね','の'],
        'は' => ['は','ひ','ふ','へ','ほ'],
        'ま' => ['ま','み','む','め','も'],
        'や' => ['や','ゆ','よ'],
        'ら' => ['ら','り','る','れ','ろ'],
        'わ' => ['わ','を','ん'],
    ];

    $existingInitials = $dictionary->words()
        ->where('status', 'published')
        ->pluck('initial_char')
        ->unique()
        ->toArray();

    $hasWords = function($char) use ($existingInitials, $rowMap) {
        if ($char === '全') return count($existingInitials) > 0;
        if ($char === '他') {
            $kanaAll = array_merge(...array_values($rowMap));
            foreach ($existingInitials as $i) {
                if (!in_array($i, $kanaAll)) return true;
            }
            return false;
        }
        $chars = $rowMap[$char] ?? [$char];
        foreach ($chars as $c) {
            if (in_array($c, $existingInitials)) return true;
        }
        return false;
    };
@endphp

<div class="absolute right-0 top-0 flex flex-col gap-1 z-40">
    @foreach($indexChars as $char)
    @php
        $active = ($char === '全' && $currentInitial === '') || $currentInitial === $char;
        $enabled = $hasWords($char);
    @endphp
    @if($enabled)
        <a href="{{ route('dictionaries.words.index', $dictionary) }}?initial={{ $char === '全' ? '' : ($char === '他' ? 'other' : $char) }}"
        class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold transition-colors"
        style="
            background: {{ $active ? '#E8A030' : '#fff' }};
            color: {{ $active ? '#fff' : '#9A8A7A' }};
            border: 1px solid {{ $active ? '#E8A030' : '#E0D4C0' }};
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        ">
            {{ $char }}
        </a>
    @endif
    @endforeach
</div>