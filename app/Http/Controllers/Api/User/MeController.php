<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    /**
     * Get self Profile
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function getMe()
    {
        if (auth()->check()){
            $user = auth()->user();
            return new UserResource($user);
        }
        return response()->json(null, 401);
    }
}
