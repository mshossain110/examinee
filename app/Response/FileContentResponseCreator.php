<?php

namespace App\Response;

use Storage;
use Response;
use App\File;

class FileContentResponseCreator
{
    /**
     * ImageResponse service instance.
     *
     * @var ImageResponse
     */
    private $imageResponse;

    /**
     * AudioVideoResponse service instance.
     *
     * @var AudioVideoResponse
     */
    private $audioVideoResponse;

    /**
     * FileContentResponse constructor.
     *
     * @param ImageResponse      $imageResponse
     * @param AudioVideoResponse $audioVideoResponse
     */
    public function __construct(ImageResponse $imageResponse, AudioVideoResponse $audioVideoResponse)
    {
        $this->imageResponse = $imageResponse;
        $this->audioVideoResponse = $audioVideoResponse;
    }

    /**
     * Return download or preview response for given file.
     *
     * @param File $upload
     *
     * @return mixed
     */
    public function create(File $upload)
    {
        if (!Storage::drive($upload->driver)->exists($upload->getStoragePath())) {
            abort(404);
        }

        list($mime, $type) = $this->getTypeFromModel($upload);

        if ($type === 'image') {
            return $this->imageResponse->create($upload);
        } elseif ($this->shouldStream($mime, $type)) {
            return $this->audioVideoResponse->create($upload);
        } else {
            return $this->createBasicResponse($upload);
        }
    }

    /**
     * Create a basic response for specified upload content.
     *
     * @param File $upload
     *
     * @return Response
     */
    private function createBasicResponse(File $upload)
    {
        return response(Storage::drive($upload->driver)->get($upload->getStoragePath()), 200, ['Content-Type' => $upload->mime]);
    }

    /**
     * Extract file type from model.
     *
     * @param File $fileModel
     *
     * @return array
     */
    private function getTypeFromModel(File $fileModel)
    {
        $mime = $fileModel->mime;
        $type = explode('/', $mime)[0];

        return array($mime, $type);
    }

    /**
     * Should file with given mime be streamed.
     *
     * @param string $mime
     * @param string $type
     *
     * @return bool
     */
    private function shouldStream($mime, $type)
    {
        return $type === 'video' || $type === 'audio' || $mime === 'application/ogg';
    }
}
