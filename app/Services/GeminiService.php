<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiService
{
    public function askWithContext(string $question, string $pdfText): string
    {
        $apiKey = config('services.gemini.api_key');

        if (blank($apiKey)) {
            throw new RuntimeException('Gemini API key is missing. Add GEMINI_API_KEY in your .env file.');
        }

        $prompt = <<<PROMPT
You are a precise PDF assistant.
Answer only from the provided PDF content.
If the answer is not present in the PDF content, say:
"I could not find that in the uploaded PDF."

PDF Content:
{$pdfText}

User Question:
{$question}
PROMPT;

        $response = Http::timeout(60)->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key='.$apiKey,
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.2,
                ],
            ]
        );

        if (! $response->successful()) {
            // throw new RuntimeException('Gemini request failed: '.$response->body());
            throw new RuntimeException('Request failed, please try again.');
        }

        return data_get($response->json(), 'candidates.0.content.parts.0.text', 'No response returned.');
    }
}
