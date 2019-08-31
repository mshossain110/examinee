<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\FileObserver;
use App\Jobs\ResizedImage;
use Storage;

class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'path',
        'file_name',
        'extension',
        'mime',
        'type',
        'public_path',
        'file_size',
        'parent_id',
        'driver',
        'driver_data',
        'meta',
        'permissions',
    ];

    protected $casts = [
        'id' => 'integer',
        'file_size' => 'integer',
        'user_id' => 'integer',
        'parent_id' => 'integer',
        'meta' => 'array',
        'permissions' => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'permissions',
    ];

    /**
     * Bootstrap any application services.
     */
    public static function boot()
    {
        parent::boot();
        File::observe(FileObserver::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(static::class, 'folder_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, 'folder_id');
    }

    public function updatePublicPaths($driver = null)
    {
        if ($this->driver !== $driver) {
            $this->driver = $driver;
        }

        if ($this->permissions['public']) {
            $this->public_path = Storage::disk($this->driver)->url($this->getStoragePath());
        } else {
            $this->public_path = Storage::disk('local')->url($this->getStoragePath());
        }
        $this->save();
    }

    /**
     * @param string $oldPath
     * @param string $newPath
     * @param null   $entryIds
     */
    public function updatePaths($oldPath, $newPath, $entryIds = null)
    {
        $oldPath = $this->encodePath($oldPath);
        $newPath = $this->encodePath($newPath);

        $query = $this->newQuery();

        if ($entryIds) {
            $query->whereIn('id', $entryIds);
        }

        $query->where('path', 'LIKE', "$oldPath%")
            ->update(['path' => DB::raw("REPLACE(path, '$oldPath', '$newPath')")]);
    }

    /**
     * Get all children of current entry.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findChildren()
    {
        if (!$this->exists) {
            return collect();
        }

        return $this->where('path', 'like', $this->attributes['path'].'%')->get();
    }

    /**
     * Generate full path for current entry, based on its parent.
     */
    public function generatePath()
    {
        if (!$this->exists) {
            return;
        }

        $this->path = $this->id;

        if ($this->parent) {
            $parent = $this->find($this->parent_id);
            $this->path = "{$parent->path}/$this->path";
        }

        $this->save();
    }

    private function encodePath($path)
    {
        $parts = explode('/', (string) $path);

        $parts = array_filter($parts);

        $parts = array_map(function ($part) {
            return $this->encodePathId($part);
        }, $parts);

        return implode('/', $parts);
    }

    private function encodePathId($id)
    {
        return base_convert($id, 10, 36);
    }

    private function decodePathId($id)
    {
        return base_convert($id, 36, 10);
    }

    public function getHashAttribute()
    {
        return trim(base64_encode(str_pad($this->getOriginal('id').'|', 10, 'padding')), '=');
    }

    public function scopeWhereHash(Builder $query, $value)
    {
        $id = $this->decodeHash($value);

        return $query->where('id', $id);
    }

    public function decodeHash($hash)
    {
        if ((int) $hash !== 0) {
            return $hash;
        }

        return (int) explode('|', base64_decode($hash))[0];
    }

    /**
     * Get url for previewing upload.
     *
     * @param string $value
     *
     * @return string
     */
    public function getUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }
        if (!isset($this->attributes['type']) || $this->attributes['type'] === 'folder') {
            return null;
        }

        if (array_get($this->attributes, 'public')) {
            return "storage/$this->public_path/$this->file_name";
        } else {
            return 'uploads/'.$this->attributes['id'];
        }
    }

    public function getStoragePath()
    {
        return "$this->file_name/$this->name";
    }

    /**
     * Get path of specified entry.
     *
     * @param int $id
     *
     * @return string
     */
    public function findPath($id)
    {
        $entry = $this->find($id, ['path']);

        return $entry ? $entry->getOriginal('path') : '';
    }

    /**
     * Return file entry name with extension.
     *
     * @return string
     */
    public function getNameWithExtension()
    {
        if (!$this->exists) {
            return '';
        }

        $extension = pathinfo($this->name, PATHINFO_EXTENSION);

        if (!$extension) {
            return $this->name.'.'.$this->extension;
        }

        return $this->name;
    }

    /**
     * set the image resize attribute;.
     *
     * @param array $sizes
     */
    public function setImageSizes(array $sizes)
    {
        $meta = $this->meta;
        $exiting = $meta['sizes'];
        $hasnew = false;
        foreach ($sizes as $size) {
            if (is_array($size) && is_array($exiting) && array_key_exists(implode('x', $size), $exiting)) {
                continue;
            }

            $exiting[implode('x', $size)] = false;
            $hasnew = true;
        }

        if ($hasnew) {
            $meta['sizes'] = $exiting;
            $this->meta = $meta;
            $this->save();
            ResizedImage::dispatch($this);
        }

        return $this;
    }
}
