<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    function upload(){
    $file = Input::file('Filedata');
    if ($file ->isValid()){
        $realPath = $file -> getRealPath();
        $entension = $file -> getClientOriginalExtension();
        $newName = date('Ymd').mt_rand(100,999).'.'.$entension;

        $path = $file ->move(base_path().'/uploads/',$newName);
        $filePath = '/uploads/'.$newName;
        return $filePath;
    }

    }
}
