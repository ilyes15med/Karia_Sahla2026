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
    
 
  public function selected_sugggestion($suggestion){
    $this->message=$suggestion;
    $this->receive_message();

  }
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
public function Aiprocess($message){
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
      {{-- Header --}}
      <div class="bg-zinc-900 border-b border-zinc-800 px-6 py-4 flex-shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                {{-- AI Avatar --}}
                <div
                    class="w-9 h-9 rounded-full bg-zinc-700 border border-zinc-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-zinc-100 font-semibold text-base leading-tight">kariaSahla Assistant</h1>
                    
                </div>
            </div>
            
        </div>
    </div>

    {{-- Messages --}}
    <div
        class="flex-1 overflow-y-auto px-4 py-6">

    @if(empty($messages))
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center h-full gap-4 text-center px-4">
                <div class="w-14 h-14 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center">
                    <svg class="w-7 h-7 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-black font-medium text-lg">kariaSahla Assistant</h2>
                    <p class="text-zinc-500 text-sm mt-1 max-w-xs">
                        posez-moi n'importe quelle question sur kariaSahla !
                    </p>
                </div>
                {{-- Suggestion chips --}}
                <div class="flex flex-wrap gap-2 justify-center mt-2">
                    @foreach([
                        'quel est votre service ?',
                        'donner les hotels de wilaya ',
                        'cest qoui karaiSahla ?',
                      
                    ] as $suggestion)
                        <button
                            wire:click="selected_sugggestion('{{ addslashes($suggestion) }}')"
                            class="text-xs text-zinc-400 bg-zinc-800 border border-zinc-700 hover:border-zinc-600 hover:text-zinc-200 rounded-full px-3 py-1.5 transition-colors"
                        >
                            {{ $suggestion }}
                        </button>
                    @endforeach
                </div>
            </div>
    @else
    <!--messages-->
    <div class="w-full max-w-3xl h-screen mx-auto flex flex-col bg-zinc-900">

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto px-4 py-6 space-y-3">
            @foreach ($messages as $msg)
                <div class="flex {{ $msg['type'] === 'send' ? 'justify-start' : 'justify-end' }}">
                    <div class="max-w-xs px-4 py-2 rounded-2xl
                        {{ $msg['type'] === 'send' ? 'bg-blue-500 text-white' : 'bg-gray-700 text-white' }}">
                        
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
    @endif
        <!-- Input (ثابت) -->
        <div class="p-4 border-t border-zinc-800 bg-zinc-900">
            <form wire:submit.prevent="receive_message" class="flex gap-2">
                <input 
                    type="text"
                    wire:model.defer="message"
                    class="flex-1 px-4 py-2 rounded-xl bg-zinc-800 text-white outline-none"
                    placeholder="Type your message..."
                >
                <button class="bg-blue-600 px-4 py-2 rounded-xl text-white">
                    Send
                </button>
            </form>
        </div>
    
    </div>
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