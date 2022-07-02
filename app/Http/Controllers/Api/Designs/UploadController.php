<?php

namespace App\Http\Controllers\Api\Designs;


use App\Http\Controllers\Controller;
use App\Jobs\UploadImage;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
           'image' => ['required', 'mimes:jpeg,gif,bmp,png', 'max:2048']
        ]);

        $image = $request->file('image');
        $image_path = $image->getPathName();

        $filename = time()."". preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
        $tmp = $image->storeAs('uploads/original', $filename, 'tmp');

        $design = auth()->user()->designs()->create([
            'image' => $filename,
            'disk' => config('site.upload_disk')
        ]);

        $this->dispatch(new UploadImage($design));

        return response()->json($design);
    }
}
