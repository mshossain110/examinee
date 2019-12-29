<?php
namespace App\Response;

use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;

class FileBuilder
{
    /**
     * File Object
     * @var App\File
     */
    protected $file = null;


    public function __construct($filedata)
    {
        $this->file = $file;
    }

    /**
     * @param UploadedFile $file
     * @param array        $extra
     *
     * @return array
     */
    public function getFileData(UploadedFile $file, $extra)
    {
        // TODO: move mime/extension/type guessing into separate class
        $originalMime = $file->getMimeType();

        if ($originalMime === 'application/octet-stream') {
            $originalMime = $file->getClientMimeType();
        }

        $file_name = Arr::get($extra, 'file_name') ? Arr::get($extra, 'file_name') : Str::random(36);
        $data = [
            'name' => Arr::get($extra, 'name', $file->getClientOriginalName()),
            'file_name' => $file_name,
            'mime' => $originalMime,
            'type' => $this->getTypeFromMime($originalMime),
            'extension' => $this->getExtension($file, $originalMime),
            'path' => Arr::get($extra, 'path'),
            'parent_id' => Arr::get($extra, 'parent_id'),
            'public_path' => Arr::get($extra, 'public_path'),
            'uploaded_by' => Arr::get($extra, 'uploaded_by', Auth::id()),
            'driver' => Arr::get($extra, 'driver', config('filesystems.default')),
            'driver_data' => Arr::get($extra, 'driver_data'),
            'meta' => Arr::get($extra, 'meta'),
        ];

        return $data;
    }
}
