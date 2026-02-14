<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadFileController extends Controller
{
    public function index(Request $request){
        $filePath = public_path($request->file);
        $headers = ['Content-Type: application/pdf'];
        $fileName = $request->name;//.time().'.pdf';

        return response()->download($filePath, $fileName, $headers);
    }
}
