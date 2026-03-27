@extends('layouts.app')

@section('header')
    <div class="text-center mb-6 my-6">
        <h1 class="font-serif text-xl text-[#2E1A08] tracking-widest">イトヲカシ</h1>
        <p class="text-xs text-[#9A8A7A] mt-1">コミュニティ辞書</p>
    </div>
@endsection

@section('content')

    @php
        // 1行に表示する辞書数（56px + gap 6px = 約62px、棚幅約330pxで5冊）
        $perRow = 5;
        $rows = $dictionaries->chunk($perRow);
    @endphp

        @foreach($rows as $row)
        <div class="" style="
            padding: 16px 16px 0;
            background-color: #A67C52;">

            {{-- 上の棚板（最初の行のみ） --}}
            @if($loop->first)
            <div class="h-2.5 -mx-4 rounded" style="background:#C8A878; margin: 0px -16px 10px;"></div>
            @endif

            <div class="flex items-end gap-1.5">
                @foreach($row as $i => $dictionary)
                    <x-spine-card :dictionary="$dictionary" :index="$loop->parent->index * $perRow + $i" />
                @endforeach
            </div>

            {{-- 下の棚板 --}}
            <div class="h-2.5 -mx-4" style="background:#C8A878; margin: 4px -16px 0;"></div>
        </div>
    @endforeach

    <a href="{{ route('dictionaries.create') }}"
    class="flex items-center gap-2 w-full rounded-xl mt-4 px-4 py-3 text-[#9A8A7A] text-sm"
    style="background:#fff; border:1.5px dashed #E0D4C0;">
        <span class="w-5 h-5 rounded-full flex items-center justify-center text-white text-base leading-none"
            style="background:#E8A030;">+</span>
        新しい辞書をつくる
    </a>

@endsection