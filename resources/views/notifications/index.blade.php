@extends('layouts.app')
e
@section('header')
    <x-page-header title="通知" />
@endsection

@section('content')

@if($notifications->isEmpty())
<div class="flex flex-col items-center justify-center py-24 text-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#E0D4C0" viewBox="0 0 256 256" class="mb-4">
        <path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.63-16h45.26A24,24,0,0,1,128,216Z"/>
    </svg>
    <p class="text-sm text-[#9A8A7A]">通知はまだありません</p>
</div>

@else
<div class="flex flex-col gap-3 pb-4">
    @foreach($notifications as $notification)
        @php
            // 最新のニックネームを取得（中間テーブル dictionary_user を参照）
            $member = \App\Models\DictionaryUser::where('dictionary_id', $notification['dictionary_id'])
                ->where('user_id', $notification['user_id'])
                ->first();
            
            $latestName = $member->nickname ?? (\App\Models\User::find($notification['user_id'])->name ?? '誰か');
        @endphp

        <a href="{{ 
            ($notification['type'] === 'word' || $notification['type'] === 'reaction') && $notification['word_id']
            ? route('dictionaries.words.show', [$notification['dictionary_id'], $notification['word_id']]) 
            : route('dictionaries.show', $notification['dictionary_id']) 
        }}" 
        class="block active:opacity-70 transition-opacity">

            <div class="rounded-xl px-4 py-3.5 flex items-start gap-3" style="background:#fff; border:1px solid #E0D4C0;">
                
                {{-- アイコン --}}
                <div class="flex-shrink-0 mt-0.5">
                    @if($notification['type'] === 'reaction')
                    <div class="flex items-center justify-center mb-1" style="height:24px;">
                        <span class="font-bold" style="color:#E8A030; font-size:20px; line-height:1;">✦</span>
                    </div>
                    @elseif($notification['type'] === 'word')
                        <div class="w-5 h-5 rounded-full flex items-center justify-center" style="background:#FEF8F0; border:1.5px solid #E8A030;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#E8A030" viewBox="0 0 256 256">
                                <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"/>
                            </svg>
                        </div>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#E8A030" viewBox="0 0 256 256">
                            <path d="M256,136a8,8,0,0,1-8,8H232v16a8,8,0,0,1-16,0V144H200a8,8,0,0,1,0-16h16V112a8,8,0,0,1,16,0v16h16A8,8,0,0,1,256,136Zm-57.87,58.85a8,8,0,0,1-12.26,10.3C172.29,191.1,152.82,184,128,184s-44.29,7.1-57.87,21.15a8,8,0,0,1-12.26-10.3c9.42-11.21,23.39-19.55,40.4-24.28a72,72,0,1,1,59.46,0C174.74,175.3,188.71,183.64,198.13,194.85ZM128,176a56,56,0,1,0-56-56A56.06,56.06,0,0,0,128,176Z"/>
                        </svg>
                    @endif
                </div>

                {{-- テキスト --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-[#2E1A08] leading-snug">
                        @if($notification['type'] === 'word')
                            <strong>{{ $latestName }}</strong> が 「{{ $notification['headword'] }}」 を追加しました
                        @elseif($notification['type'] === 'join')
                            <strong>{{ $latestName }}</strong> が 「{{ $notification['dictionary_title'] }}」 に参加しました
                        @elseif($notification['type'] === 'reaction')
                            <strong>{{ $latestName }}</strong> が 「{{ $notification['headword'] }}」 を をかし と思いました
                        @endif
                    </p>
                    <p class="text-[10px] text-[#9A8A7A] mt-1">
                        {{ $notification['sub'] }} • {{ $notification['created_at']->diffForHumans() }}
                    </p>
                </div>
            </div>
        </a>
    @endforeach

    {{-- 最新30件の明記 --}}
    <div class="py-8 text-center">
        <p class="text-[10px] text-[#9A8A7A] tracking-widest uppercase">
            Showing the latest 30 notifications
        </p>
        <div class="w-8 h-[1px] bg-[#E0D4C0] mx-auto mt-2"></div>
    </div>
</div>
@endif

@endsection