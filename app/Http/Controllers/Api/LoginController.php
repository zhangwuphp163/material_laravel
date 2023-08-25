<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function post(Request $request){
        return [
            'code' => 200,
            'msg' => 'success',
            'data' =>
                ['userId'=> '1', 'token'=> 'debug',]
        ];
    }
}
