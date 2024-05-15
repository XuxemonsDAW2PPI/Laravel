<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Http\Requests\SendMessageRequest;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostChat extends Controller
{
    public function IsTherePreviousChat($OtherUserId, $user_id)
    {
        // Busca mensajes donde el chat existe entre los dos usuarios
        $collection = Message::whereHas('chat', function ($q) use ($OtherUserId, $user_id) {
            $q->where('from_user', $OtherUserId)
                ->where('to_user', $user_id);
        })->orWhere(function ($q) use ($OtherUserId, $user_id) {
            $q->where('from_user', $user_id)
                ->where('to_user', $OtherUserId);
        })->get();
        
        // Retorna la colección de mensajes si existe algún chat previo
        return $collection->isEmpty() ? false : $collection;
    }

    public function SendMessage($user_id, SendMessageRequest $request)
    {
        // Obtén el usuario que está enviando el mensaje
        $user = User::findOrFail($user_id);

        // Verifica si el usuario está intentando enviarse un mensaje a sí mismo
        if ($request->to == $user->nombre) {
            return response()->json(['message' => "You cannot send a message to yourself"]);
        }

        // Obtén el ID del usuario destinatario
        $OtherUser = User::where("nombre", $request->to)->firstOrFail();

        // Verifica si hay un chat previo entre los dos usuarios
        $previousChat = $this->IsTherePreviousChat($OtherUser->id, $user_id);

        // Si no hay chat previo, crea uno nuevo
        if (!$previousChat) {
            $chat = Chat::create([
                'user_id' => $user_id,
                'other_user_id' => $OtherUser->id
            ]);
        } else {
            // Obtén el primer chat encontrado
            $chat = $previousChat->first()->chat;
        }

        // Crea el nuevo mensaje
        $message = Message::create([
            'from_user' => $user_id,
            'to_user' => $OtherUser->id,
            'content' => $request->message,
            'chat_id' => $chat->id,
        ]);

        // Emitir evento para notificar a los usuarios
        broadcast(new SendMessageEvent($message->toArray()))->toOthers();

        return response()->json(['message' => 'Message sent successfully']);
    }
}
