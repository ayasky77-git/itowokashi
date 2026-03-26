@extends('layouts.app')

@section('header')
    {{-- マイページから戻れるように、戻り先を dashboard に設定 --}}
    <x-page-header title="プロフィール設定" :backUrl="route('dashboard')" />
@endsection

@section('content')
<div class="flex flex-col items-center px-4 pt-8 pb-32 space-y-8">
    
    {{-- 1. プロフィール情報更新 --}}
    <div class="w-full rounded-2xl p-6 shadow-sm border border-[#E0D4C0]" style="background:#fff;">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- 2. パスワード更新 --}}
    <div class="w-full rounded-2xl p-6 shadow-sm border border-[#E0D4C0]" style="background:#fff;">
        @include('profile.partials.update-password-form')
    </div>

    {{-- 3. アカウント削除 --}}
    <div class="w-full rounded-2xl p-6 shadow-sm border border-[#E0D4C0]" style="background:#fff;">
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection
