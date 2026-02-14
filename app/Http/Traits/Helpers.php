<?php


namespace App\Http\Traits;


trait Helpers
{
    public function arrayCount($arr){
        $arrCount = array_filter($arr, function ($item){
            return $item != null;
        });
        return $arrCount;
    }
}