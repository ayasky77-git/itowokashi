<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dictionary;
use App\Models\DictionaryUser;


class InvitationController extends Controller
{

    public function show()
    {
        return view('invitations.show');
    }    


    public function join(Request $request)
    {
        $dictionary = Dictionary::where('invite_code', $request->invite_code)->firstOrFail();
        $alreadyJoined = DictionaryUser::where('dictionary_id', $dictionary->id)
            ->where('user_id', auth()->id())
            ->exists();
        if ($alreadyJoined) {
            return redirect()->route('dictionaries.show', $dictionary);
        }

        DictionaryUser::create([
            'dictionary_id' => $dictionary->id,
            'user_id' => auth()->id(),
            'role' => 'editor',
        ]);
        return redirect()->route('dictionaries.show', $dictionary);
    }
}
