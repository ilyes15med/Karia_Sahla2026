<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Events\MessagesRead;
use App\Models\Chat as ChatModel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public $users, $chats, $selectedChat = null, $selectedUser = null, $message = "", $messages = null;
    public $limit = 10, $height;
    public $viewMode = "chats"; // chats or users

    public function getListeners()
    {
        return [
            "echo-private:chat.".Auth::id().",MessageSent" => 'messageReceived',
            "echo-private:chat.".Auth::id().",MessagesRead" => 'messagesRead',
            'loadMoreMessages',
            'resetLoadMoreTrigger'
        ];
    }

    public function toggleViewMode()
    {
        if($this->viewMode === 'chats') {
            $this->viewMode = 'users';
            $this->selectedChat = null;
            $this->selectedUser = null;
            $this->loadUsers();
        } else {
            $this->viewMode = 'chats';
            $this->loadChats();
        }
    }

    public function loadUsers()
    {
        $this->users = User::whereNot('id', Auth::id())->orderBy('created_at', 'desc')->get();
    }

    public function loadChats()
    {
        $this->chats = Auth::user()->chats()->with(['userOne', 'userTwo', 'messages'])->orderBy('last_message_at', 'desc')->get();
    }

    public function loadMessages()
    {
        if(!$this->selectedChat) return;

        $this->messages = $this->selectedChat->loadMessages($this->limit);

        $unreadedMessagesCount = $this->selectedChat->unreadedMessages()->count();

        if($unreadedMessagesCount > 0){
            $this->selectedChat->markMessagesAsRead();
            broadcast(
                new MessagesRead($this->selectedChat->id, $this->selectedUser->id)
            );
        }
    }

    public function loadMoreMessages()
    {
        $messagesCount = $this->selectedChat->messages()->count();
        $this->dispatch("messagesLoaded", height: $this->height);

        if($this->limit >= $messagesCount) return;

        $this->limit += 10;
        $this->loadMessages();
    }

    public function resetLoadMoreTrigger(int $height)
    {
        $this->height = $height;
    }

    public function selectUser($userId)
    {
        $user = User::find($userId);
        if(!$user) return;

        $chat = ChatModel::getOrCreateChatBetweenUsers(Auth::id(), $userId);

        $this->selectChat($chat->id);
        $this->toggleViewMode();
    }

    public function selectChat($chatId)
    {
        $this->limit = 10;
        
        $chat = ChatModel::find($chatId);
        if(!$chat || !$chat->isChatContainsUser(auth()->id()))return;

        $this->selectedUser = $chat->getOtherUser();
        $this->selectedChat = $chat;

        $this->loadMessages();

        $this->dispatch('chatSelected');
    }

    public function sendMessage()
    {
        if(!$this->selectedChat || !$this->selectedUser || trim($this->message) === '') return;

        $message = Message::create([
            'chat_id' => $this->selectedChat->id,
            'sender_id' => Auth::id(),
            'content' => $this->message,
        ]);

        $this->message = "";
        $this->messages->push($message);
        $this->selectedChat->update(['last_message_at' => now()]);
        $this->loadChats();
        $this->dispatch('messageSent');

        broadcast(
            new MessageSent($message->id, $this->selectedUser->id)
        );
    }

    public function messageReceived($data)
    {
        $message = Message::find($data['messageId']);
        if(!$message) return;

        $this->loadChats();
        if($this->selectedChat && $message->chat_id === $this->selectedChat->id) {
            $this->loadMessages();

            $this->dispatch('messageSent');
        }
    }

    public function messagesRead($data)
    {
        if(!$this->selectedChat) return;

        if($data['chatId'] === $this->selectedChat->id) {
            $this->loadMessages();
        }
    }   

    public function mount()
    {
        $this->loadChats();
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
