<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $message = $request->input('message');

        // Создаём HTTP-клиент
        $client = new Client();
        $apiKey = env('HUGGINGFACE_API_KEY');

        try {
            $response = $client->post('https://api-inference.huggingface.co/models/mistralai/Mixtral-8x7B-Instruct-v0.1', [
                'headers' => [
                    'Authorization' => "Bearer $apiKey",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'inputs' => "Ты чат-бот интернет-магазина электроники. Отвечай кратко и по делу. Вопрос: $message",
                    'parameters' => [
                        'max_new_tokens' => 100,
                        'temperature' => 0.7,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $reply = $data[0]['generated_text'] ?? 'Ошибка: нет ответа';

            // Убираем промпт из ответа, если он включён
            $reply = str_replace("Ты чат-бот интернет-магазина электроники. Отвечай кратко и по делу. Вопрос: $message", '', $reply);
            $reply = trim($reply);

        } catch (\Exception $e) {
            $reply = 'Извините, произошла ошибка: ' . $e->getMessage();
        }

        return response()->json(['reply' => $reply]);
    }
}