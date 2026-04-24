<?php

use Livewire\Component;
use App\Ai\Agents\AssistantKariasahla;
use App\Models\User;
use App\Models\conversation_ia;
use Livewire\Attributes\On;

new class extends Component
{
    public string $message = '';
    public array $messages=[];
    
 

    // si le client have une conversetion agent ia

 
    public function receive_message()
{
    $this->validate([
        'message' => 'required|max:255',
    ]);

    $msg = $this->message;

    $this->messages[] = [
        'Mess' => $msg,
        'type' => 'send'
    ];

    $this->messages[] = [
        'Mess' => '...',
        'type' => 'loading'
    ];

    $this->message = '';

    $this->dispatch('Ai-process', message: $msg);
}
#[On('Ai-process')]
public function Aiprocess($message)
{
    $user = auth()->user();

    $Conversation_client = $user->conversation_ia()->first();

    if (!$Conversation_client) {
        $Conversation_client = $user->conversation_ia()->create([
            'user_id' => $user->id,
            'title' => $message,
        ]);
    }

    $Conversation_client->messages()->create([
        'conversation_id' => $Conversation_client->id,
        'content' => $message,
        'user_id' => $user->id
    ]);

    $agent = new AssistantKariasahla($user);
    $reponse = $agent->prompt($message);

    $reponseString = data_get($reponse, 'text')
        ?? data_get($reponse, 'output')
        ?? 'aucune réponse';

    if (is_array($reponseString)) {
        $reponseString = json_encode($reponseString);
    }

    array_pop($this->messages);

    $this->messages[] = [
        'Mess' => $reponseString,
        'type' => 'received'
    ];
}

};

?>

<div class="chat-container">
    <!--messages-->
    <div class="p-4 space-y-3">
    
        @foreach ($messages as $msg)
            <div class="flex {{ $msg['type'] === 'send' ? 'justify-start' : 'justify-end' }}">
                
                <div class="max-w-xs px-4 py-2 rounded-2xl shadow
                    {{ $msg['type'] === 'send' 
                        ? 'bg-blue-500 text-white rounded-bl-none' 
                        : 'bg-gray-700 text-white rounded-br-none' 
                    }}
                ">
                @if($msg['type'] === 'loading')
                <span class="flex gap-1">
                    <span class="animate-bounce">.</span>
                    <span class="animate-bounce delay-100">.</span>
                    <span class="animate-bounce delay-200">.</span>
                </span>
                @else
                    {{ $msg['Mess'] }}
                @endif
                   
                </div>
    
            </div>
        @endforeach
    
    </div>
    
  

    <!-- Form -->
    <form wire:submit.prevent ="receive_message" class="chat-input">
        
        <input 
            type="text" 
            wire:model="message"
            placeholder="Type your message..."
        >

        @error('title') 
            <span class="error">{{ $message }}</span> 
        @enderror

        <button type="submit">Send</button>
    </form>

</div>

<style>
.chat-container {
    width: 100%;
    max-width: 700px;
    height: 90vh;
    margin: auto;
    display: flex;
    flex-direction: column;
    background: #1e1e2f;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
}

/* Header */
.chat-header {
    background: #2a2a40;
    color: white;
    padding: 15px;
    text-align: center;
    font-weight: bold;
}

/* Messages */
.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Message bubbles */
.message {
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 20px;
    font-size: 14px;
}

/* Left (other user) */
.message-left {
    background: #2f2f4f;
    color: white;
    align-self: flex-start;
}

/* Right (me) */
.message-right {
    background: #4f46e5;
    color: white;
    align-self: flex-end;
}

/* Input */
.chat-input {
    display: flex;
    padding: 10px;
    background: #2a2a40;
    gap: 10px;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border-radius: 20px;
    border: none;
    outline: none;
}

.chat-input button {
    background: #4f46e5;
    border: none;
    padding: 10px 15px;
    border-radius: 20px;
    color: white;
    cursor: pointer;
}

.chat-input button:hover {
    background: #4338ca;
}

/* Error */
.error {
    color: red;
    font-size: 12px;
}
</style>