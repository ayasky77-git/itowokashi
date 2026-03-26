@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center pt-10 px-4 pb-10">

    {{-- ロゴコンポーネント（サブタイトルを招待用に変更） --}}
    <x-auth-logo subtitle="Join Dictionary" />

    {{-- 認証画面と共通のカードコンポーネント --}}
    <x-auth-card>
        {{-- 説明文：状況がわかりやすいように追加 --}}
        <div class="mb-6 text-sm leading-relaxed text-[#9A8A7A]">
            {{ __('共有された招待コードを入力してください。新しい辞書に参加して、一緒に言葉を綴りましょう。') }}
        </div>

        <form action="{{ route('invitations.join') }}" method="POST">
            @csrf
            
            {{-- 招待コード入力欄 --}}
            <div class="mb-8">
                <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">招待コード</label>
                <input type="text" name="invite_code" required autofocus
                       placeholder="例：ABC123XYZ"
                       class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none focus:ring-0 font-mono tracking-widest uppercase"
                       style="background:#F6F2EC; border:1px solid #E0D4C0;">
                
                @error('invite_code')
                    <p class="text-[10px] text-[#C0392B] mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 参加ボタン --}}
            <button type="submit"
                    class="w-full rounded-xl py-3.5 text-sm font-bold text-white shadow-sm active:opacity-80 transition-opacity"
                    style="background:#E8A030;">
                この辞書に参加する
            </button>
        </form>
    </x-auth-card>

    {{-- 戻るリンク（フッター的役割） --}}
    <div class="mt-8 text-center">
        <a href="{{ route('dictionaries.index') }}" class="text-[11px] text-[#9A8A7A] underline decoration-[#E0D4C0]">
            本棚に戻る
        </a>
    </div>
</div>
@endsection