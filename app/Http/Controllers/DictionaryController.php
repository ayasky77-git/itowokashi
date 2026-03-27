<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dictionary;
use Illuminate\Support\Str;
use App\Models\Word;
use App\Models\DictionaryUser;
use App\Models\WordReaction;



class DictionaryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $dictionaries = Dictionary::where(function($query) use ($user) {
            $query->where('creator_id', $user->id)
                ->orWhereHas('users', function ($q) use ($user) {
                    $q->where('dictionary_user.user_id', $user->id);
                });
        })
        ->leftJoin('dictionary_user', function($join) use ($user) {
            $join->on('dictionaries.id', '=', 'dictionary_user.dictionary_id')
                ->where('dictionary_user.user_id', '=', $user->id);
        })
        ->orderByDesc('dictionary_user.last_accessed_at')
        ->select('dictionaries.*')
        ->with('user')
        ->get();

        return view('dictionaries.index', compact('dictionaries'));
    }

    public function create()
    {
        // 🔽 追加

        return view('dictionaries.create');
    }

    
    public function store(Request $request)
    {
        // dd($request->all()); // ← フォームから来たデータを確認！
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'obi_text' =>'nullable',
            'color_code' =>'nullable',
            'spine_pattern' =>'nullable',
        ]);
        $validated['creator_id'] = auth()->id();
        $validated['invite_code']=Str::random(8);
        $dictionary = Dictionary::create($validated);
        DictionaryUser::create([
            'dictionary_id' => $dictionary->id,
            'user_id' => auth()->id(),
            'role' => 'admin',
        ]);

        return redirect()->route('dictionaries.index');
    }


    public function show(Dictionary $dictionary)
    {
        // ① まずメンバーチェック
        $isMember = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isMember) {
            abort(403);
        }

        // ② メンバー確認後にlast_accessed_atを更新
        DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->update(['last_accessed_at' => now()]);

        $words = Word::where('dictionary_id', $dictionary->id)
            ->where('status', 'published')
            ->orderBy('reading')
            ->get();

        $userRole = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->value('role');

        $members = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->with('user')
            ->get();

        $totalReactions = WordReaction::whereHas('word', fn($q) =>
            $q->where('dictionary_id', $dictionary->id)
        )->count();

        $draftCount = Word::where('dictionary_id', $dictionary->id)
            ->where('status', 'draft')
            ->count();

        return view('dictionaries.show', compact('words', 'dictionary', 'userRole', 'members', 'totalReactions','draftCount'));
    }

    public function edit(Dictionary $dictionary)
    {
        $user = auth()->user();

        // 1. この辞書における自分の情報を中間テーブルから取得
        // ※ 自分が管理者（作成者）の場合は 'admin' を、それ以外は中間テーブルの role を見る
        $membership = \App\Models\DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', $user->id)
            ->first();

        // 2. 権限（userRole）の判定
        // 作成者（creator_idが自分）なら文句なしに admin
        if ($dictionary->creator_id === $user->id) {
            $userRole = 'admin';
        } else {
            $userRole = $membership ? $membership->role : 'viewer';
        }

        // 3. 表示名（myNickname）の取得
        $myNickname = $membership ? $membership->nickname : $user->name;

        // 4. メンバー一覧（管理者用）
        $members = \App\Models\DictionaryUser::with('user')
            ->where('dictionary_id', $dictionary->id)
            ->get();

        return view('dictionaries.edit', compact('dictionary', 'userRole', 'myNickname', 'members'));
    }

    public function update(Request $request, Dictionary $dictionary)
    {
        $user = auth()->user();

        // 1. 管理者かどうかの判定
        $isAdmin = ($dictionary->creator_id === $user->id);

        // 2. バリデーション
        $rules = [
            'nickname' => 'nullable|string|max:20',
        ];
        if ($isAdmin) {
            $rules['title'] = 'required|string|max:12';
            $rules['obi_text'] = 'nullable|string|max:20';
            // 他のバリデーション項目があれば追加
        }
        $validated = $request->validate($rules);

        // 3. 【管理者のみ】辞書本体の更新
        if ($isAdmin) {
            $dictionary->update([
                'title' => $validated['title'],
                'obi_text' => $validated['obi_text'],
                'color_code' => $request->color_code,
                'spine_pattern' => $request->spine_pattern,
            ]);
        }

        // 4. 【全員共通】ニックネームの更新（ここが重要！）
        // dictionary_user テーブルから「この辞書」かつ「自分」の行を探す
        $membership = \App\Models\DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', $user->id)
            ->first();

        if ($membership) {
            // 特定した1行だけを更新する
            $membership->update([
                'nickname' => $request->nickname
            ]);
        } else {
            // もし中間テーブルにレコードがなければ作成する（保険）
            \App\Models\DictionaryUser::create([
                'dictionary_id' => $dictionary->id,
                'user_id' => $user->id,
                'nickname' => $request->nickname,
                'role' => $isAdmin ? 'admin' : 'editor',
            ]);
        }

        return redirect()->route('dictionaries.show', $dictionary)
            ->with('status', '設定を保存しました。');
    }

    public function destroy(Dictionary $dictionary)
    {
        $dictionary->delete();
        return redirect()->route('dictionaries.index', [$dictionary]);    
    }

}