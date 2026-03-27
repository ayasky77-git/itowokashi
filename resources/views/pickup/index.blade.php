@extends('layouts.app')

@section('content')
@if(auth()->check())
    @if($word)
        {{-- PickUPラベル --}}
        <p class="text-center text-[10px] font-bold tracking-[0.14em] text-[#9A8A7A] mb-6 my-6">✦ TODAY'S PICK UP</p>

        <x-word-card :word="$word" class="mb-4" />

        {{-- 別の言葉を見る --}}
        <a href="{{ route('pickup.index') }}"
            class="block text-center text-xs text-[#9A8A7A] mt-6">
            別の言葉を見る →
        </a>
    @else
        {{-- 単語なし --}}
        <div class="text-center py-20">
            <p class="font-serif text-2xl text-[#2E1A08] mb-3">いとをかし</p>
            <p class="text-xs text-[#9A8A7A] leading-relaxed mb-8">まだ言葉が登録されていません。<br>最初の言葉を登録してみましょう。</p>
            <a href="{{ route('dictionaries.index') }}"
            class="inline-block bg-[#E8A030] text-white text-sm rounded-full px-6 py-2">
                本棚へ
            </a>
        </div>
    @endif

    @else
        {{-- 未ログイン --}}
        <div class="text-center py-16">
            <p class="text-xs text-[#9A8A7A] mb-2">思い出を、綴る辞書アプリ</p>
            <p class="font-serif text-3xl font-bold text-[#665A50] tracking-widest mb-10">イトヲカシ</p>

            <div class="rounded-2xl px-6 py-8 mb-8 text-left" style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.07);">
                <p class="font-serif text-xl text-[#665A50] mb-3">イトヲカシ</p>
                <p class="text-xs text-[#9A8A7A] tracking-widest mb-3">いとをかし</p>
                <hr class="border-[#E0D4C0] mb-3">
                <p class="text-[10px] text-[#9A8A7A] tracking-widest mb-1">意　味</p>
                <p class="text-sm text-[#665A50] leading-relaxed mb-4">感動・評価を表す表現。心が動かされる、なんとも言えず趣深い瞬間を表す。</p>
                <p class="text-[10px] text-[#E8A030] font-bold tracking-widest mb-1">このアプリでは</p>
                <p class="text-sm text-[#665A50] leading-relaxed mb-1">思い出の言葉を綴り、自分だけの辞書を作ること</p>
                <p class="text-sm text-[#665A50] leading-relaxed mb-1">それを大切な人と共有し、思い出で繋がること</p>
                <p class="text-sm text-[#665A50] leading-relaxed mb-1">言葉で心が動いた瞬間を、みんなと共有すること</p>
            </div>

            <a href="/login"
            class="inline-block text-white text-sm rounded-full px-8 py-3 font-bold"
            style="background:#E8A030;">
                はじめる
            </a>
        </div>
    @endif
@endsection

