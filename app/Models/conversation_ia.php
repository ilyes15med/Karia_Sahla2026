<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class conversation_ia extends Model
{
    //
    protected $table="agent_conversations";
    protected $fillable=[
        'user_id','title'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
 
    public function messages(){
       return  $this->hasMany(conversation_ia_messages::class,'conversation_id');
    }
}
