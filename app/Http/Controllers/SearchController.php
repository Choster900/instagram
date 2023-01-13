<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

//ESTOS LOS AGREGE YO POR MI CUENTA

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Posts;
use App\Models\Followers;


class SearchController extends Controller
{
    //
    private $user;
    private $follower;
    private $post;

    public function __construc(User $user, Followers $follower,Posts $post)
    {
        # code...
        $this->user = $user;
        $this->follower = $follower;
        $this->post = $post;

    }

    public function search($nick_name)
    {
        # code...
        return  User::select("*")
                    ->where('nick_name','like','%'.$nick_name.'%')
                    ->get();
    }

    public function userIFollow($nick_name)
    {//TODO: REVISAR ESTO 

      /*   return User::with([
            
            "followers" => function($query){
               //$query->where("follower_id", auth()->user()->id);
            },
        ]) */
       /*  ->whereHas('followers',function(Builder $query){
            $query->where('follower_id', 1);
        }) */
        /* ->where('nick_name','like','%'.$nick_name.'%')
        ->get(); */

  /*       return Post::whereHas('comments', function (Builder $query) {
            $query->where('content', 'like', 'code%');
        })->get(); */


      /*   return User::whereHas('followers', function ($query) {
            $query->where('users.idss',"=", "followers.follower_id" );
        })->get(); */

    /*     return User::whereHas([
            'followers',function($query){//esto es como un inner join
                $query->with('user:id,name,nick_name,profile_photo_path');
            },
        ])->where("user_id",1); */


        return User::select('*')
                ->join('followers', 'users.id', '=', 'followers.follower_id')
                ->where('nick_name','like','%'.$nick_name.'%')
                ->where('followers.user_id',auth()->user()->id)
                ->get();

              /*   return $this->follower->with([
                    "*",
                    "user"
                ])->where('nick_name','like','%'.$nick_name.'%')
                ->get(); */
    }

    public function test()
    {
        # code...
        $data = [
            "data" => 1
        ];

        print_r($data);
    }
}
