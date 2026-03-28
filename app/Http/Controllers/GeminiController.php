<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function convert(Request $request)
    {
        $headword = $request->headword;
        $episode = $request->raw_episode;

        $prompt = <<<EOT
            あなたは、特定のコミュニティ（家族、恋人、友人、仲間など）だけで通じる言葉を記録する「思い出の共有辞書編纂者」です。
            ユーザーから提供されたエピソードを、そのコミュニティで後で見返した時に「笑える」「懐かしめる」「励まされる」ような、温かみのある辞書形式に整理してください。

            【出力のゴール】
            世間一般の定義ではなく、そのコミュニティ特有の「真実」をそのまま反映してください。

            【重要ルール】
            1. **事実と固有名詞の尊重**：エピソード内の人名、地名、特定の名称はそのまま使用し、ぼかしたり変えたりしないでください。
            2. **AIの過剰な演出を封印**：AIによる大げさな形容詞（「無垢な」「かけがえのない」など）や、難解な学術的表現（「当該個体」「音韻」など）は絶対に使用しないでください。
            3. **自然なユーモアと温かみ**：言い間違いや失敗も、そのコミュニティの愛すべき「ネタ」として、微笑ましく肯定的に記述してください。
            4. **文体の統一**：語尾は辞書らしく「〜のこと」「〜を指す」「〜に由来する」で統一しつつ、内容は親しみやすく。

            見出し語: {$headword}
            エピソード: {$episode}

            以下のキーを含むJSONを返してください（JSONのみ、説明不要）：
            - meaning（意味：そのコミュニティ内での定義。誰の、どういう言葉か。事実を簡潔に）
            - part_of_speech（品詞：動詞・形容詞・形容動詞・名詞・副詞・連体詞・接続詞・感動詞・助動詞・助詞など一般的な単語のルールに合わせて。不明なものは造語にしてください）
            - origin（語源：その言葉が生まれた背景や、当時の状況。固有名詞をそのまま使って記述）
            - example（用例：そのコミュニティで交わされる、自然な会話文）
            - usage_notes（使い方メモ：今現在、どんな時にこの言葉が出てくると笑いや懐かしさが生まれるか）
        EOT;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . config('services.gemini.api_key'), [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        $text = $response->json()['candidates'][0]['content']['parts'][0]['text'];
        $text = preg_replace('/^```json\s*|\s*```$/s', '', trim($text));
        $dictionaryData = json_decode($text, true);

        return response()->json($dictionaryData);
    }
}