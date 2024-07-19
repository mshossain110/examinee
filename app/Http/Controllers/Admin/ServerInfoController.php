<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ServerInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:super.admin');

        try {
            ob_start('ob_gzhandler');
        } catch (\Exception $e) {
            //
        }
    }

    public function index(Request $request)
    {
        ob_start();
        phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
        // $pinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);

        return Inertia::render('admin/ServerInfo', [
            'info'  => $pinfo,
        ]);
    }
}
