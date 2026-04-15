<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\message;

class chat extends Model
{
    //
    protected $fillable=[
       'user_id_one','user_id_two','last_message_at'
    ];
    public function userOne(){
        return $this->belongsTo(User::class, 'user_id_one');
    }

    public function userTwo(){
    return $this->belongsTo(User::class, 'user_id_two');
    }
    public function messages(){

        return $this->hasMany(message::class);
    }
    

   public static function getChatBetweenUsers($user1, $user2){
    $chat = self::where(function ($query) use ($user1, $user2) {
        $query->where('user_id_one', $user1)
              ->where('user_id_two', $user2);
    })->orWhere(function ($query) use ($user1, $user2) {
        $query->where('user_id_one', $user2)
              ->where('user_id_two', $user1);
    })->first();

    
    if (!$chat) {
        $chat = self::create([
            'user_id_one' => $user1,
            'user_id_two' => $user2,
            'last_message_at' =>now()
        ]);
    }

    return $chat;
    }
    
    public function getOtherUser(){
       return Auth()->id()===$this->user_id_one ? $this->userTwo:$this->userOne;
    }
    
    public function lastmessage(){

        return $this->messages()->latest()->first();
    }
  
    
   
}
