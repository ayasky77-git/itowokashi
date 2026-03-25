@props(['selected' => '#E8A030'])

@php
    $colors = [
        ['value' => '#E8A030', 'label' => 'からし色'],
        ['value' => '#D46B3A', 'label' => 'テラコッタ'],
        ['value' => '#6FA8C4', 'label' => 'ノルディックブルー'],
        ['value' => '#7FAF82', 'label' => 'セージグリーン'],
        ['value' => '#8A7E9A', 'label' => 'ダスティラベンダー'],
        ['value' => '#C4A46A', 'label' => '麦色'],
        ['value' => '#C46A7A', 'label' => 'ローズ'],
        ['value' => '#5A8A90', 'label' => 'ティール'],
    ];
@endphp

<div class="grid grid-cols-4 gap-3">
    @foreach($colors as $c)
    <div class="color-option flex flex-col items-center cursor-pointer"
         data-color="{{ $c['value'] }}"
         onclick="selectColor('{{ $c['value'] }}')">
        <div class="w-full aspect-square rounded-lg mb-1 color-swatch"
             style="background:{{ $c['value'] }}; border:2px solid {{ $selected === $c['value'] ? $c['value'] : 'transparent' }}; outline:{{ $selected === $c['value'] ? '2px solid '.$c['value'] : 'none' }}; outline-offset:2px;">
        </div>
        <span class="text-[9px] text-center text-[#665A50]">{{ $c['label'] }}</span>
    </div>
    @endforeach
</div>