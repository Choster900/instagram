<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table = "Post";
    protected $fillable = [
        "image_path",
        "description",
        "date_post",
        "user_id",
    ];
    /**
     * Get the user that owns the Posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   /**
    * Get all of the comments for the Posts
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function comments(): HasMany
   {
       return $this->hasMany(Comment::class, 'post_id');
   }
   public function likes(): HasMany
   {
       return $this->hasMany(Comment::class, 'post_id');
   }

}
