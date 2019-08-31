<?php

namespace App\Http\Controllers;

use App\File;
use App\Response\FileContentResponseCreator;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __invoke(FileContentResponseCreator $fileResponse, $id)
    {
        $entry = File::where('file_name', $id)->first();

        return $fileResponse->create($entry);
    }
}
