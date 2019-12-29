<?php

namespace App\Traits;


use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\File;


trait FileStorage
{
    

    /**
     * @param File    $entry
     * @param UploadedFile $contents
     */
    public function storeUpload(UploadedFile $file, $public = 'public', $disk = null, $file_name = null)
    {
        if (!$disk) {
            $disk = config('filesystems.default');
        }

        if (!$file_name) {
            $file_name = $this->hash;
        }

        Storage::disk($disk)->putFileAs($this->file_name, $file, $file_name, $public);

        $entry->updatePublicPaths($disk);
    }

    /**
     * @param File    $entry
     * @param UploadedFile $contents
     */
    public function storePublicUpload(UploadedFile $file, $file_name = null)
    {
        $this->moveFile($file, 'public', 'public', $file_name);
    }

    /**
     * @param File    $entry
     * @param UploadedFile $contents
     */
    public function storeLocalUpload(UploadedFile $file, $file_name = null)
    {
        $this->moveFile($file, 'public', 'local', $file_name);
    }
}
