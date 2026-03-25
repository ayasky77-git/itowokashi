@extends('layouts.app')


@section('header')
    <x-page-header title="辞書の設定" :backUrl="route('dictionaries.show',$dictionary)" />
@endsection


@section('content')

    @if($errors->any())
        <div class="rounded-xl px-4 py-3 mb-4 text-sm text-[#C0392B]" style="background:#FEF0EE;">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('dictionaries.update', $dictionary) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')

        {{-- プレビュー --}}
        <div class="text-center py-4 -mx-4 px-4 mb-6 sticky top-0 z-30"
            style="background:rgba(254,248,240,0.92); border-bottom:1px solid #E0D4C0;">
            <div class="relative inline-block">
                <div id="preview-cover"
                    class="flex flex-col items-center justify-center relative overflow-hidden mx-auto"
                    style="width:120px; min-height:168px; background:{{ $dictionary->color_code ?? '#E8A030' }};
                            border-radius:4px 8px 8px 4px;
                            box-shadow: 4px 4px 14px rgba(0,0,0,0.25), inset 3px 0 6px rgba(0,0,0,0.12);
                            padding:16px 12px 40px;">
                    <div id="preview-pattern" class="absolute inset-0" style="background-repeat:repeat; pointer-events:none;"></div>
                    <h2 id="preview-title"
                        class="font-serif text-sm font-bold text-center relative z-10"
                        style="color:rgba(255,255,255,0.95); letter-spacing:0.1em; word-break:break-all;">
                        {{ $dictionary->title }}
                    </h2>
                </div>
                <div id="preview-obi"
                    class="absolute bottom-0 left-0 right-0 flex items-center justify-center py-2 {{ $dictionary->obi_text ? '' : 'hidden' }}"
                    style="height:60px; background:#F2E8D8; border-radius:0 0 8px 4px;">
                    <span id="preview-obi-text" class="text-[9px] font-bold tracking-widest"
                        style="color:{{ $dictionary->color_code ?? '#E8A030' }};">{{ $dictionary->obi_text }}</span>
                </div>
            </div>
        </div>

        {{-- 辞書名 --}}
        <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-1 block">辞書名の編集</label>
            <p class="text-xs text-[#9A8A7A] mb-3">辞書の名前を変更できます</p>
            <label class="text-xs text-[#2E1A08] mb-1 block">辞書名</label>
            <input type="text" name="title" id="titleInput"
                value="{{ old('title', $dictionary->title) }}"
                placeholder="例：家族の言葉"
                class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none mb-1"
                style="background:#F6F2EC; border:1px solid #E0D4C0;">
            <p class="text-[10px] text-[#9A8A7A]"><span id="titleCount">{{ mb_strlen($dictionary->title) }}</span>/12文字（8文字以内推奨）</p>
        </div>

        {{-- キャッチフレーズ --}}
        <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-2 block">キャッチフレーズ（帯）</label>
            <input type="text" name="obi_text" id="obiInput"
                value="{{ old('obi_text', $dictionary->obi_text) }}"
                placeholder="例：温もりの言葉"
                class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none mb-1"
                style="background:#F6F2EC; border:1px solid #E0D4C0;">
            <p class="text-[10px] text-[#9A8A7A]"><span id="obiCount">{{ mb_strlen($dictionary->obi_text ?? '') }}</span>/20文字</p>
        </div>

        {{-- 色選択 --}}
        <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-3 block">背表紙の色</label>
            <input type="hidden" name="color_code" id="colorInput" value="{{ old('color_code', $dictionary->color_code ?? '#E8A030') }}">
            <x-color-selector :selected="old('color_code', $dictionary->color_code ?? '#E8A030')" />
        </div>

        {{-- 柄選択 --}}
        <div class="rounded-xl px-4 py-4 mb-6" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-3 block">背表紙の柄</label>
            <input type="hidden" name="spine_pattern" id="patternInput" value="{{ old('spine_pattern', $dictionary->spine_pattern ?? 'none') }}">
            <x-pattern-selector :selected="old('spine_pattern', $dictionary->spine_pattern ?? 'none')" />
        </div>

        {{-- この辞書での表示名 --}}
        <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-1 block">この辞書での表示名</label>
            <p class="text-xs text-[#9A8A7A] mb-3">この辞書内であなたが作成した言葉に表示される名前です</p>
            <label class="text-xs text-[#2E1A08] mb-1 block">表示名</label>
            <input type="text" name="nickname"
                value="{{ old('nickname', $myNickname) }}"
                placeholder="例：たろう"
                class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none"
                style="background:#F6F2EC; border:1px solid #E0D4C0;">
        </div>

        {{-- 保存ボタン --}}
        <button type="submit" id="submitBtn"
                class="w-full rounded-xl py-3.5 text-sm font-bold mb-6"
                style="background:#E8A030; color:#fff;">
            変更を保存する
        </button>

        {{-- 共有設定 --}}
        <div class="mb-4">
            <p class="text-sm font-bold text-[#2E1A08] mb-1">共有設定</p>
            <p class="text-xs text-[#9A8A7A] mb-3">この辞書を他の人と共有できます</p>

            <div class="rounded-xl px-4 py-4 mb-3" style="background:#fff; border:1px solid #E0D4C0;">
                <p class="text-xs font-bold text-[#E8A030] mb-2">招待コード</p>
                <div class="flex items-center gap-2">
                    <div class="flex-1 rounded-lg px-3 py-2 text-sm text-[#2E1A08]"
                        style="background:#F6F2EC; border:1px solid #E0D4C0;">
                        {{ $dictionary->invite_code }}
                    </div>
                    <button type="button"
                            onclick="navigator.clipboard.writeText('{{ $dictionary->invite_code }}').then(() => alert('コピーしました'))"
                            class="rounded-lg px-3 py-2 text-xs text-[#9A8A7A]"
                            style="border:1px solid #E0D4C0; background:#fff;">
                        コピー
                    </button>
                </div>
            </div>

            <div class="rounded-xl px-4 py-4" style="background:#fff; border:1px solid #E0D4C0;">
                <p class="text-xs font-bold text-[#2E1A08] mb-3">共有メンバー（{{ $members->count() }}人）</p>
                @foreach($members as $member)
                @php
                    $colors_list = ['#E8A030','#D46B3A','#6FA8C4','#7FAF82','#8A7E9A','#C4A46A','#C46A7A','#5A8A90'];
                    $memberColor = $colors_list[$loop->index % count($colors_list)];
                @endphp
                <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-[#F2E8D8]' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white"
                            style="background:{{ $memberColor }};">
                            {{ mb_substr($member->nickname ?? $member->user->name ?? '?', 0, 1) }}
                        </div>
                        <span class="text-sm text-[#2E1A08]">{{ $member->nickname ?? $member->user->name }}</span>
                    </div>
                    <span class="text-xs text-[#9A8A7A]">
                        {{ $member->role === 'admin' ? '管理者' : '編集者' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </form>

    {{-- 危険な操作 --}}
    <div class="mb-8">
        <p class="text-sm font-bold text-[#2E1A08] mb-3">危険な操作</p>
        <form action="{{ route('dictionaries.destroy', $dictionary) }}" method="POST"
            onsubmit="return confirm('この辞書を削除しますか？この操作は取り消せません。')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="w-full rounded-xl py-3.5 text-sm font-bold flex items-center justify-center gap-2"
                    style="background:#C0392B; color:#fff;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 256 256">
                    <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"/>
                </svg>
                辞書を削除
            </button>
        </form>
    </div>

    <script>
        function selectColor(color) {
            document.getElementById('colorInput').value = color;
            document.getElementById('preview-cover').style.background = color;
            document.getElementById('preview-obi-text').style.color = color;
            document.querySelectorAll('.color-option .color-swatch').forEach(el => {
                el.style.border = '2px solid transparent';
                el.style.outline = 'none';
            });
            const selected = document.querySelector(`.color-option[data-color="${color}"] .color-swatch`);
            if (selected) {
                selected.style.border = `2px solid ${color}`;
                selected.style.outline = `2px solid ${color}`;
                selected.style.outlineOffset = '2px';
            }
        }

        document.getElementById('titleInput').addEventListener('input', function() {
            const val = this.value;
            document.getElementById('titleCount').textContent = val.length;
            document.getElementById('preview-title').textContent = val || '辞書タイトル';
            if (val.length > 8) {
                document.getElementById('titleCount').style.color = '#E8A030';
            } else {
                document.getElementById('titleCount').style.color = '#9A8A7A';
            }
            if (val.length > 12) {
                alert('タイトルは12文字以内で入力してください');
                this.value = val.slice(0, 12);
                document.getElementById('titleCount').textContent = 12;
            }
        });

        document.getElementById('obiInput').addEventListener('input', function() {
            const val = this.value;
            document.getElementById('obiCount').textContent = val.length;
            if (val.length > 15) {
                document.getElementById('obiCount').style.color = '#E8A030';
            } else {
                document.getElementById('obiCount').style.color = '#9A8A7A';
            }
            if (val.length > 20) {
                alert('キャッチフレーズは20文字以内で入力してください');
                this.value = val.slice(0, 20);
                document.getElementById('obiCount').textContent = 20;
            }
            const obi = document.getElementById('preview-obi');
            const obiText = document.getElementById('preview-obi-text');
            if (val.length > 0) {
                obi.classList.remove('hidden');
                obi.style.display = 'flex';
                obiText.textContent = val;
            } else {
                obi.style.display = 'none';
            }
        });
    </script>

@endsection