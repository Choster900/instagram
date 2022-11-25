<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;
    protected $fillable = [
        "post_id",
        "user_id",
    ];

    /**
     * Get the user that owns the Likes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'id');
    }
    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'id');
    }
}
