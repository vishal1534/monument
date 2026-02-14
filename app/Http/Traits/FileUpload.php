<?php

namespace App\Http\Traits;

trait FileUpload {

    public function upload($obj)
    {
        $fileObj = new \stdClass();
        // Get filename with the extension
        $fileObj->filenameWithExt = $obj->file->getClientOriginalName();
        // Get just filename
        $fileObj->filename = pathinfo($fileObj->filenameWithExt, PATHINFO_FILENAME);
        // Get just extension
        $fileObj->extension  = pathinfo($fileObj->filenameWithExt, PATHINFO_EXTENSION);
        // Filename to store
        $fileObj->filenameToStore = $obj->module.'_'.rand(1,500).'-'.time().'.'.$fileObj->extension;
        // File Size
        $fileObj->size = filesize($obj->file)/1000 . " KB";
        // Upload Image
        $fileObj->path = $obj->file->storeAs('public/'.$obj->path, $fileObj->filenameToStore);

        return $fileObj;
    }
}
