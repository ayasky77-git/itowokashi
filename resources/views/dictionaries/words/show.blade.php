@extends('layouts.app')

@section('header')
    <x-page-header title="{{ $dictionary->title }}" :backUrl="route('dictionaries.words.index', $dictionary)">
        @if($userRole === 'admin' || $userRole === 'editor')
        <a href="{{ route('dictionaries.words.edit', [$dictionary, $word]) }}" class="text-[#9A8A7A]">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
            </svg>
        </a>
        @endif
    </x-page-header>
@endsection

@section('content')

    <x-word-detail :word="$word" :dictionary="$dictionary" />

@endsection