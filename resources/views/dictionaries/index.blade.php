@extends('layouts.app')

@section('header')
    <div class="text-center mb-6 my-6">
        <h1 class="font-serif text-xl text-[#2E1A08] tracking-widest">イトヲカシ</h1>
        <p class="text-xs text-[#9A8A7A] mt-1">コミュニティ辞書</p>
    </div>
@endsection

@section('content')

    @php
        $defaultColors = ['#E8A030','#D46B3A','#6FA8C4','#7FAF82','#8A7E9A','#C4A46A','#C46A7A','#5A8A90'];
    @endphp

    <div class="rounded-b-xl pb-0 mb-6" style="
        padding: 16px 16px 0;
        background-color: #F2E8D8;2248%22 height=%2248%22><line x1=%220%22 y1=%220%22 x2=%2248%22 y2=%220%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%220%22 y1=%228%22 x2=%2248%22 y2=%228%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%220%22 y1=%2216%22 x2=%2248%22 y2=%2216%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%220%22 y1=%2224%22 x2=%2248%22 y2=%2224%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%220%22 y1=%2232%22 x2=%2248%22 y2=%2232%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%220%22 y1=%2240%22 x2=%2248%22 y2=%2240%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%220%22 y1=%220%22 x2=%220%22 y2=%2248%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%228%22 y1=%220%22 x2=%228%22 y2=%2248%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%2216%22 y1=%220%22 x2=%2216%22 y2=%2248%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%2224%22 y1=%220%22 x2=%2224%22 y2=%2248%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%2232%22 y1=%220%22 x2=%2232%22 y2=%2248%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /><line x1=%2240%22 y1=%220%22 x2=%2240%22 y2=%2248%22 stroke=%22%23C8A878%22 stroke-width=%221%22 /></svg>');
        background-repeat: repeat;
        background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%
    "> 

        <div class="h-2.5 -mx-4 rounded" style="background:#C8A878; margin: 10px -15px;"></div>

        <div class="flex items-end gap-1.5 flex-wrap">
            @foreach($dictionaries as $i => $dictionary)
                <x-spine-card :dictionary="$dictionary" :index="$i" />
            @endforeach
        </div>
        <div class="h-2.5 -mx-4 rounded" style="background:#C8A878; margin: 0px -15px;"></div>
    </div>

    <a href="{{ route('dictionaries.create') }}"
    class="flex items-center gap-2 w-full rounded-xl px-4 py-3 text-[#9A8A7A] text-sm"
    style="background:#fff; border:1.5px dashed #E0D4C0;">
        <span class="w-5 h-5 rounded-full flex items-center justify-center text-white text-base leading-none"
            style="background:#E8A030;">+</span>
        新しい辞書をつくる
    </a>

@endsection