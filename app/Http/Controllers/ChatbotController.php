<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Client;
use OpenAI\OpenAI;

class ChatbotController extends Controller
{
    public function getResponse(Request $request)
    {
        $userMessage = $request->input('message');

        // Call OpenAI API for ChatGPT response
        $response = $this->getChatbotReply($userMessage);

        return response()->json(['reply' => $response]);
    }

    private function getChatbotReply($message)
    {
        // Replace 'YOUR_API_KEY' with your actual OpenAI API key
        $client = new OpenAI\Client('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');

        $response = $client->completions->create([
            'model' => 'text-davinci-003',
            'prompt' => $message,
            'max_tokens' => 150,
        ]);

        return $response['choices'][0]['text'] ?? 'Sorry, I couldn\'t understand that.';
    }
}
