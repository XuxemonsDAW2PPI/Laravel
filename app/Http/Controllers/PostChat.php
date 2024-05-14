<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
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
        $collection = Message::whereHas('chat', function ($q) use ($OtherUserId, $user_id) {
            $q->where('from_user', $OtherUserId)
                ->where('to_user', $user_id);
        })->orWhere(function ($q) use ($OtherUserId, $user_id) {
            $q->where('from_user', $user_id)
                ->where('to_user', $OtherUserId);
        })->get();
        if (count($collection) > 0) {
            return $collection;
        }
        return false;
    }

    public function SendMessage($user_id, SendMessageRequest $request)
    {
        $userid = User::where('id', $user_id)
        ->first();
        if ($request->to == $userid->name){
            return response()->json(['message' => "You cannot send message to yourself"]);
        }

        $OtherUserId = User::where("name",$request->to)->first()->id;
        $collection = $this->IsTherePreviousChat($OtherUserId,$userid);

        if ($collection == false) {
            $chat = Chat::create([
                'user_id' => $userid
            ]);
        }
            $message = Message::create([
            'from_user' => $userid,
            'to_user'   => $OtherUserId,
            'content'   => $request->message ,
            'chat_id'   => $collection == false? $chat->id:$collection[0]->chat_id,
    ]);

        broadcast(new SendMessageEvent($message->toArray()))->toOthers();
    }
}
