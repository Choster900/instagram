<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $fillable = [
        "chat_id",
        "user_id",
        "message",
        "file_path",
        "file_name",
        "send_date",
        "type"
    ];

    /**
     * Get the user that owns the Messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
    /**
     * Get all of the chat for the Messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chat(): HasMany
    {
        return $this->hasMany(Chats::class, 'foreign_key', 'local_key');
    }
}
