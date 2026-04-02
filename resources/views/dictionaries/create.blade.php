@extends('layouts.app')

@section('header')
    <x-page-header title="新しい辞書を作る" :backUrl="route('dictionaries.index')" />
@endsection


@section('content')

    @if($errors->any())
        <div class="rounded-xl px-4 py-3 mb-4 text-sm text-[#C0392B]" style="background:#FEF0EE;">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('dictionaries.store') }}" method="POST" id="createForm">
        @csrf

        {{-- プレビュー --}}
        <div class="text-center py-4 -mx-4 px-4 mb-6 -mt-4 sticky top-0 z-30"
            style="background:rgba(254,248,240,0.85);">
            <div class="relative inline-block">
                <div id="preview-cover"
                    class="flex flex-col items-center justify-center relative overflow-hidden mx-auto"
                    style="width:120px; min-height:168px; background:#E8A030;
                            border-radius:4px 8px 8px 4px;
                            box-shadow: 4px 4px 14px rgba(0,0,0,0.25), inset 3px 0 6px rgba(0,0,0,0.12);
                            padding:4px 1px 40px;">
                    <div id="preview-pattern" class="absolute inset-0" style="background-repeat:repeat; pointer-events:none;"></div>
                    <h2 id="preview-title"
                        class="font-serif text-sm font-bold text-center relative z-10"
                        style="color:rgba(255,255,255,0.95); letter-spacing:0.1em; word-break:break-all;">
                        辞書タイトル
                    </h2>
                </div>
                <div id="preview-obi"
                    class="absolute bottom-0 left-0 right-0 items-center justify-center py-2 hidden"
                    style="height:60px; background:#F2E8D8; border-radius:0 0 8px 4px;">
                    <span id="preview-obi-text" class="text-[9px] font-bold tracking-widest" style="color:#E8A030;"></span>
                </div>
            </div>
        </div>

        {{-- タイトル --}}
        <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-2 block">
                辞書のタイトル <span class="text-[#C0392B]">*</span>
            </label>
            <input type="text" name="title" id="titleInput"
                value="{{ old('title') }}"
                placeholder="例：家族の言葉"
                class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none"
                style="background:#F6F2EC; border:1px solid #E0D4C0;">
            <p class="text-[10px] text-[#9A8A7A] mt-1"><span id="titleCount">0</span>/12文字（8文字以内推奨）</p>
        </div>

        {{-- キャッチフレーズ --}}
        <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-2 block">キャッチフレーズ</label>
            <input type="text" name="obi_text" id="obiInput"
                value="{{ old('obi_text') }}"
                placeholder="例：温もりの言葉"
                class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none"
                style="background:#F6F2EC; border:1px solid #E0D4C0;">
            <p class="text-[10px] text-[#9A8A7A] mt-1"><span id="obiCount">0</span>/20文字</p>
        </div>

        {{-- 色選択 --}}
        <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-3 block">背表紙の色</label>
            <input type="hidden" name="color_code" id="colorInput" value="{{ old('color_code', '#E8A030') }}">
            <x-color-selector :selected="old('color_code', '#E8A030')" />
        </div>

        {{-- 柄選択 --}}
        <div class="rounded-xl px-4 py-4 mb-6" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-3 block">背表紙の柄</label>
            <input type="hidden" name="spine_pattern" id="patternInput" value="{{ old('spine_pattern', 'none') }}">
            <x-pattern-selector :selected="old('spine_pattern', 'none')" />
        </div>

        {{-- 送信ボタン --}}
        <button type="submit" id="submitBtn"
                class="w-full rounded-xl py-3.5 text-sm font-bold mb-8"
                style="background:#E0D4C0; color:#9A8A7A;">
            辞書を作成
        </button>

    </form>

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
            updateSubmitBtn();
        }

        function updateSubmitBtn() {
            const title = document.getElementById('titleInput').value.trim();
            const btn = document.getElementById('submitBtn');
            if (title.length > 0) {
                btn.style.background = '#E8A030';
                btn.style.color = '#fff';
            } else {
                btn.style.background = '#E0D4C0';
                btn.style.color = '#9A8A7A';
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
            updateSubmitBtn();
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
                obi.style.display = 'flex';
                obiText.textContent = val;
            } else {
                obi.style.display = 'none';
            }
        });
    </script>

@endsection
