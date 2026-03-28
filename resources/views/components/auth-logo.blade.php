@props(['subtitle' => ''])

<div class="text-center mb-10">
    <p class="text-[10px] text-[#9A8A7A] tracking-widest mb-1">思い出を、言葉で綴る</p>
    <h1 class="font-serif text-4xl font-bold text-[#665A50] tracking-[0.2em] leading-tight">イトヲカシ</h1>
    @if($subtitle)
        <p class="text-[10px] text-[#9A8A7A] tracking-widest mt-1">{{ $subtitle }}</p>
    @endif
</div>