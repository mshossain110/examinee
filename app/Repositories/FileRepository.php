<?php

namespace App\Repositories;

use Auth;
use App\User;
use App\Folder;
use App\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

//use App\Scopes\StatusScope;

class FileRepository
{
    use BaseRepository;

    /**
     * User Model.
     *
     * @var File
     */
    protected $model;

    /**
     * Constructor.
     *
     * @param File $user
     */
    public function __construct(File $file)
    {
        $this->model = $file;
    }

    /**
     * Get the list of all the user without myself.
     *
     * @return mixed
     */
    public function getList()
    {
        return $this->model
            ->orderBy(DB::raw('type = "folder"'), 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Get the user by name.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getByName($name)
    {
        return $this->model
                    ->where('name', $name)
                    ->first();
    }

    /**
     * Get number of the records.
     *
     * @param int    $number
     * @param string $sort
     * @param string $sortColumn
     *
     * @return Paginate
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Get the article record without draft scope.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Store a new record.
     *
     * @param  $input
     *
     * @return User
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    /**
     * @param array $params
     *
     * @return File|null
     */
    public function getFolder($folderId = null)
    {
        // no folderId specified or it's "root" folder
        if (!$folderId) {
            return null;
        }

        // it's a folder hash, need to decode it
        if ((int) $folderId === 0) {
            $folderId = $this->model->decodeHash($folderId);
        } else {
            $folderId = (int) $folderId;
        }

        return $this->model->withTrashed()->findOrFail($folderId);
    }

    /**
     * Update the article record without draft scope.
     *
     * @param int   $id
     * @param array $input
     *
     * @return bool
     */
    public function update($id, $input)
    {
        $this->model = $this->model->findOrFail($id);

        return $this->save($this->model, $input);
    }

    /**
     * Delete the draft article.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * Delete multiple files.
     *
     * @param array $ids
     *
     * @return bool|null
     */
    public function deleteMultiple($ids)
    {
        if (is_array($ids)) {
            $this->model->whereIn('id', $ids)->delete();
        } else {
            $this->model->where('id', $ids)->delete();
        }

        return $ids;
    }

    /**
     * @param UploadedFile $file
     * @param $extra
     *
     * @return File
     */
    public function createFile(UploadedFile $file, $extra)
    {
        $data = $this->uploadedFileData($file, $extra);

        return $this->model->create($data);
    }

    /**
     * @param string   $path
     * @param int|null $parentId
     * @param int      $userId
     *
     * @return \Illuminate\Support\Collection
     */
    private function createPath($path, $parentId, $userId)
    {
        $path = collect(explode('/', $path));
        $path = $path->filter(function ($name) {
            return $name && !Str::contains($name, '.');
        });

        if ($path->isEmpty()) {
            return $path;
        }

        return $path->reduce(function ($parents, $name) use ($parentId, $userId) {
            if (!$parents) {
                $parents = collect();
            }
            $parent = $parents->last();
            $values = [
                'type' => 'folder',
                'name' => $name,
                'parent_id' => $parent ? $parent->id : $parentId,
            ];

            // check if user already has a folder with that name and parent
            $folder = $this->model->where($values)
                ->first();

            if (!$folder) {
                $folder = $this->model->create($values);
                $folder->generatePath();
            }

            return $parents->push($folder);
        });
    }

    /**
     * @param UploadedFile $file
     * @param array        $extra
     *
     * @return array
     */
    public function uploadedFileData(UploadedFile $file, $extra)
    {
        // TODO: move mime/extension/type guessing into separate class
        $originalMime = $file->getMimeType();

        if ($originalMime === 'application/octet-stream') {
            $originalMime = $file->getClientMimeType();
        }
        $file_name = Arr::get($extra, 'file_name') ? Arr::get($extra, 'file_name') : str_random(36);
        $data = [
            'name' => Arr::get($extra, 'name', $file->getClientOriginalName()),
            'file_name' => $file_name,
            'mime' => $originalMime,
            'type' => $this->getTypeFromMime($originalMime),
            'file_size' => $file->getClientSize(),
            'extension' => $this->getExtension($file, $originalMime),
            'path' => Arr::get($extra, 'path'),
            'parent_id' => Arr::get($extra, 'parent_id'),
            'public_path' => Arr::get($extra, 'public_path'),
            'uploaded_by' => Arr::get($extra, 'uploaded_by', Auth::id()),
            'isdraft' => Arr::get($extra, 'isdraft', 1),
            'driver' => Arr::get($extra, 'driver', config('filesystems.default')),
            'driver_data' => Arr::get($extra, 'driver_data'),
            'meta' => Arr::get($extra, 'meta'),
            'permissions' => Arr::get($extra, 'permissions'),
        ];

        return $data;
    }

    /**
     * Extract file extension from specified file data.
     *
     * @param UploadedFile $file
     * @param string       $mime
     *
     * @return string
     */
    private function getExtension(UploadedFile $file, $mime)
    {
        if ($extension = $file->getClientOriginalExtension()) {
            return $extension;
        }

        $pathinfo = pathinfo($file->getClientOriginalName());

        if (isset($pathinfo['extension'])) {
            return $pathinfo['extension'];
        }

        return explode('/', $mime)[1];
    }

    /**
     * Get type of file entry from specified mime.
     *
     * @param string $mime
     *
     * @return string
     */
    protected function getTypeFromMime($mime)
    {
        $default = explode('/', $mime)[0];

        switch ($mime) {
            case 'application/x-zip-compressed':
            case 'application/zip':
                return 'archive';
            case 'application/pdf':
                return 'pdf';
            case 'vnd.android.package-archive':
                return 'android package';
            case Str::contains($mime, 'xml'):
                return 'spreadsheet';
            default:
                return $default === 'application' ? 'file' : $default;
        }
    }

    /**
     * @param FileEntry    $entry
     * @param UploadedFile $contents
     */
    public function moveFile(file $entry, UploadedFile $file, $public = 'public', $disk = null, $file_name = null)
    {
        if (!$disk) {
            $disk = config('filesystems.default');
        }

        if (!$file_name) {
            $file_name = $entry->name;
        }

        Storage::disk($disk)->putFileAs($entry->file_name, $file, $file_name, $public);

        $entry->updatePublicPaths($disk);
    }

    /**
     * @param FileEntry    $entry
     * @param UploadedFile $contents
     */
    public function storePublicUpload(File $entry, UploadedFile $file, $file_name = null)
    {
        $this->moveFile($entry, $file, 'public', 'public', $file_name);
    }
}
