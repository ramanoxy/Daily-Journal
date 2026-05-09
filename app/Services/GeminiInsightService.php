<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiInsightService
{
    private string $endpoint;
    private string $apiKey;

    public function __construct()
    {
        // Kita pakai model gemini-1.5-flash karena cepat dan cocok untuk analisis teks
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
        $this->apiKey = config('services.gemini.key');
    }

    public function generateWeeklyInsight(string $compiledEntries)
    {
        // Prompt Engineering: Memaksa AI menjadi mesin analitik yang kaku
        $prompt = "
            You are an analytical productivity engine. Analyze the following 7 days of journal entries.
            Constraints:
            1. ONLY base your analysis on the provided text. Do not invent or infer outside events.
            2. Output strictly in JSON format.
            3. No markdown formatting blocks around the JSON.
            4. Keep suggestions highly specific and actionable based on the user's actual entries, avoiding generic advice.
            5. Write all the text values inside the JSON in Indonesian (Bahasa Indonesia), but MUST KEEP the JSON keys exactly as specified in English.
            
            Expected JSON Schema:
            {
                \"sentiment_score\": int (1-100, where 100 is highly positive/focused),
                \"primary_blockers\": [\"string\", \"string\"],
                \"suggestions\": [\"actionable step 1\", \"actionable step 2\"],
                \"summary\": \"A strict 2-sentence objective summary of the week's patterns.\"
            }
            
            Data to Analyze:
            {$compiledEntries}
        ";

        // Menembak API Gemini dengan format JSON yang strict
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("{$this->endpoint}?key={$this->apiKey}", [
            'contents' => [
                ['role' => 'user', 'parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'temperature' => 0.1, // Suhu rendah = jawaban deterministik dan nggak halu
                'responseMimeType' => 'application/json', // Paksa response format JSON (Fitur Gemini)
            ]
        ]);

        // Tangani kalau gagal
        if ($response->failed()) {
            Log::error('Gemini API Error: ' . $response->body());
            return null;
        }

        // Ambil teks JSON dari response Google dan ubah jadi Array PHP
        $responseData = $response->json('candidates.0.content.parts.0.text');
        return json_decode($responseData, true);
    }
}