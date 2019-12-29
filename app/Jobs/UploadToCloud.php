<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File as FileAdapdar;
use App\File;

class UploadToCloud implements ShouldQueue
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
        $disk = config('filesystems.cloud');
        // is already uploaded
        if ($this->file->driver == $disk) {
            return;
        }

        $path = storage_path('app/uploads/');
        $public = 'public';

        $localfiles = Storage::disk('local')->allFiles($this->file->file_name);

        foreach ($localfiles as $lfile) {
            Storage::disk($disk)->putFileAs($this->file->file_name, new FileAdapdar("{$path}/{$lfile}"), $this->file->name, $public);
        }
        // save to path;
        $this->file->updatePublicPaths($disk);

        // wait 5 second to delete directorr so all local request is complete and new request to cloud
        sleep(5);
        Storage::disk('local')->deleteDirectory($this->file->file_name);
    }
}
