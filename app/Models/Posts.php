<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//WEAS QUE AÑADI MANUALMENTE
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Followers;


class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'description',
        'date_post',
        'user_id'
    ];

    public $appends = ['countComments','countLikes'];
 
    public function getCountCommentsAttribute()
    {
        # code...
        return $this->comments->count();
    }
    public function getCountLikesAttribute()
    {
        # code...
        return $this->likes->count();

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class,"post_id");
    }
    public function likes()
    {
        return $this->hasMany(Likes::class,"post_id");
    }

    public static function createPost($request)
    {
        # code...
        $file = $request->file("image");


        $name = $file->getClientOriginalName();

        $url = null;

        $storage = Storage::disk('public')->put($name,$file);

        $url = asset('storage/'.$storage);

        $post = (new static)::create([
            'image_path'    => $url,
            'description'   => $request->text,
            'date_post'     => Carbon::now(),
            'user_id'       => Auth::id(),
        ]);

        return (new static)::with([
            'user',
            'comments',
            'likes',
        ])->find($post->id);

    }

    public function getPost($id)
    {
        return (new static)::with([
            'user',
            'comments' => function($query){//esto es como un inner join
                $query->with('user:id,name,nick_name,profile_photo_path');
            },
            'likes',
        ])
        ->where("user_id",$id)
        ->orWhereIn("user_id",Followers::select('user_id')->where('follower_id',$id)->get())
        ->orderBy("created_at","desc")
        ->get();
    }
    
}
