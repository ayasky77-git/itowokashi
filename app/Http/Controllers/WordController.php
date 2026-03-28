<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Dictionary;
use App\Models\Tag;
use App\Models\DictionaryUser;
use App\Models\WordReaction;

class WordController extends Controller
{

    public function index(Dictionary $dictionary)
    {
        $initial = request('initial', '');

        $query = Word::where('dictionary_id', $dictionary->id)
            ->where('status', 'published')
            ->orderBy('reading');

        if ($initial === 'other') {
            // かな以外
            $kana = ['あ','い','う','え','お','か','き','く','け','こ','さ','し','す','せ','そ',
                    'た','ち','つ','て','と','な','に','ぬ','ね','の','は','ひ','ふ','へ','ほ',
                    'ま','み','む','め','も','や','ゆ','よ','ら','り','る','れ','ろ','わ','を','ん'];
            $query->whereNotIn('initial_char', $kana);
        } elseif ($initial !== '') {
            // 行フィルター（例：「か」→ か行全体）
            $rowMap = [
                'あ' => ['あ','い','う','え','お'],
                'か' => ['か','き','く','け','こ'],
                'さ' => ['さ','し','す','せ','そ'],
                'た' => ['た','ち','つ','て','と'],
                'な' => ['な','に','ぬ','ね','の'],
                'は' => ['は','ひ','ふ','へ','ほ'],
                'ま' => ['ま','み','む','め','も'],
                'や' => ['や','ゆ','よ'],
                'ら' => ['ら','り','る','れ','ろ'],
                'わ' => ['わ','を','ん'],
            ];
            $chars = $rowMap[$initial] ?? [$initial];
            $query->whereIn('initial_char', $chars);
        }

        $words = $query->get();

        return view('dictionaries.words.index', compact('dictionary', 'words', 'initial'));
    }

    public function create(Dictionary $dictionary)
    {
        $isMember = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            abort(403);
        }
        $tags = Tag::where('dictionary_id', $dictionary->id)->get();
        return view('dictionaries.words.create', compact('dictionary', 'tags'));
    }
    
    public function store(Request $request,Dictionary $dictionary)
    {
        // dd($request->all()); // ← フォームから来たデータを確認！
    
        $isMember = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            abort(403);
        }    
        $validated = $request->validate([
            'headword' =>'required',
            'reading' =>'required',
            'initial_char' =>'required',
            'raw_episode' => 'required',
            'status' =>'required',
            'image_path' =>'nullable',
            'dictionary_data' =>'nullable',
        ]);
        $validated['is_public'] = false;
        $validated['user_id'] = auth()->id();
        $validated['dictionary_id'] = $dictionary->id;
        $validated['last_editor_id']=auth()->id();

        // dd($request->hasFile('image_path'), $request->file('image_path'));
        // 画像をローカルに保存
        unset($validated['image_path']);
        if ($request->hasFile('image_path')) {
        $path = $request->file('image_path')->store('images', 'public');
        $validated['image_path'] = $path;
        }
        
        $word=Word::create($validated);
        $word->tags()->sync($request->tag_ids ?? []);
        return redirect()->route('dictionaries.words.show', [$dictionary, $word]);
    }

    public function show(Dictionary $dictionary, Word $word)
    {
        $userRole = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->value('role');

        $reactionCount = WordReaction::where('word_id', $word->id)->count();


        return view('dictionaries.words.show', compact('word', 'dictionary', 'userRole', 'reactionCount'));
    }

    public function edit(Dictionary $dictionary, Word $word)
    {
        $isMember = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            abort(403);
        }
        $tags = Tag::where('dictionary_id', $dictionary->id)->get();
        return view('dictionaries.words.edit', compact('word', 'dictionary', 'tags'));
    }

    public function update(Request $request,Dictionary $dictionary,Word $word)
    {        
        $isMember = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            abort(403);
        }
        $validated = $request->validate([
            'headword' =>'required',
            'reading' =>'required',
            'initial_char' =>'required',
            'raw_episode' => 'required',
            'status' =>'required',
            'image_path' =>'nullable',
            'dictionary_data' =>'nullable',

        ]);
        $validated['is_public'] = false;
        $validated['last_editor_id']=auth()->id();
        unset($validated['image_path']);
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('images', 'public');
            $validated['image_path'] = $path;
        }
        $word->update($validated);
        $word->tags()->sync($request->tag_ids ?? []);
        return redirect()->route('dictionaries.words.show', [$dictionary, $word]);
    }

    public function destroy(Dictionary $dictionary, Word $word)
    {
        $isMember = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            abort(403);
        }
        $word->delete();
        return redirect()->route('dictionaries.show', [$dictionary]);    
    }

}
