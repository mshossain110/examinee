<?php

namespace App;

use App\User;
use App\Traits\HashesId;
use App\Jobs\ResizedImage;
use App\Traits\FileStorage;
use App\Observers\FileObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HashesId, FileStorage, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'path',
        'file_name',
        'extension',
        'mime',
        'type',
        'public_path',
        'parent_id',
        'driver',
        'driver_data',
        'uploaded_by',
        'meta',
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
        'meta',
        'file_name'
    ];

    /**
     * the accessor that should append with response.
     *
     * @var array
     */
    protected $appends = [
        'sizes',
        'hash'
    ];

    /*
    |--------------------------------------------------------------------------
    | Booting
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        File::observe(FileObserver::class);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESORS Variables
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | ACCESORS & Mutation
    |--------------------------------------------------------------------------
    */
    public function getSizesAttribute()
    {
        if ($this->type == 'image') {
            return $this->getImageSizes();
        }

        return [];
    }


    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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

    public function uploader()
    {
        return $this->hasOne(User::class, 'id', 'uploaded_by');
    }

    


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function setPermission($permission, $value)
    {
        $meta = $this->meta;
        $permissions = $meta['permissions'];
        $permissions[$permission] = $value;
        $meta['permissions'] = $permissions;
        $this->meta = $meta;
        return $this;
    }

    public function getPermission($permission = null)
    {
        $permissions = $this->meta['permissions'];

        if ($permission !== null) {
            if (array_key_exists($permission, $permissions)) {
                return $permissions[$permission];
            } else {
                return false;
            }
        }
        return $permissions;
    }

    public function hasPermission($permission)
    {
        return $this->getPermission($permission) === true;
    }

    public function setImageSize($size)
    {
        $sizes = $this->meta['sizes'];
        $sizes[$size] = false;

        $this->meta['sizes'] = $sizes;
        return $this;
    }

    public function getImageSizes()
    {
        return $this->meta['sizes'];
    }

    public function updatePublicPaths($driver = null)
    {
        if ($this->driver !== $driver) {
            $this->driver = $driver;
        }

        if ($this->hasPermission('public')) {
            $this->public_path = Storage::disk($this->driver)->url($this->getStoragePath());
        } else {
            $this->public_path = Storage::disk('local')->url($this->getStoragePath());
        }
        $this->save();
    }

    public function getStoragePath($prefix = null)
    {
        return "$this->file_name/$this->name";
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
