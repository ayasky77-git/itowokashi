@extends('layouts.app')

@section('header')
    <x-page-header title="辞書の設定" :backUrl="route('dictionaries.show', $dictionary)" />
@endsection

@section('content')

    {{-- バリデーションエラー表示 --}}
    @if($errors->any())
        <div class="rounded-xl px-4 py-3 mb-6 text-sm text-[#C0392B]" style="background:#FEF0EE; border:1px solid #FADBD8;">
            @foreach($errors->all() as $error)
                <p class="flex items-center gap-2">
                    <span class="w-1 h-1 rounded-full bg-[#C0392B]"></span>
                    {{ $error }}
                </p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('dictionaries.update', $dictionary) }}" method="POST" id="editForm" class="pb-20">
        @csrf
        @method('PUT')

        {{-- 【管理者のみ】辞書の装丁設定（タイトル・色・柄） --}}
        @if($userRole === 'admin')
                {{-- プレビューエリア --}}
                <div class="text-center py-4 -mx-4 px-4 mb-6 -mt-4 sticky top-0 z-30"
                    style="background:rgba(254,248,240,0.85);">
                    <div class="relative inline-block">
                        <div id="preview-cover"
                            class="flex flex-col items-center justify-center relative overflow-hidden mx-auto transition-all duration-300"
                            style="width:120px; min-height:168px; background:{{ old('color_code', $dictionary->color_code ?? '#E8A030') }};
                                    border-radius:4px 8px 8px 4px;
                                    box-shadow: 4px 4px 14px rgba(0,0,0,0.2), inset 3px 0 6px rgba(0,0,0,0.1);
                                    padding:4px 1px 40px;">
                            <div id="preview-pattern" class="absolute inset-0" style="background-repeat:repeat; pointer-events:none;"></div>
                            <h2 id="preview-title"
                                class="font-serif text-sm font-bold text-center relative z-10"
                                style="color:rgba(255,255,255,0.95); letter-spacing:0.1em; word-break:break-all;">
                                {{ old('title', $dictionary->title) }}
                            </h2>
                        </div>
                        <div id="preview-obi"
                            class="absolute bottom-0 left-0 right-0 flex items-center justify-center py-2 {{ old('obi_text', $dictionary->obi_text) ? '' : 'hidden' }}"
                            style="height:60px; background:#F2E8D8; border-radius:0 0 8px 4px;">
                            <span id="preview-obi-text" class="text-[9px] font-bold tracking-widest"
                                style="color:{{ old('color_code', $dictionary->color_code ?? '#E8A030') }};">{{ old('obi_text', $dictionary->obi_text) }}</span>
                        </div>
                    </div>
                </div>

                {{-- 基本設定カード --}}
                <div class="space-y-4">
                    <div class="rounded-xl px-4 py-5 bg-white border border-[#E0D4C0] shadow-sm">
                        <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">辞書名</label>
                        <input type="text" name="title" id="titleInput"
                            value="{{ old('title', $dictionary->title) }}"
                            class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none shadow-inner"
                            style="background:#F6F2EC; border:1px solid #E0D4C0;">
                        <p class="text-[10px] text-[#9A8A7A] mt-2 text-right">
                            <span id="titleCount">{{ mb_strlen($dictionary->title) }}</span>/12文字
                        </p>
                    </div>

                    <div class="rounded-xl px-4 py-5 bg-white border border-[#E0D4C0] shadow-sm">
                        <label class="text-xs font-bold text-[#2E1A08] mb-2 block tracking-wider">キャッチフレーズ（帯）</label>
                        <input type="text" name="obi_text" id="obiInput"
                            value="{{ old('obi_text', $dictionary->obi_text) }}"
                            class="w-full rounded-lg px-3 py-3 text-sm text-[#2E1A08] outline-none shadow-inner"
                            style="background:#F6F2EC; border:1px solid #E0D4C0;">
                        <p class="text-[10px] text-[#9A8A7A] mt-2 text-right">
                            <span id="obiCount">{{ mb_strlen($dictionary->obi_text ?? '') }}</span>/20文字
                        </p>
                    </div>

                    <div class="rounded-xl px-4 py-5 bg-white border border-[#E0D4C0] shadow-sm">
                        <label class="text-xs font-bold text-[#2E1A08] mb-4 block tracking-wider">装丁（色と柄）</label>
                        <input type="hidden" name="color_code" id="colorInput" value="{{ old('color_code', $dictionary->color_code ?? '#E8A030') }}">
                        <x-color-selector :selected="old('color_code', $dictionary->color_code ?? '#E8A030')" />
                        
                        <div class="mt-6 pt-6 border-t border-[#F6F2EC]">
                            <input type="hidden" name="spine_pattern" id="patternInput" value="{{ old('spine_pattern', $dictionary->spine_pattern ?? 'none') }}">
                            <x-pattern-selector :selected="old('spine_pattern', $dictionary->spine_pattern ?? 'none')" />
                        </div>
                    </div>
                </div>
        @endif

        {{-- 【全員】この辞書での表示名（Editorにとってはメイン） --}}
        <div class="mb-10">
            <p class="text-[10px] font-bold text-[#E8A030] tracking-widest uppercase mb-4 px-1">Member Profile</p>
            <div class="rounded-2xl px-5 py-6 shadow-sm border border-[#E0D4C0]" style="background:#fff;">
                <label class="text-sm font-bold text-[#2E1A08] mb-1 block">この辞書での表示名</label>
                <p class="text-[10px] text-[#9A8A7A] mb-4">作成した言葉の横に表示されるお名前です</p>
                
                <input type="text" name="nickname"
                    value="{{ old('nickname', $myNickname) }}"
                    placeholder="{{ auth()->user()->name }}"
                    class="w-full rounded-xl px-4 py-3.5 text-sm text-[#2E1A08] outline-none shadow-inner"
                    style="background:#F6F2EC; border:1px solid #E0D4C0;">
            </div>
        </div>

        {{-- 保存ボタン --}}
        <button type="submit" id="submitBtn"
                class="w-full rounded-xl py-4 text-sm font-bold shadow-md active:scale-[0.98] transition-all mb-12"
                style="background:#E8A030; color:#fff;">
            変更を保存する
        </button>

        {{-- 【管理者のみ】共有設定と削除 --}}
        @if($userRole === 'admin')
            <div class="mb-10 space-y-6">
                <p class="text-[10px] font-bold text-[#E8A030] tracking-widest uppercase px-1">Shared Settings</p>
                
                {{-- 招待コード --}}
                <div class="rounded-xl px-4 py-5 bg-white border border-[#E0D4C0] shadow-sm">
                    <p class="text-xs font-bold text-[#2E1A08] mb-3">招待コード</p>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 rounded-lg px-3 py-3 text-sm font-mono text-[#2E1A08] shadow-inner"
                            style="background:#F6F2EC; border:1px solid #E0D4C0;">
                            {{ $dictionary->invite_code }}
                        </div>
                        <button type="button"
                                onclick="navigator.clipboard.writeText('{{ $dictionary->invite_code }}').then(() => alert('コピーしました'))"
                                class="rounded-lg px-4 py-3 text-xs font-bold text-[#9A8A7A] transition-colors active:bg-[#F6F2EC]"
                                style="border:1px solid #E0D4C0; background:#fff;">
                            コピー
                        </button>
                    </div>
                </div>

                {{-- メンバーリスト --}}
                <div class="rounded-xl px-4 py-5 bg-white border border-[#E0D4C0] shadow-sm">
                    <p class="text-xs font-bold text-[#2E1A08] mb-4">共有メンバー（{{ $members->count() }}人）</p>
                    <div class="space-y-3">
                        @foreach($members as $member)
                        <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-[#F6F2EC]' : '' }}">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold text-white shadow-sm"
                                    style="background:#E0D4C0;">
                                    {{ mb_substr($member->nickname ?? $member->user->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-sm text-[#2E1A08]">{{ $member->nickname ?? $member->user->name }}</span>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-1 rounded bg-[#F6F2EC] text-[#9A8A7A]">
                                {{ $member->role === 'admin' ? '管理者' : '編集者' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </form>

        {{-- ⚠️ 削除フォームは editForm の「外」に配置する --}}
        @if($userRole === 'admin')
            <div class="pt-8 border-t border-[#E0D4C0] mb-4">
                <p class="text-[10px] font-bold text-[#C0392B] tracking-widest uppercase mb-4 px-1">Danger Zone</p>
                
                <form action="{{ route('dictionaries.destroy', $dictionary) }}" method="POST"
                    onsubmit="return confirm('本当にこの辞書を削除しますか？\n\n・綴った言葉はすべて非表示になります\n・メンバーもアクセスできなくなります\n\nこの操作は取り消せますが、慎重に行ってください。')">
                    @csrf
                    @method('DELETE')
                    
                    <button type="submit"
                            class="w-full rounded-xl py-4 text-sm font-bold flex items-center justify-center gap-2 transition-opacity active:opacity-70"
                            style="background:#C0392B; color:#fff;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"/>
                        </svg>
                        辞書を削除する
                    </button>
                </form>
            </div>
        @endif

    <script>
        // 色選択時のプレビュー反映
        function selectColor(color) {
            document.getElementById('colorInput').value = color;
            const cover = document.getElementById('preview-cover');
            if(cover) cover.style.background = color;
            const obiText = document.getElementById('preview-obi-text');
            if(obiText) obiText.style.color = color;
        }

        // タイトル入力時の反映
        const titleInput = document.getElementById('titleInput');
        if(titleInput) {
            titleInput.addEventListener('input', function() {
                const val = this.value;
                document.getElementById('titleCount').textContent = val.length;
                document.getElementById('preview-title').textContent = val || '辞書タイトル';
            });
        }

        // 帯入力時の反映
        const obiInput = document.getElementById('obiInput');
        if(obiInput) {
            obiInput.addEventListener('input', function() {
                const val = this.value;
                document.getElementById('obiCount').textContent = val.length;
                const obi = document.getElementById('preview-obi');
                if(val.length > 0) {
                    obi.classList.remove('hidden');
                    document.getElementById('preview-obi-text').textContent = val;
                } else {
                    obi.classList.add('hidden');
                }
            });
        }
    </script>

@endsection