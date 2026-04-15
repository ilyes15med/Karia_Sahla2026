<div>
    <div id="chat-container"
    class="w-full h-screen  max-w-7xl bg-zinc-900 sm:rounded-3xl shadow-2xl overflow-hidden flex animate-fade-in">
    <!-- Left Sidebar -->
    <div id="left-sidebar" class="w-full md:w-80 lg:w-96 bg-zinc-800 border-r border-zinc-700 flex flex-col">
        <!-- Header -->
        <div style="height: 90px" class="p-4 sm:p-5 border-b border-zinc-700 flex items-center justify-between">
            <h1 id="section-title" class="text-xl sm:text-2xl font-bold text-white">
                {{$viewMode=="chats" ? "chats":"users" }}
            </h1>
            <button id="toggleViewBtn" wire:click="toggleViewMode"
                class="p-2 rounded-lg bg-zinc-700 hover:bg-zinc-600 transition-all duration-300 glow-hover group">

            @if ($viewMode=="chats")
                 <!-- Chat Icon -->
               <svg id="chatIcon" class="w-5 h-5 sm:w-6 sm:h-6 text-cyan-400 icon-rotate" fill="none"
               stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
               </path>
           </svg> 
                
            @else
                <!-- Users Icon -->
                <svg id="usersIcon" class="w-5 h-5 sm:w-6 sm:h-6 text-cyan-400 icon-rotate" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                
            @endif
               
               
            </button>
        </div>

       

     
             <!-- Contacts List -->
        <div id="contacts-list" class="flex-1 overflow-y-auto custom-scrollbar">
                
            @if ($viewMode=="chats")
                @forelse ($chats as $chat )
                <?php $otherUser =$chat->getOtherUser() ?>

                         <!-- Contact 1 - Active -->
                <div wire:click="selectedChat({{ $chat->id }})"
                class="p-3 sm:p-4 hover:bg-zinc-700 cursor-pointer transition-all duration-300 border-l-4 border-cyan-400 bg-zinc-750 animate-slide-in message-hover">
                <div class="flex items-start space-x-2 sm:space-x-3">
                    <div
                        class="user-image w-10 h-10 sm:w-12 sm:h-12 rounded-full ring-2 ring-cyan-400 flex-shrink-0 bg-zinc-700 flex items-center justify-center text-lg sm:text-xl font-semibold text-white">
                        {{ strtoupper(substr($otherUser->name,0,1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h3 class="text-white font-semibold truncate text-sm sm:text-base">
                                {{ $otherUser->name }}
                            </h3>
                            <span class="time-box text-xs text-cyan-400 ml-2 flex-shrink-0">{{ $chat->last_message_at }}</span>
                        </div>
                        <p class="text-xs sm:text-sm text-zinc-400 truncate">
                            You said that stuff or yo...
                        </p>
                    </div>
                </div>
                </div>
                   
                    @empty
                    <div class="text-center p-4 text-zinc-400">aucun  conversion trouvée </div>
                        
                        
                    @endforelse

                

              
                    
                @else
                   
                   
            <!-- Usre Box -->
   
         
            @if (empty($users) || $users->isEmpty())
            <div class="p-4 text-center text-zinc-400">
                No users found.
            </div> 
                
            @else
                
          
            @foreach ($users as $user )
                
          
            <div 
                class="p-3 sm:p-4 hover:bg-zinc-700 cursor-pointer transition-all duration-300 border-l-4 border-transparent hover:border-cyan-400 animate-slide-in message-hover">
                <div 
                    wire:click="selectedUser({{ $user->id }})" 
                    class="flex items-start space-x-2 sm:space-x-3" >
                    <div
                        class="w-10 h-10 sm:w-12 sm:h-12 rounded-full ring-2 ring-cyan-400 flex-shrink-0 bg-zinc-700 flex items-center justify-center text-lg sm:text-xl font-semibold text-white">
                           {{ strtoupper(substr($user->name,0,1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h3 class="text-white font-semibold truncate text-sm sm:text-base">{{$user->name}}</h3>
                            <span class="text-xs text-cyan-400 ml-2 flex-shrink-0">Online</span>
                        </div>
                        <p class="text-xs sm:text-sm text-zinc-400 truncate">{{ $user->email }}</p>
                    </div>
                </div>
            </div> 

            @endforeach
            @endif
                    
            @endif
            
       
        </div>
    </div>

    <!-- Right Chat Area -->
    <div id="chat-area" class="hidden md:flex flex-1 flex-col">
    @if($selectChat && $selectUser)
        <!-- Chat Header -->
        <div style="height:90px"
            class="p-4 sm:p-5 bg-zinc-800 border-b border-zinc-700 flex items-center justify-between animate-slide-in">
            <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                <button
                    class="md:hidden p-2 rounded-lg hover:bg-zinc-700 transition-all duration-300 glow-hover flex-shrink-0"
                    id="backButton">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-cyan-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-full ring-2 ring-cyan-400 glow-effect flex-shrink-0 bg-gray-700 flex items-center justify-center text-lg sm:text-xl font-semibold text-white">
                    {{ strtoupper(substr( $selectUser->name,0,1)) }}
                </div>
                <div class="min-w-0">
                    <h2 class="text-white font-bold text-base sm:text-lg truncate">
                      {{ $selectUser->name}}
                    </h2>
                    <p class="text-xs sm:text-sm text-cyan-400">
                        Online
                    </p>
                </div>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="messages-area"
            class="flex-1 overflow-y-auto custom-scrollbar p-3 sm:p-4 md:p-6 space-y-3 sm:space-y-4 bg-gradient-to-b from-zinc-900 to-zinc-800">
            <!-- Info Message -->
            <div id="load-more-indicator" class="flex justify-center animate-fade-in">
                <div class="bg-zinc-700 text-zinc-300 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm">
                    Load more...
                </div>
            </div>

            <!-- Received Message 1 -->
           
    @foreach($selectChat->messages as $msg)
           
            <div class="flex items-end space-x-2 animate-slide-in" style="animation-delay: 0.4s">
                <div
                    class="w-6 h-6 sm:w-8 sm:h-8 rounded-full flex-shrink-0 bg-zinc-700 flex items-center justify-center text-sm sm:text-base font-semibold text-white">
                    Hote
                </div>
                <div class="flex flex-col max-w-[75%] sm:max-w-md">
                    <div
                        class="bg-zinc-700 text-white px-3 sm:px-4 py-2 sm:py-3 rounded-2xl rounded-bl-none message-bubble">
                        <p class="text-sm sm:text-base">
                            {{ $msg->content }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2 mt-1 ml-2">
                        <span class="text-xs text-zinc-500">2:30 PM</span>
                    </div>
                </div>
            </div>
        
    @endforeach
        <!-- Message Input -->
        <div id="message-input-container" class="p-3 sm:p-4 bg-zinc-800 border-t border-zinc-700">
            <form id="message-form" wire:submit.prevent="send_message" class="flex items-center space-x-2 sm:space-x-3">
                <input wire:model="message"
                id="message-input" type="text" placeholder="Write your message..."
                    class="flex-1 bg-zinc-700 text-white px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300" />
                <button 
                 id="send-message-button" type="submit"
                    class="p-2 sm:p-3 bg-cyan-500 hover:bg-cyan-600 rounded-xl transition-all duration-300 glow-effect hover:scale-105 flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="q2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    @endif   
    </div>
    
</div>
</div>
