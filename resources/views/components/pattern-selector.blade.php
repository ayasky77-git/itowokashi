@props(['selected' => 'none'])

@php
    $patterns = [
        ['value' => 'none',        'label' => '無地',        'desc' => ''],
        ['value' => 'linen',       'label' => 'リネン',      'desc' => '布目のような細かい格子'],
        ['value' => 'canvas',      'label' => 'キャンバス',  'desc' => '粗い格子模様'],
        ['value' => 'herringbone', 'label' => 'ヘリンボーン','desc' => '矢羽根模様'],
        ['value' => 'stripe_h',    'label' => '横ストライプ','desc' => '水平線'],
        ['value' => 'stripe_v',    'label' => '縦ストライプ','desc' => '垂直線'],
        ['value' => 'dots',        'label' => 'ドット',      'desc' => '水玉模様'],
        ['value' => 'cross',       'label' => 'クロス',      'desc' => '十字模様'],
        ['value' => 'shippou',     'label' => '七宝',        'desc' => '和柄・七宝紋'],
        ['value' => 'ichimatsu',   'label' => '市松',        'desc' => '和柄・市松模様'],
    ];
@endphp

<div class="grid grid-cols-2 gap-2">
    @foreach($patterns as $p)
    <div class="pattern-option rounded-xl px-3 py-2.5 cursor-pointer"
         data-pattern="{{ $p['value'] }}"
         onclick="selectPattern('{{ $p['value'] }}')"
         style="border:1.5px solid {{ $selected === $p['value'] ? '#E8A030' : '#E0D4C0' }}; background:#fff;">
        <p class="text-sm font-bold text-[#2E1A08]">{{ $p['label'] }}</p>
        @if($p['desc'])
        <p class="text-[10px] text-[#9A8A7A]">{{ $p['desc'] }}</p>
        @endif
    </div>
    @endforeach
</div>

<script>
    const patternSvgs = {
        linen: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='60' height='60'><line x1='0' y1='0' x2='60' y2='0' stroke='white' stroke-width='1' opacity='0.15'/><line x1='0' y1='5' x2='60' y2='5' stroke='white' stroke-width='1' opacity='0.13'/><line x1='0' y1='10' x2='60' y2='10' stroke='white' stroke-width='1' opacity='0.17'/><line x1='0' y1='15' x2='60' y2='15' stroke='white' stroke-width='1' opacity='0.14'/><line x1='0' y1='20' x2='60' y2='20' stroke='white' stroke-width='1' opacity='0.16'/><line x1='0' y1='25' x2='60' y2='25' stroke='white' stroke-width='1' opacity='0.13'/><line x1='0' y1='30' x2='60' y2='30' stroke='white' stroke-width='1' opacity='0.15'/><line x1='0' y1='35' x2='60' y2='35' stroke='white' stroke-width='1' opacity='0.17'/><line x1='0' y1='40' x2='60' y2='40' stroke='white' stroke-width='1' opacity='0.14'/><line x1='0' y1='45' x2='60' y2='45' stroke='white' stroke-width='1' opacity='0.16'/><line x1='0' y1='50' x2='60' y2='50' stroke='white' stroke-width='1' opacity='0.13'/><line x1='0' y1='55' x2='60' y2='55' stroke='white' stroke-width='1' opacity='0.15'/><line x1='0' y1='0' x2='0' y2='60' stroke='white' stroke-width='1' opacity='0.07'/><line x1='7' y1='0' x2='7' y2='60' stroke='white' stroke-width='1' opacity='0.06'/><line x1='14' y1='0' x2='14' y2='60' stroke='white' stroke-width='1' opacity='0.08'/><line x1='21' y1='0' x2='21' y2='60' stroke='white' stroke-width='1' opacity='0.07'/><line x1='28' y1='0' x2='28' y2='60' stroke='white' stroke-width='1' opacity='0.06'/><line x1='35' y1='0' x2='35' y2='60' stroke='white' stroke-width='1' opacity='0.08'/><line x1='42' y1='0' x2='42' y2='60' stroke='white' stroke-width='1' opacity='0.07'/><line x1='49' y1='0' x2='49' y2='60' stroke='white' stroke-width='1' opacity='0.06'/><line x1='56' y1='0' x2='56' y2='60' stroke='white' stroke-width='1' opacity='0.08'/></svg>\")",
        canvas: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='48' height='48'><line x1='0' y1='0' x2='48' y2='0' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='0' y1='8' x2='48' y2='8' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='0' y1='16' x2='48' y2='16' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='0' y1='24' x2='48' y2='24' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='0' y1='32' x2='48' y2='32' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='0' y1='40' x2='48' y2='40' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='0' y1='0' x2='0' y2='48' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='8' y1='0' x2='8' y2='48' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='16' y1='0' x2='16' y2='48' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='24' y1='0' x2='24' y2='48' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='32' y1='0' x2='32' y2='48' stroke='white' stroke-width='1.5' opacity='0.16'/><line x1='40' y1='0' x2='40' y2='48' stroke='white' stroke-width='1.5' opacity='0.16'/></svg>\")",
        herringbone: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='128' height='128'><line x1='0' y1='128' x2='128' y2='0' stroke='white' stroke-width='1.5' opacity='0.17'/><line x1='-32' y1='128' x2='96' y2='0' stroke='white' stroke-width='1.5' opacity='0.17'/><line x1='32' y1='128' x2='160' y2='0' stroke='white' stroke-width='1.5' opacity='0.17'/><line x1='0' y1='0' x2='128' y2='128' stroke='white' stroke-width='1' opacity='0.09'/><line x1='-32' y1='0' x2='96' y2='128' stroke='white' stroke-width='1' opacity='0.09'/><line x1='32' y1='0' x2='160' y2='128' stroke='white' stroke-width='1' opacity='0.09'/></svg>\")",
        stripe_h: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='128'><line x1='0' y1='10' x2='200' y2='10' stroke='white' stroke-width='2' opacity='0.14'/><line x1='0' y1='28' x2='200' y2='28' stroke='white' stroke-width='3' opacity='0.16'/><line x1='0' y1='46' x2='200' y2='46' stroke='white' stroke-width='2' opacity='0.15'/><line x1='0' y1='64' x2='200' y2='64' stroke='white' stroke-width='3' opacity='0.18'/><line x1='0' y1='82' x2='200' y2='82' stroke='white' stroke-width='2' opacity='0.14'/><line x1='0' y1='100' x2='200' y2='100' stroke='white' stroke-width='3' opacity='0.16'/><line x1='0' y1='118' x2='200' y2='118' stroke='white' stroke-width='2' opacity='0.15'/></svg>\")",
        stripe_v: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='56' height='200'><line x1='8' y1='0' x2='8' y2='200' stroke='white' stroke-width='2' opacity='0.14'/><line x1='19' y1='0' x2='19' y2='200' stroke='white' stroke-width='3' opacity='0.16'/><line x1='30' y1='0' x2='30' y2='200' stroke='white' stroke-width='2' opacity='0.15'/><line x1='41' y1='0' x2='41' y2='200' stroke='white' stroke-width='3' opacity='0.18'/><line x1='52' y1='0' x2='52' y2='200' stroke='white' stroke-width='2' opacity='0.14'/></svg>\")",
        dots: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='21'><circle cx='12' cy='5.5' r='2.5' fill='white' fill-opacity='0.22'/><circle cx='0' cy='15.5' r='2.5' fill='white' fill-opacity='0.22'/><circle cx='24' cy='15.5' r='2.5' fill='white' fill-opacity='0.22'/></svg>\")",
        cross: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='21'><rect x='9' y='2.5' width='6' height='1' fill='white' fill-opacity='0.28'/><rect x='11.5' y='0' width='1' height='6' fill='white' fill-opacity='0.28'/><rect x='9' y='12.5' width='6' height='1' fill='white' fill-opacity='0.28'/><rect x='11.5' y='10' width='1' height='6' fill='white' fill-opacity='0.28'/></svg>\")",
        shippou: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='8' height='8'><circle cx='0' cy='0' r='8' fill='none' stroke='white' stroke-width='0.8' stroke-opacity='0.20'/><circle cx='8' cy='0' r='8' fill='none' stroke='white' stroke-width='0.8' stroke-opacity='0.20'/><circle cx='0' cy='8' r='8' fill='none' stroke='white' stroke-width='0.8' stroke-opacity='0.20'/><circle cx='8' cy='8' r='8' fill='none' stroke='white' stroke-width='0.8' stroke-opacity='0.20'/></svg>\")",
        ichimatsu: "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10'><rect x='0' y='0' width='5' height='5' fill='white' fill-opacity='0.18'/><rect x='5' y='5' width='5' height='5' fill='white' fill-opacity='0.18'/></svg>\")",
    };

    function selectPattern(pattern) {
        document.getElementById('patternInput').value = pattern;
        const patternEl = document.getElementById('preview-pattern');
        if (patternEl) patternEl.style.backgroundImage = patternSvgs[pattern] || 'none';
        document.querySelectorAll('.pattern-option').forEach(el => {
            el.style.border = '1.5px solid #E0D4C0';
        });
        const selected = document.querySelector(`.pattern-option[data-pattern="${pattern}"]`);
        if (selected) selected.style.border = '1.5px solid #E8A030';
    }
</script>