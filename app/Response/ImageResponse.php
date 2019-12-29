<?php

namespace App\Response;

use Storage;
use App\File;
use Symfony\Component\HttpFoundation\Response;

class ImageResponse
{
    /**
     * Create response for previewing specified image.
     * Optionally resize image to specified size.
     *
     * @param File $upload
     *
     * @return Response
     */
    public function create(File $upload)
    {
        $content = Storage::drive($upload->driver)->get($upload->getStoragePath());

        return response($content, 200, ['Content-Type' => $upload->mime]);
    }
}
