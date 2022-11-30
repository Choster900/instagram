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
    public function usersent()
    {
        return $this->belongsTo(User::class);
    }
    public function userrecive()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the message for the Chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message()
    {
        return $this->hasMany(Comment::class, 'chat_id');
    }
}
