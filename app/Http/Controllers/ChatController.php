<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Chats;
use App\Models\Messages;

class ChatController extends Controller
{
    private $chat;
    private $message;

    public function __construct(Chats $chat,Messages $message)
    {
        $this->chat = $chat;
        $this->message = $message;

    }

    public function index()
    {   
        $chats = $this->chat->with([
            "user_sent",
            "user_recive",
            "messages" => function($query){
                $query->latest();
            },
        ])->where("user_sent",auth()->user()->id)
        ->orWhere("user_recive",auth()->user()->id)
        ->get();

        return Inertia::render("Chat/Index",["chats" => $chats]);
    }
}
