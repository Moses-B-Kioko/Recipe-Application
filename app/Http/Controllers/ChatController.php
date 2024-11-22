<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        $question = $request->input('question');

        // Call the AI API (like OpenAI) to get a response
        $client = new Client();
        $response = $client->post('https://api.openai.com/v1/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'text-davinci-003',
                'prompt' => $question,
                'max_tokens' => 50
            ]
        ]);

        $responseBody = json_decode($response->getBody(), true);
        $answer = $responseBody['choices'][0]['text'] ?? 'Sorry, I couldn\'t find an answer to that.';

        return response()->json(['answer' => trim($answer)]);
    }
}
