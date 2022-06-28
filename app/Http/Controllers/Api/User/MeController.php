<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\Controller;

class MeController extends Controller
{
    public function getMe()
    {

        if (auth()->check()){
            return response()->json(['user' => auth()->user()]);
        }
        return response()->json(null, 401);
    }
}
