<?php

use Livewire\Component;
use App\Ai\Agents\AssistantKariasahla;




new class extends Component
{
    public string $input = '';

public bool $thinking = false;

public array $messages = [];

public string|null $conversationId = null;

public function sendMessage(): void
{
    
    $userMessage = trim($this->input);

    if (empty($userMessage)) {
        return;
    }

    $this->messages[] = [
        'role'    => 'user',
        'content' => $userMessage,
    ];

    $this->input = '';
    $this->thinking = true;

    $this->dispatch('message-added')->self();
}

public function getAiResponse(): void
{
    $lastUserMessage = collect($this->messages)
        ->where('role', 'user')
        ->last();

    if (! $lastUserMessage) {
        $this->thinking = false;
        return;
    }

    try {
        $agent = new AssistantKariasahla;

        if (is_null($this->conversationId)) {
            $response = $agent
                ->forUser(auth()->user())
                ->prompt($lastUserMessage['content']);

            $this->conversationId = $response->conversationId;
        } else {
            $response = $agent
                ->continue($this->conversationId, as: auth()->user())
                ->prompt($lastUserMessage['content']);
        }

        $this->messages[] = [
            'role'    => 'assistant',
            'content' => (string) $response,
        ];

    } catch (\Exception $e) {
        $this->messages[] = [
            'role'    => 'assistant',
            'content' => 'Sorry, I encountered an error. Please try again.',
        ];
    }

    $this->thinking = false;
    $this->dispatch('message-added');
}

public function clearConversation(): void
{
    $this->messages = [];
    $this->conversationId = null;
}



};
?>


<div x-data="{ autoScroll: true }" x-on:message-added.window="
        $nextTick(() => {
            if (autoScroll) {
                const el = $refs.messages;
                el.scrollTop = el.scrollHeight;
            }
        })
    " class="flex flex-col h-screen bg-zinc-950">

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
            <button wire:click="clearConversation"
                class="text-zinc-500 hover:text-zinc-300 text-xs transition-colors px-3 py-1.5 rounded-lg hover:bg-zinc-800">
                New chat
            </button>
        </div>
    </div>

    {{-- Messages --}}
    <div x-ref="messages" x-on:scroll="autoScroll = ($el.scrollTop + $el.clientHeight >= $el.scrollHeight - 50)"
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
                    <h2 class="text-zinc-200 font-medium text-lg">Laravel Assistant</h2>
                    <p class="text-zinc-500 text-sm mt-1 max-w-xs">
                        Ask me anything about kariaSahla
                    </p>
                </div>
                {{-- Suggestion chips --}}
                <div class="flex flex-wrap gap-2 justify-center mt-2">
                    @foreach([
                        'How do I use Eloquent scopes?',
                        'Explain Laravel queues simply',
                        'What is new in Laravel 12?',
                        'How does Livewire work?',
                    ] as $suggestion)
                        <button
                            wire:click="$set('input', '{{ $suggestion }}')"
                            class="text-xs text-zinc-400 bg-zinc-800 border border-zinc-700 hover:border-zinc-600 hover:text-zinc-200 rounded-full px-3 py-1.5 transition-colors"
                        >
                            {{ $suggestion }}
                        </button>
                    @endforeach
                </div>
            </div>
    @else
            {{-- Message Loop --}}
            <div class="max-w-3xl mx-auto space-y-6">
                @foreach($messages as $message)
                    @if($message['role'] === 'user')
                        {{-- User message --}}
                        <div class="flex items-end justify-end gap-3">
                            <div class="max-w-sm lg:max-w-lg bg-zinc-700 text-zinc-100 rounded-2xl rounded-br-sm px-4 py-3 text-sm leading-relaxed">
                                {{ $message['content'] }}
                            </div>
                            <div class="w-8 h-8 rounded-full bg-zinc-600 border border-zinc-500 flex items-center justify-center text-zinc-200 text-xs font-semibold flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                        </div>
                    @else
                        {{-- Assistant message --}}
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                </svg>
                            </div>
                            <div
                                class="max-w-sm lg:max-w-2xl bg-zinc-900 border border-zinc-800 text-zinc-200 rounded-2xl rounded-tl-sm px-4 py-3 text-sm leading-relaxed markdown-body"
                                x-data="{ content: @js($message['content']) }"
                                x-html="marked.parse(content)"
                            ></div>
                        </div>
                    @endif
                @endforeach

                {{-- Thinking indicator --}}
                @if($thinking)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09 3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                            </svg>
                        </div>
                        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl rounded-tl-sm px-4 py-3">
                            <div class="flex gap-1 items-center h-5">
                                <span class="w-1.5 h-1.5 bg-zinc-500 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                <span class="w-1.5 h-1.5 bg-zinc-500 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                <span class="w-1.5 h-1.5 bg-zinc-500 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

     {{-- Input Bar --}}
     <div class="bg-zinc-900 border-t border-zinc-800 px-4 py-4 flex-shrink-0">
        <div class="max-w-3xl mx-auto">
            <form wire:submit.prevent="sendMessage">
                <input type="text" wire:model="input">
                <button type="submit">Send</button>
            </form>
        </div>
    </div>



    <style>
        .markdown-body h1, .markdown-body h2, .markdown-body h3,
        .markdown-body h4, .markdown-body h5, .markdown-body h6 {
            font-weight: 600; margin-top: 1rem; margin-bottom: 0.4rem; color: #e4e4e7;
        }
        .markdown-body h1 { font-size: 1.2em; }
        .markdown-body h2 { font-size: 1.1em; }
        .markdown-body h3 { font-size: 1em; }
        .markdown-body p { margin-bottom: 0.6rem; }
        .markdown-body ul, .markdown-body ol { padding-left: 1.4rem; margin-bottom: 0.6rem; }
        .markdown-body ul { list-style-type: disc; }
        .markdown-body ol { list-style-type: decimal; }
        .markdown-body li { margin-bottom: 0.2rem; }
        .markdown-body strong { font-weight: 600; color: #f4f4f5; }
        .markdown-body em { font-style: italic; }
        .markdown-body code {
            background: #27272a; border: 1px solid #3f3f46;
            border-radius: 4px; padding: 0.1em 0.4em; font-size: 0.85em; color: #a78bfa;
        }
        .markdown-body pre {
            background: #18181b; border: 1px solid #3f3f46;
            border-radius: 8px; padding: 1rem; overflow-x: auto; margin-bottom: 0.8rem;
        }
        .markdown-body pre code {
            background: none; border: none; padding: 0; color: #d4d4d8; font-size: 0.85em;
        }
        .markdown-body blockquote {
            border-left: 3px solid #52525b; padding-left: 0.8rem; color: #a1a1aa; margin-bottom: 0.6rem;
        }
        .markdown-body hr { border-color: #3f3f46; margin: 0.8rem 0; }
        .markdown-body a { color: #818cf8; text-decoration: underline; }
        .markdown-body > *:last-child { margin-bottom: 0; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</div>
