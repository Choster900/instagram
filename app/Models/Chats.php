<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_sent',
        'user_recive',
    ];

    /**
     * Get the user that owns the Chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_sent()
    {
        return $this->belongsTo(User::class,"user_sent");
    }
    public function user_recive()
    {
        return $this->belongsTo(User::class,"user_recive");
    }

    /**
     * Get all of the message for the Chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Messages::class,"chat_id");
    }
}
