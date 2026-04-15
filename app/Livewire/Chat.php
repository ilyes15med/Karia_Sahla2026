<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User; 
use App\Models\message; 
use App\Models\chat as chatModel;
use Illuminate\Support\Facades\Auth;
use App\Events\messageSent;


class Chat extends Component
{   
    
    public $users,$chats,$selectChat=null,$selectUser=null,$message=null;
    public $viewMode="chats";
    public function toggleViewMode(){

        $this->viewMode=$this->viewMode ==="chats"? "users":"chats";
    }
  
    public function selectedUser($userId){
        if(!User::find($userId)) return ;
        $chats=chatModel::getChatBetweenUsers($userId,Auth()->user()->id);
        $this->viewMode="chats";
        $this->loadChat();
    }

    public function loadChat(){
        $this->chats=auth()->user()->chat()->with(['userOne','userTwo','messages'])->get();
    }
    public function loadUsers(){
        $this->users= User::whereHas('reservations')->get();
    }
    public function selectedChat($idchat){
        $chat=chatModel::find($idchat);
        if(!$chat) return ;
        $this->selectChat=$chat;
        $this->selectUser=$chat->getOtherUser();
       
    }
    public function send_message(){
        if(!$this->selectChat || !$this->message) return ;
        $msg=message::create([
            'chat_id'=>$this->selectChat->id,
            'sender_id' =>Auth()->user()->id,
            'content'=>$this->message,

        ]);
        //maintenant empty l'input
        $this->message=null;
        $this->selectChat->load('messages');
        //broadcast(new messageSent($msg->id,$this->selectUser->id));
        broadcast(new messageSent($msg->id, $this->selectUser->id))->toOthers();
    }
  
    public function getListeners()
    {
    return [
        "echo-private:chat." . auth()->id() . ",Message_sent" => 'receiveMessage',
    ];
    }
    public function receiveMessage(){
        $this->selectChat->load('messages');
    }
    public function mount(){
     
       $this->loadChat();
       $this->loadUsers();
    
    
    }
    public function render()
    {
        return view('livewire.chat');
    }
}
