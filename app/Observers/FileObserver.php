<?php

namespace App\Observers;

use App\File;
use Illuminate\Support\Facades\Auth;

class FileObserver
{
    /**
     * Handle the file "created" event.
     *
     * @param \App\File $file
     */
    public function created(File $file)
    {
        $id = Auth::id();
        $file->uplaoded_by = $id;
    }

    /**
     * Handle the file "updated" event.
     *
     * @param \App\File $file
     */
    public function updated(File $file)
    {
    }

    /**
     * Handle the File "deleted" event.
     *
     * @param \App\File $file
     */
    public function deleting(File $file)
    {
        $id = Auth::id();
        $file->deleted_by = $id;
    }

    /**
     * Handle the file "deleted" event.
     *
     * @param \App\File $file
     */
    public function deleted(File $file)
    {
    }

    /**
     * Handle the file "restored" event.
     *
     * @param \App\File $file
     */
    public function restored(File $file)
    {
    }

    /**
     * Handle the file "force deleted" event.
     *
     * @param \App\File $file
     */
    public function forceDeleted(File $file)
    {
    }
}
