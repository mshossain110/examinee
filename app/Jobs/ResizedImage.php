<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File as FileAdapdar;
use App\File;

class ResizedImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * App\File object.
     *
     * @var App\File;
     */
    protected $file;

    /**
     * Create a new job instance.
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // we cant anything without image
        if ($this->file->type !== 'image') {
            return;
        }

        // get sizes of images
        $meta = $this->file->meta;
        $sizes = $meta['sizes'];
        // there are not any sizes;
        if (!is_array($sizes)) {
            return;
        }

        /*
         * is file in cloude then,
         * Download from cloud to local then resize it.
         */

        if ($this->file->driver == config('filesystems.cloud')) {
            if (!Storage::disk(config('filesystems.cloud'))->exists($this->file->getStoragePath())) {
                throw new Exception();
            }
            $s3file = Storage::disk(config('filesystems.cloud'))->get($this->file->getStoragePath());
            Storage::disk('local')->put("{$this->file->file_name}/{$this->file->name}", $s3file);
        }

        $path = storage_path("app/uploads/{$this->file->file_name}");
        $file = new FileAdapdar("{$path}/{$this->file->name}");
        $public = 'public';

        foreach ($sizes as $key => $value) {
            // already we resized this size
            if ($value == true) {
                continue;
            }

            // Image not resized let resize it
            $rs = explode('x', $key); // [150, 50]

            //  create Intervention images
            $image = Image::make($file)->resize($rs[0], $rs[1]);

            $localFile = "{$path}/{$key}-{$this->file->name}";
            $image->save($localFile);

            if ($this->file->driver == config('filesystems.cloud')) {
                Storage::disk(config('filesystems.cloud'))->putFileAs($this->file->file_name, new FileAdapdar($localFile), "{$key}-{$this->file->name}", $public);
            }

            $sizes[$key] = true;
        }

        // save meta values;
        $meta['sizes'] = $sizes;
        $this->file->meta = $meta;
        if ($this->file->isDirty()) {
            $this->file->save();
        }

        if ($this->file->driver == config('filesystems.cloud')) {
            Storage::deleteDirectory($path);
        }
    }
}
