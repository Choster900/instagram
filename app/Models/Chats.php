<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_send",
        "user_recive",
    ];

    public function usersend(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'id');
    }
    public function userrecive(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'id');
    }
    /**
     * Get all of the message for the Chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function message(): HasMany
    {
        return $this->hasMany(Messages::class);
    }
}
