<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use App\Response\DownloadResponse;

class DownloadController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var File
     */
    private $file;
    /**
     * download response.
     *
     * @var DownloadResponse
     */
    private $downloadResponse;

    public function __construct(Request $request, File $file, DownloadResponse $downloadResponse)
    {
        $this->request = $request;
        $this->file = $file;

        $this->downloadResponse = $downloadResponse;
    }

    public function download(Request $request)
    {
        $ids = $request->get('ids');

        if (sizeof($ids) > 1) {
            return $this->downloadResponse->multipleDownload($ids);
        } else {
            return $this->downloadResponse->singleDownload($ids[0]);
        }
    }
}
