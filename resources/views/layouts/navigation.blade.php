<nav class="bg-[#FEF8F0] border-b border-[#E0D4C0]">
    <div class="max-w-[390px] mx-auto px-4 h-12 flex items-center justify-between">
        
        <a href="{{ route('dictionaries.index') }}" 
           class="font-serif text-lg text-[#2E1A08] tracking-widest">
            イトヲカシ
        </a>

        <div class="flex items-center gap-4 text-sm text-[#9A8A7A]">
            <a href="{{ route('dictionaries.index') }}">本棚</a>
            <a href="{{ route('search.index') }}">さがす</a>
            <a href="{{ route('pickup.index') }}">PickUP</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[#9A8A7A]">ログアウト</button>
            </form>
        </div>

    </div>
</nav>