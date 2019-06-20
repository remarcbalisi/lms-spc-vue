<?php

namespace App\Http\Controllers\API\Learner;

use App\Multimedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MultimediaController extends Controller
{
    public function store(Request $request) {
        $path = $request->file('file')->store('multimedia', 'public');
        $multimedia = new Multimedia;
        $multimedia->type = $request->file('file')->getClientMimeType();
        $multimedia->directory = $path;
        $multimedia->original_name = $request->file('file')->getClientOriginalName();
        $multimedia->save();

        return response()->json([
            'status' => 200,
            'data' => $multimedia,
        ]);
    }

    public function download() {
        return Storage::disk('public')->download('multimedia/rm43DNjLaWP8eNdx9ZHB6K5ZNwlz2nz9DXCCkCA5.pdf');
    }
}
