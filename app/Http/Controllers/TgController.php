<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Key;

class TgController extends Controller
{

    public function tgTest(Request $request)
    {
        $chatId = $request->input('message.chat.id');
        $text = $request->input('message.text');

        $foundKeys = Key::where('reg_number', 'like', '%' . $text . '%')->get();

        if ($foundKeys->isEmpty()) {
            $replyText = "По запросу '{$text}' ничего не найдено.";
        } else {

            $replyText = "Найдено совпадений: " . $foundKeys->count() . "\n\n";

            foreach ($foundKeys as $key) {
                $replyText .= "⚡ PT: " . $key->reg_number . "\n";
                $replyText .= "📍 Адрес: " . $key->device_address . "\n";
                $replyText .= "🔑 Цвет: " . $key->color . "\n";
                $replyText .= "\n";
            }
        }

        $botToken = env('TELEGRAM_BOT_TOKEN');
        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text'    => $replyText,
        ]);

        return response()->json(['status' => 'success']);
    }
}
