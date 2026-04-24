<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class conversation_ia_messages extends Model
{
    //
    protected $table="agent_conversation_messages";
    protected $fillable=[
        'conversation_id',
        'user_id',
        'content'

    ];
    public function conversation_ia(){
        $this->belongsTo(conversation_ia::class,'conversation_id');
    }
}
