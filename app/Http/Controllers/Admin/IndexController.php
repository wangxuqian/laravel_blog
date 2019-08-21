<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;

class IndexController extends CommonController{

    public function index(){
        return view('admin.index');
    }

    public function info(){
        return view('admin.info');
    }

    public function login(){
        if ($input = Input::get()){
            dd($input);
        }
    }

    public function gettest(){
        dd($_SERVER);
    }
}