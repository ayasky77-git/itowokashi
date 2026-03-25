@props(['dictionary', 'index' => 0])

@php
    $defaultColors = ['#E8A030','#D46B3A','#6FA8C4','#7FAF82','#8A7E9A','#C4A46A','#C46A7A','#5A8A90'];
    $color = $dictionary->color_code ?: $defaultColors[$index % count($defaultColors)];
    $count = $dictionary->words()->count();
    $width = match(true) {
        $count >= 30 => 84,
        $count >= 20 => 72,
        $count >= 10 => 60,
        $count >= 1  => 48,
        default      => 36,
    };
    $totalReactions = \App\Models\WordReaction::whereHas('word', fn($q) => $q->where('dictionary_id', $dictionary->id))->count();
    $recentReactions = \App\Models\WordReaction::whereHas('word', fn($q) => $q->where('dictionary_id', $dictionary->id))->where('created_at', '>=', now()->subDays(30))->count();
    $hasNewWord = $dictionary->words()->where('created_at', '>=', now()->subDays(7))->exists();
    $obi = match(true) {
        $totalReactions >= 100                         => ['label' => '殿堂', 'bg' => '#E8A030'],
        $recentReactions >= 5                          => ['label' => '話題', 'bg' => '#C46A7A'],
        $hasNewWord                                    => ['label' => 'NEW',  'bg' => '#6FA8C4'],
        $dictionary->created_at >= now()->subDays(30)  => ['label' => '新刊', 'bg' => '#7FAF82'],
        default                                        => null,
    };

    $pattern = $dictionary->spine_pattern ?? 'none';

@endphp

<a href="{{ route('dictionaries.show', $dictionary) }}"
   class="flex flex-col justify-start items-center shrink-0 no-underline transition-transform hover:-translate-y-1 relative overflow-hidden"
   style="width:{{ $width }}px; min-width:{{ $width }}px; max-width:{{ $width }}px; height:280px; background:{{ $color }}; border-radius:6px 2px 2px 6px; padding:8px 6px; box-shadow: 3px 3px 10px rgba(0,0,0,0.22), inset -2px 0 4px rgba(0,0,0,0.12);">
    <x-dict-pattern :pattern="$pattern" />
    <span class="font-serif mb-1 overflow-hidden"
          style="writing-mode:vertical-rl; font-size:16px; color:rgba(255,255,255,0.92); letter-spacing:0.06em; max-height:220px; padding:4px 0px;">
        {{ $dictionary->title }}
    </span>
    @if($obi)
        <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center py-1"
             style="background:{{ $obi['bg'] }};">
            <span style="writing-mode:vertical-rl; font-size:12px; color:#fff; letter-spacing:0.06em; font-weight:bold; height:50px; padding:4px 0px;">
                {{ $obi['label'] }}
            </span>
        </div>
    @endif
</a>