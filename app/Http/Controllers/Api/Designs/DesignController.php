<?php

namespace App\Http\Controllers\Api\Designs;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DesignController extends Controller
{
    /**
     * @param  Request  $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $design = Design::find($id);
        $this->authorize('update', $design);
        $this->validate($request, [
            'title' => ['required', 'unique:designs,title,'.$id],
            'description' => ['required', 'string', 'min:20', 'max:140'],
        ]);

        $design->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'is_live' => ! $design->upload_successfully ? false : $request->is_live,
        ]);

        return response()->json($design);
    }
}
