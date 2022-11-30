<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//ESTOS LOS AGREGE YO POR MI CUENTA

use App\Models\User;

class SearchController extends Controller
{
    //

    public function search($nick_name)
    {
        # code...
        return  User::select("*")
                    ->where('nick_name','like','%'.$nick_name.'%')
                    ->get();
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
