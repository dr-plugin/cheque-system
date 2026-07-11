<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChequeAiController extends Controller
{
    public function readImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5120'],
        ]);


        try {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
            $mimeType = $image->getMimeType();


            $response = Http::withoutVerifying()
                ->withHeaders([

                    'Authorization' => 'Bearer ' . env('GAPGPT_API_KEY'),
                    'Content-Type' => 'application/json',

                ])->post('https://api.gapgpt.app/v1/responses', [

                    'model' => 'gpt-image-2',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => "Extract the cheque details and return ONLY a valid JSON object. Do not include any markdown styling, code blocks, or extra text.
                                            Fields to extract:
                                            - price (numeric value in Rials based on the cheque text)
                                            - sayadi_number (16 digits)
                                            - exporter (string, name of the drawer/exporter)
                                            - bank (one of: meli, mellat, saderat, sepah, tejarat, maskan, pasargad, saman, parsian, shahr)
                                            - due_date (due date formatted as YYYY-MM-DD Gregorian date)"
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => "data:{$mimeType};base64,{$imageData}"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'response_format' => ['type' => 'json_object']
                ]);

            if ($response->failed()) {

                Log::error('GapGPT API Error: ' . $response->body());

                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ارتباط با سرویس پردازش تصویر'
                ], $response->status());
            }

            $result = $response->json();
            $content = $result['choices'][0]['message']['content'] ?? '{}';

            $extractedData = json_decode($content, true);

            return response()->json([
                'success' => true,
                'data' => $extractedData
            ]);
        } catch (\Exception $e) {

            Log::error('Cheque Processing Exception: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطای سیستمی در پردازش تصویر: ' . $e->getMessage()
            ], 500);
        }
    }
}
