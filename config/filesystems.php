<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'url' => env('APP_URL').'/uploads',
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],
        
        'uploads_ftp' => [
            'driver' => 'ftp',
            'root' => env('UPLOADS_FTP_ROOT', '/'),
            'host' => env('UPLOADS_FTP_HOST'),
            'username' => env('UPLOADS_FTP_USERNAME'),
            'password' => env('UPLOADS_FTP_PASSWORD'),
            'port' => env('UPLOADS_FTP_PORT', 21),
            'passive' => env('UPLOADS_FTP_PASSIVE'),
            'ssl' => env('UPLOADS_FTP_SSL'),
        ],

        'uploads_dropbox' => [
            'driver' => 'dropbox',
            'root' => env('UPLOADS_DROPBOX_ROOT', '/'),
            'access_token' => env('UPLOADS_DROPBOX_ACCESS_TOKEN')
        ],

        'uploads_digitalocean' => [
            'driver' => 'digitalocean',
            'key' => env('UPLOADS_DIGITALOCEAN_KEY'),
            'secret' => env('UPLOADS_DIGITALOCEAN_SECRET'),
            'region' => env('UPLOADS_DIGITALOCEAN_REGION'),
            'bucket' => env('UPLOADS_DIGITALOCEAN_BUCKET'),
        ],

        'uploads_rackspace' => [
            'driver'    => 'rackspace',
            'username'  => env('UPLOADS_RACKSPACE_USERNAME'),
            'key'       => env('UPLOADS_RACKSPACE_KEY'),
            'container' => env('UPLOADS_RACKSPACE_CONTAINER'),
            'endpoint'  => 'https://identity.api.rackspacecloud.com/v2.0/',
            'region'    => env('UPLOADS_RACKSPACE_REGION', 'IAD'),
            'url_type'  => 'publicURL',
        ],

        'legacy' => [
            'driver' => env('FILESYSTEM_DRIVER', 'local'),
            'root' => str_replace('application', '', base_path()),
        ]

    ],


    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
