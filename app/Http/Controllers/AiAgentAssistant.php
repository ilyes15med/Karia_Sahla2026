<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiAgentAssistant extends Controller
{
    //
    public function invoke_agent(Request $request){
        $message_client=$request->message;
        //crer nouvelle instance
        $response= AssistantKariasahla::make(auth()->user())->prompt($message_client);
        return (string) $response;

    }
}
