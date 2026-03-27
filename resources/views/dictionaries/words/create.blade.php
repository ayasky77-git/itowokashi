@extends('layouts.app')

@section('header')
    <x-page-header title="新しい言葉を追加する" :backUrl="route('dictionaries.show', $dictionary)" />
@endsection

@section('content')

    @if($errors->any())
        <div class="rounded-xl px-4 py-3 mb-4 text-sm text-[#C0392B]" style="background:#FEF0EE;">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('dictionaries.words.store', $dictionary) }}" method="POST" enctype="multipart/form-data" id="wordForm">
    @csrf
        {{-- 見出し語・よみがな --}}
        <div class="rounded-xl mt-4 px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-2 block">見出し語 <span class="text-[#C0392B]">*</span></label>
            <input type="text" name="headword" id="headword"
                value="{{ old('headword') }}"
                placeholder="例：しもやけ"
                class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none mb-3"
                style="background:#F6F2EC; border:1px solid #E0D4C0;">

            <label class="text-sm font-bold text-[#2E1A08] mb-2 block">よみがな <span class="text-[#C0392B]">*</span></label>
            <input type="text" name="reading" id="reading"
                value="{{ old('reading') }}"
                placeholder="例：しもやけ"
                class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none"
                style="background:#F6F2EC; border:1px solid #E0D4C0;">
            <input type="hidden" name="initial_char" id="initial_char" value="{{ old('initial_char') }}">
        </div>

        {{-- エピソード --}}
        <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-2 block">エピソードを書く</label>
            <textarea name="raw_episode" id="raw_episode" rows="6"
                    placeholder="例: 小さい時、夕日を見て「きれいなしもやけだねー」と私は言ったらしい。夕焼けとしもやけを言い間違えただけなんだけど、今でも冬になると家族に「今日のしもやけはきれいだね」とネタにされます。"
                    class="w-full rounded-lg px-3 py-2.5 text-sm text-[#2E1A08] outline-none resize-none"
                    style="background:#F6F2EC; border:1px solid #E0D4C0;">{{ old('raw_episode') }}</textarea>
        </div>

        {{-- AI変換ボタン --}}
        <button type="button" id="aiBtn" onclick="askAI()"
                class="w-full rounded-xl py-3.5 text-sm font-bold mb-4 flex items-center justify-center gap-2"
                style="background:#F2E8D8; color:#C8A878;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 256 256">
                <path d="M234.29,69.53l-128-64a8,8,0,0,0-7.16,0L16,64a8,8,0,0,0,0,14.31L40,90.79V144a8,8,0,0,0,4.42,7.16l80,40a8,8,0,0,0,7.16,0l80-40A8,8,0,0,0,216,144V90.79l18.29-9.14a8,8,0,0,0,0-14.32Z"/>
            </svg>
            AIで辞書形式に変換
        </button>

        {{-- AI変換結果 --}}
        <div id="ai-result" class="hidden mb-4">
            <div class="rounded-xl px-4 py-4" style="background:#fff; border:1px solid #E8A030;">
                <p class="text-[10px] font-bold text-[#E8A030] tracking-widest mb-4">✦ AI変換完了！内容を確認・編集してください</p>

                <div class="mb-3">
                    <label class="text-[10px] font-bold text-[#E8A030] tracking-widest mb-1 block">【意味】</label>
                    <textarea id="ai-meaning" name="ai-meaning" rows="5"
                            class="w-full rounded-lg px-3 py-2 text-sm text-[#2E1A08] outline-none resize-none"
                            style="background:#F6F2EC; border:1px solid #E0D4C0;"></textarea>
                </div>
                <div class="mb-3">
                    <label class="text-[10px] font-bold text-[#E8A030] tracking-widest mb-1 block">【語源】</label>
                    <textarea id="ai-origin" name="ai-origin" rows="5"
                            class="w-full rounded-lg px-3 py-2 text-sm text-[#2E1A08] outline-none resize-none"
                            style="background:#F6F2EC; border:1px solid #E0D4C0;"></textarea>
                </div>
                <div class="mb-3">
                    <label class="text-[10px] font-bold text-[#E8A030] tracking-widest mb-1 block">【用例】</label>
                    <textarea id="ai-example" name="ai-example" rows="5"
                            class="w-full rounded-lg px-3 py-2 text-sm text-[#2E1A08] outline-none resize-none"
                            style="background:#F6F2EC; border:1px solid #E0D4C0;"></textarea>
                </div>
                <div class="mb-3">
                    <label class="text-[10px] font-bold text-[#9A8A7A] tracking-widest mb-1 block">【関連語】<span class="text-[#9A8A7A] font-normal">カンマ区切り</span></label>
                    <input type="text" id="ai-synonyms" name="ai-synonyms"
                        placeholder="例：沼落ち, 無限ループ"
                        class="w-full rounded-lg px-3 py-2 text-sm text-[#2E1A08] outline-none"
                        style="background:#F6F2EC; border:1px solid #E0D4C0;">
                </div>
                <div class="mb-3">
                    <label class="text-[10px] font-bold text-[#9A8A7A] tracking-widest mb-1 block">【対義語】<span class="text-[#9A8A7A] font-normal">カンマ区切り</span></label>
                    <input type="text" id="ai-antonyms" name="ai-antonyms"
                        placeholder="例：Control+C"
                        class="w-full rounded-lg px-3 py-2 text-sm text-[#2E1A08] outline-none"
                        style="background:#F6F2EC; border:1px solid #E0D4C0;">
                </div>
            </div>
        </div>

        {{-- 考え中 --}}
        <div id="ai-thinking" class="hidden text-center py-4 mb-4">
            <p class="text-sm text-[#9A8A7A]">✦ 考え中...</p>
        </div>

        <!-- {{-- タグ --}}
        @if($tags->count() > 0)
            <div class="rounded-xl px-4 py-4 mb-4" style="background:#fff; border:1px solid #E0D4C0;">
                <label class="text-sm font-bold text-[#2E1A08] mb-3 block">タグ</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tag_ids', [])) ? 'checked' : '' }}
                            class="rounded">
                        <span class="text-xs text-[#665A50] bg-[#F2E8D8] rounded-full px-3 py-1"># {{ $tag->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        @endif -->

        {{-- 写真アップロード --}}
        <div class="rounded-xl px-4 py-4 mb-6" style="background:#fff; border:1px solid #E0D4C0;">
            <label class="text-sm font-bold text-[#2E1A08] mb-3 block">ファイルをアップロード</label>
            <label class="w-full rounded-xl py-3 text-sm font-bold flex items-center justify-center gap-2 cursor-pointer"
                style="background:#E8A030; color:#fff;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 256 256">
                    <path d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Zm-42.34-61.66a8,8,0,0,1-11.32,11.32L136,155.31V184a8,8,0,0,1-16,0V155.31l-10.34,10.35a8,8,0,0,1-11.32-11.32l24-24a8,8,0,0,1,11.32,0Z"/>
                </svg>
                ファイルを選択
                <input type="file" name="image_path" class="hidden" accept="image/*">
            </label>
            <p id="file-name" class="text-[10px] text-[#9A8A7A] text-center mt-2">選択されていません</p>
        </div>

        <input type="hidden" name="dictionary_data" id="dictionary_data" value="{}">

        {{-- ボタン --}}
        <div class="flex flex-col gap-3 mb-8">
            <button type="submit" name="status" value="draft"
                    class="w-full rounded-xl py-3.5 text-sm font-bold flex items-center justify-center gap-2"
                    style="background:#fff; border:1.5px solid #E0D4C0; color:#9A8A7A;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 256 256">
                    <path d="M219.31,72,184,36.69A15.86,15.86,0,0,0,172.69,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V83.31A15.86,15.86,0,0,0,219.31,72ZM168,208H88V152h80Zm40,0H184V152a16,16,0,0,0-16-16H88a16,16,0,0,0-16,16v56H48V48H172.69L208,83.31Z"/>
                </svg>
                下書き保存
            </button>
            <button type="submit" name="status" value="published"
                    class="w-full rounded-xl py-3.5 text-sm font-bold"
                    style="background:#E8A030; color:#fff;">
                辞書に登録する
            </button>
        </div>

    </form>

    <script>
        // ファイル名表示
        document.querySelector('input[type="file"]').addEventListener('change', function() {
            const name = this.files[0] ? this.files[0].name : '選択されていません';
            document.getElementById('file-name').textContent = name;
        });

        // よみがなからinitial_charを自動生成
        document.getElementById('reading').addEventListener('input', function() {
            const reading = this.value;
            if (!reading) return;
            const first = reading[0];
            const rowMap = {
                'あ': ['あ','い','う','え','お'],
                'か': ['か','き','く','け','こ','が','ぎ','ぐ','げ','ご'],
                'さ': ['さ','し','す','せ','そ','ざ','じ','ず','ぜ','ぞ'],
                'た': ['た','ち','つ','て','と','だ','ぢ','づ','で','ど'],
                'な': ['な','に','ぬ','ね','の'],
                'は': ['は','ひ','ふ','へ','ほ','ば','び','ぶ','べ','ぼ','ぱ','ぴ','ぷ','ぺ','ぽ'],
                'ま': ['ま','み','む','め','も'],
                'や': ['や','ゆ','よ'],
                'ら': ['ら','り','る','れ','ろ'],
                'わ': ['わ','を','ん'],
            };
            let initial = first;
            for (const [row, chars] of Object.entries(rowMap)) {
                if (chars.includes(first)) { initial = row; break; }
            }
            document.getElementById('initial_char').value = initial;
        });

        // フォーム送信時にdictionary_dataをセット
        document.getElementById('wordForm').addEventListener('submit', function() {
            const synonymsRaw = document.getElementById('ai-synonyms').value;
            const antonymsRaw = document.getElementById('ai-antonyms').value;
            document.getElementById('dictionary_data').value = JSON.stringify({
                meaning:  document.getElementById('ai-meaning').value,
                origin:   document.getElementById('ai-origin').value,
                example:  document.getElementById('ai-example').value,
                synonyms: synonymsRaw ? synonymsRaw.split(',').map(s => s.trim()).filter(Boolean) : [],
                antonyms: antonymsRaw ? antonymsRaw.split(',').map(s => s.trim()).filter(Boolean) : [],
            });
        });

        // ページ読み込み時の初期化処理
        document.addEventListener('DOMContentLoaded', () => {
            // AIボタンの状態更新
            updateAiBtn();

            // バリデーションエラーなどで戻ってきた際、hiddenフィールドに値があれば再表示する
            const oldDataStr = document.getElementById('dictionary_data').value;
            if (oldDataStr && oldDataStr !== '{}') {
                try {
                    const oldData = JSON.parse(oldDataStr);
                    if (oldData.meaning || oldData.origin || oldData.example) {
                        document.getElementById('ai-meaning').value = oldData.meaning || '';
                        document.getElementById('ai-origin').value = oldData.origin || '';
                        document.getElementById('ai-example').value = oldData.example || '';
                        document.getElementById('ai-result').classList.remove('hidden');
                    }
                } catch (e) {
                    console.error("JSON parse error:", e);
                }
            }
        });

        // 入力監視
        document.getElementById('raw_episode').addEventListener('input', updateAiBtn);
        document.getElementById('headword').addEventListener('input', updateAiBtn);

        function updateAiBtn() {
            const headword = document.getElementById('headword').value.trim();
            const episode = document.getElementById('raw_episode').value.trim();
            const aiBtn = document.getElementById('aiBtn');

            if (headword && episode) {
                // 入力がある時：アクティブ（オレンジ）
                aiBtn.style.background = '#E8A030';
                aiBtn.style.color = '#fff';
                aiBtn.disabled = false;
                aiBtn.style.cursor = 'pointer';
                aiBtn.style.opacity = '1';
            } else {
                // 入力がない時：非アクティブ（薄いベージュ）
                aiBtn.style.background = '#F2E8D8';
                aiBtn.style.color = '#C8A878';
                aiBtn.disabled = true;
                aiBtn.style.cursor = 'not-allowed';
                aiBtn.style.opacity = '0.7';
            }
        }

        // AI変換実行
        async function askAI() {
            const raw_episode = document.getElementById('raw_episode').value;
            const headword = document.getElementById('headword').value;
            if (!raw_episode || !headword) return;

            const thinking = document.getElementById('ai-thinking');
            const resultArea = document.getElementById('ai-result');

            thinking.classList.remove('hidden');
            resultArea.classList.add('hidden');

            try {
                const res = await fetch('/gemini/convert', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ raw_episode, headword })
                });

                if (!res.ok) throw new Error('サーバーエラーが発生しました');

                const data = await res.json();
                
                document.getElementById('ai-meaning').value = data.meaning || '';
                document.getElementById('ai-origin').value = data.origin || '';
                document.getElementById('ai-example').value = data.example || '';
                
                resultArea.classList.remove('hidden');
                
                // 隠しフィールドにも即時反映
                document.getElementById('dictionary_data').value = JSON.stringify(data);
                
            } catch (error) {
                console.error(error);
                alert('AI変換に失敗しました。時間をおいて再度お試しいただくか、直接入力してください。');
            } finally {
                thinking.classList.add('hidden');
            }
        }
    </script>

@endsection