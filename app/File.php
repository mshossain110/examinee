<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\FileObserver;
use App\Traits\HandlesPaths;
use App\Traits\HashesId;
use App\Jobs\ResizedImage;

class File extends Model
{
    use HandlesPaths, HashesId, SoftDeletes;

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
