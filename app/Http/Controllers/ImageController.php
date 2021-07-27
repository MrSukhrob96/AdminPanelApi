<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function upload(ImageUploadRequest $request)
	{
		$file = $request->file("image");
		$url = Storage::putFileAs("images", $file, Str::random(10) . '.' . $file->extension());
		
		return ["url" => env("APP_URL") . '/' . $url];
	}
}
