@props(['pattern' => 'none'])

@php
    $patternSvg = match($pattern) {
        // リネン：高密度の格子（JS版の数値を完全再現）
        'linen' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='60' height='60'><line x1='0' y1='0' x2='60' y2='0' stroke='white' stroke-width='1' opacity='0.15'/><line x1='0' y1='5' x2='60' y2='5' stroke='white' stroke-width='1' opacity='0.13'/><line x1='0' y1='10' x2='60' y2='10' stroke='white' stroke-width='1' opacity='0.17'/><line x1='0' y1='15' x2='60' y2='15' stroke='white' stroke-width='1' opacity='0.14'/><line x1='0' y1='20' x2='60' y2='20' stroke='white' stroke-width='1' opacity='0.16'/><line x1='0' y1='25' x2='60' y2='25' stroke='white' stroke-width='1' opacity='0.13'/><line x1='0' y1='30' x2='60' y2='30' stroke='white' stroke-width='1' opacity='0.15'/><line x1='0' y1='35' x2='60' y2='35' stroke='white' stroke-width='1' opacity='0.17'/><line x1='0' y1='40' x2='60' y2='40' stroke='white' stroke-width='1' opacity='0.14'/><line x1='0' y1='45' x2='60' y2='45' stroke='white' stroke-width='1' opacity='0.16'/><line x1='0' y1='50' x2='60' y2='50' stroke='white' stroke-width='1' opacity='0.13'/><line x1='0' y1='55' x2='60' y2='55' stroke='white' stroke-width='1' opacity='0.15'/><line x1='0' y1='0' x2='0' y2='60' stroke='white' stroke-width='1' opacity='0.07'/><line x1='7' y1='0' x2='7' y2='60' stroke='white' stroke-width='1' opacity='0.06'/><line x1='14' y1='0' x2='14' y2='60' stroke='white' stroke-width='1' opacity='0.08'/><line x1='21' y1='0' x2='21' y2='60' stroke='white' stroke-width='1' opacity='0.07'/><line x1='28' y1='0' x2='28' y2='60' stroke='white' stroke-width='1' opacity='0.06'/><line x1='35' y1='0' x2='35' y2='60' stroke='white' stroke-width='1' opacity='0.08'/><line x1='42' y1='0' x2='42' y2='60' stroke='white' stroke-width='1' opacity='0.07'/><line x1='49' y1='0' x2='49' y2='60' stroke='white' stroke-width='1' opacity='0.06'/><line x1='56' y1='0' x2='56' y2='60' stroke='white' stroke-width='1' opacity='0.08'/></svg>\")",

        // キャンバス：極細の格子
        'canvas' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12'><rect x='0' y='0' width='12' height='12' fill='none' stroke='white' stroke-width='0.15' opacity='0.8'/></svg>\")",

        // ヘリンボーン：シャープな矢羽根
        'herringbone' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24'><path d='M0 0 L12 12 L0 24 M12 0 L24 12 L12 24' fill='none' stroke='white' stroke-width='0.8' stroke-linecap='round' stroke-linejoin='round' opacity='0.12'/></svg>\")",

        // ストライプ横：リズムのある横線
        'stripe_h' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='128'><line x1='0' y1='10' x2='200' y2='10' stroke='white' stroke-width='2' opacity='0.14'/><line x1='0' y1='28' x2='200' y2='28' stroke='white' stroke-width='3' opacity='0.16'/><line x1='0' y1='46' x2='200' y2='46' stroke='white' stroke-width='2' opacity='0.15'/><line x1='0' y1='64' x2='200' y2='64' stroke='white' stroke-width='3' opacity='0.18'/><line x1='0' y1='82' x2='200' y2='82' stroke='white' stroke-width='2' opacity='0.14'/><line x1='0' y1='100' x2='200' y2='100' stroke='white' stroke-width='3' opacity='0.16'/><line x1='0' y1='118' x2='200' y2='118' stroke='white' stroke-width='2' opacity='0.15'/></svg>\")",

        // ストライプ縦：強弱のある縦線
        'stripe_v' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='56' height='200'><line x1='8' y1='0' x2='8' y2='200' stroke='white' stroke-width='2' opacity='0.14'/><line x1='19' y1='0' x2='19' y2='200' stroke='white' stroke-width='3' opacity='0.16'/><line x1='30' y1='0' x2='30' y2='200' stroke='white' stroke-width='2' opacity='0.15'/><line x1='41' y1='0' x2='41' y2='200' stroke='white' stroke-width='3' opacity='0.18'/><line x1='52' y1='0' x2='52' y2='200' stroke='white' stroke-width='2' opacity='0.14'/></svg>\")",

        // ドット：シンプルなあられ文様
        'dots' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='21'><circle cx='12' cy='5.5' r='2.5' fill='white' fill-opacity='0.22'/><circle cx='0' cy='15.5' r='2.5' fill='white' fill-opacity='0.22'/><circle cx='24' cy='15.5' r='2.5' fill='white' fill-opacity='0.22'/></svg>\")",

        // 十字：刺し子風の矩形
        'cross' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='21'><rect x='9' y='2.5' width='6' height='1' fill='white' fill-opacity='0.28'/><rect x='11.5' y='0' width='1' height='6' fill='white' fill-opacity='0.28'/><rect x='9' y='12.5' width='6' height='1' fill='white' fill-opacity='0.28'/><rect x='11.5' y='10' width='1' height='6' fill='white' fill-opacity='0.28'/></svg>\")",

        // 七宝：伝統的な幾何学
        'shippou' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32'><circle cx='16' cy='16' r='15.7' fill='none' stroke='white' stroke-width='0.4' opacity='0.12'/><circle cx='0' cy='0' r='15.7' fill='none' stroke='white' stroke-width='0.4' opacity='0.12'/><circle cx='32' cy='0' r='15.7' fill='none' stroke='white' stroke-width='0.4' opacity='0.12'/><circle cx='0' cy='32' r='15.7' fill='none' stroke='white' stroke-width='0.4' opacity='0.12'/><circle cx='32' cy='32' r='15.7' fill='none' stroke='white' stroke-width='0.4' opacity='0.12'/></svg>\")",

        // 市松：モダンな格子
        'ichimatsu' => "url(\"data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20'><rect x='0' y='0' width='10' height='10' fill='white' fill-opacity='0.1'/><rect x='10' y='10' width='10' height='10' fill='white' fill-opacity='0.1'/></svg>\")",

        default => 'none',
    };
@endphp

@if($patternSvg !== 'none')
    <div {{ $attributes }} style="position:absolute; inset:0; background-image:{{ $patternSvg }}; background-repeat:repeat; pointer-events:none;"></div>
@endif