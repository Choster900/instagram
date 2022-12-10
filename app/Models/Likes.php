<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    /**
     * Get the user that owns the Comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Posts::class);
    }

    public static function giveLike($postId,$userId)
    {
        return (new static)::create([
            'post_id' => $postId,
            'user_id' => $userId
        ]);
    }

    public static function deleLike($postId,$userId)
    {
        (new static)::where([
            'post_id' => $postId,
            'user_id' => $userId
        ])->delete();
    }
}
