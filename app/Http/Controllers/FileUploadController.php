<?php

namespace App\Http\Controllers;
use inertia\inertia;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function index(Request $request)
    {
        $documents = $request->user()->getMedia('documents')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->file_name,
                'size' => $media->size,
                'type' => $media->mime_type,
                'url' => $media->getUrl(),
            ];
        });
    
        return Inertia::render('settings/Documents', [
            'documents' => $documents
        ]);
    }


    public function store(Request $request)
    {
        $request->user()->addMediaFromRequest('file')->toMediaCollection('documents');

        // $path = $request->file('file')->store("documents/{$request->user()->id}");

        // dd($path);

    }
}
