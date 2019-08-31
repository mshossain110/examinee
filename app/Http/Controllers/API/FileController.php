<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Repositories\FileRepository;
use App\Http\Resources\FileResource;
use App\Http\Requests\FileRequest;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use App\Jobs\UploadToCloud;
use App\File;
use Auth;
use DB;

class FileController extends ApiController
{
    protected $file;

    public function __construct(FileRepository $file)
    {
        // parent::__construct();

        $this->file = $file;
    }

    public function index(Request $request)
    {
        $parent_id = $request->get('parent_id');
        $per_page = 20;

        $folder = $this->file->getFolder($parent_id);

        $files = File::orderBy(DB::raw('type = "folder"'), 'desc')
                    ->where('parent_id', $folder ? $folder->id : 0)
                    ->where('created_by', Auth::id())
                    ->paginate($per_page);

        return $this->respondWithPaginator($files, new FileTransformer());
    }

    public function show($id)
    {
        if ((int) $id === 0) {
            $id = $this->file->decodeHash($id);
        }
        $entry = $this->entry->withTrashed()->findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $userId       = Auth::user()->id;
        $path = $request->get('path');
        $parent_id = $request->get('parent_id');
        $uploadedFile = $request->file('file');
        $request->input('file_name', $request->get('dzuuid'));
        $inputs = $request->all();
        $inputs['permissions'] = $this->getFilePermissions($request);

        $chunkupload = true;
        if ($chunkupload) {
            // create the file receiver
            $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

            // check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }

            // receive the file
            $save = $receiver->receive();

            // check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                // save the file and return any response you need, current example uses `move` function. If you are
                // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
                $fileEntry = $this->file->createFile($save->getFile(), $inputs);

                // $this->file->storePublicUpload($fileEntry, $save->getFile());
                $this->file->moveFile($fileEntry, $save->getFile());
                UploadToCloud::dispatch($fileEntry)->delay(now()->addMinutes(10)); // fire resize event and uplad to cloud
                return $this->respondWithItem($fileEntry, FileResource::class);
            }

            // we are in chunk mode, lets send the current progress
            /** @var AbstractHandler $handler */
            $handler = $save->handler();

            return response()->json([
                'done' => $handler->getPercentageDone(),
                'status' => true,
            ]);
        }

        // $fileEntry    = $this->file->createFile($uploadedFile, ['parent_id' => $parent_id, 'path' => $path] );

        // $this->file->storePrivateUpload($fileEntry, $uploadedFile);
        // return $this->respondWithItem($fileEntry, new FileTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(FileRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $request->only(['name', 'description']);
        $file = $this->file->update($id, $data);

        return $this->respondWithItem($file, new FileTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->file->destroy($id);

        return $this->respondWithMessage('file deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyAll(Request $request)
    {
        $ids = $request->get('ids');
        $this->file->deleteMultiple($ids);

        return $this->respondWithMessage('file deleted successfully.');
    }

    protected function getFilePermissions(Request $request)
    {
        return [
            'public' => true,
        ];
    }
}
