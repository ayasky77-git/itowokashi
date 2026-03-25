@extends('layouts.app')

@section('header')
    <x-page-header title="招待コード" :backUrl="route('xxx')" />
@endsection

@section('content')
<form action="{{ route('invitations.join') }}" method="POST">
    @csrf
    <input type="text" name="invite_code" placeholder="招待コードを入力">
    <button type="submit">参加する</button>
</form>

@endsection
