<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Api\Controller;
use App\Http\Resources\UserResource;
use App\Rules\CheckSamePassword;
use App\Rules\MatchOldPassword;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource
     * @throws ValidationException
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'tagline' => ['required'],
            'name' => ['required'],
            'about' => ['required', 'string', 'min:20'],
            'formatted_address' => ['required'],
            'location.latitude' => ['required', 'numeric', 'min:-90', 'max:90'],
            'location.longitude' => ['required', 'numeric', 'min:-180', 'max:180'],
            'available_to_hire' => ['bool'],
        ]);

        $location = new Point($request->location['latitude'], $request->location['longitude']);

        $user->update([
            'name' => $request->name,
            'formatted_address' => $request->formatted_address,
            'location' => $location,
            'available_to_hire' => $request->available_to_hire,
            'about' => $request->about,
            'tagline' => $request->tagline,
        ]);

        return new UserResource($user);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
           'current_password' => ['required', new MatchOldPassword()],
           'password' => ['required', 'confirmed', new CheckSamePassword()]
        ]);

        $request->user()->update([
           'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'Password updates']);
    }
}
