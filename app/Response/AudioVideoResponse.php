<?php

namespace App\Response;

use Storage;
use App\File;

class AudioVideoResponse
{
    /**
     * Stream specified video/audio file.
     *
     * @param File $upload
     *
     * @return mixed
     */
    public function create(File $upload)
    {
        $disk = Storage::disk($upload->driver);
        $size = $disk->size($upload->getStoragePath());
        $time = date('r', $disk->lastModified($upload->getStoragePath()));
        $fm = $disk->getDriver()->readStream($upload->getStoragePath());
        $begin = 0;
        $end = $size - 1;

        if (isset($_SERVER['HTTP_RANGE'])) {
            if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
                $begin = intval($matches[1]);
                if (!empty($matches[2])) {
                    $end = intval($matches[2]);
                }
            }
        }

        if (isset($_SERVER['HTTP_RANGE'])) {
            header('HTTP/1.1 206 Partial Content');
        } else {
            header('HTTP/1.1 200 OK');
        }

        header("Content-Type: $upload->mime");
        header('Cache-Control: public, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Accept-Ranges: bytes');
        header('Content-Length:'.(($end - $begin) + 1));
        if (isset($_SERVER['HTTP_RANGE'])) {
            header("Content-Range: bytes $begin-$end/$size");
        }
        header("Content-Disposition: inline; filename=$upload->file_name");
        header('Content-Transfer-Encoding: binary');
        header("Last-Modified: $time");

        $cur = $begin;
        fseek($fm, $begin, 0);

        while (!feof($fm) && $cur <= $end && (connection_status() == 0)) {
            echo fread($fm, min(1024 * 16, ($end - $cur) + 1));
            $cur += 1024 * 16;
        }
    }
}
