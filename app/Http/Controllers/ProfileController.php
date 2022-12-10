<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


use App\Models\User;
use App\Models\Posts;
use App\Models\Followers;

class ProfileController extends Controller
{
    //
    private $user;
    private $followers;
    private $posts;

    public function __construc(User $user, Followers $followers,Posts $posts)
    {
        # code...
        $this->user = $user;
        $this->followers = $followers;
        $this->posts = $posts;

    }

    public function index($nick_name)
    {
        # code..
        $user = User::select("*")
            ->where('nick_name','=',$nick_name)
            ->first();

        $followed = Followers::select("*")
            ->where('follower_id','=',$user->id)
            ->count();

        $followers = $user->followers()->count();//analizar mejor esta consulta
        $postsCount = $user->post()->count();//analizar mejor esta consulta

        $publicaciones_de_usuario = Posts::first()->getPost($user->id,true);/* este createPost() esta en el modelo */
        
        return Inertia::render("UsersProfile/Index",[
            "userProfile" => $user,
            "followers" => $followers,
            "followed" => $followed,
            "postCount" => $postsCount,
            "publicaciones_de_usuario" => $publicaciones_de_usuario,
        ]);

         
    }
}
