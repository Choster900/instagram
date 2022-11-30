<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//ESTOS LOS AGREGE YO POR MI CUENTA
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Likes;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ImgRequest;
use Illuminate\Support\Facades\Auth;


/* Controllador para las publicaciones que se hagan */
class PostController extends Controller
{
    //
    private $post;
    private $comments;
    private $likes;

    public function __construct(Posts $post,Comments $comments,Likes $likes)
    {
        # code...
        $this->post = $post;
        $this->comments = $comments;
        $this->likes = $likes;
    }

    public function createPost(ImgRequest $request)
    {
        # code...
        try {
            //code...
            DB::beginTransaction();

            $res = $this->post->createPost($request);/* este createPost() esta en el modelo */
            DB::commit();

            return $res;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json($th->getMessage(), 500);
        }
    }

    public function getPost()
    {
        # code...
        return $this->post->getPost(Auth::id());/* este createPost() esta en el modelo */
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
