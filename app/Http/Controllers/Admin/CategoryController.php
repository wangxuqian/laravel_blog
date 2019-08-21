<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
    //get
    public function index(){

        $data = (new Category)->tree();
        return view('admin.category.index')->with('data',$data);
    }

    //post
    public function store(){
        $input = Input::except('_token');
        $re = Category::create($input);
       if ($re){
           $data = (new Category)->tree();
           return view('admin.category.index')->with('data',$data);
       }
    }

    // admin/category/create
    public function create(){
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.add',compact('data'));
    }

    //admin/category/{category}
    public function show(){

    }

    //admin/category/{category}
    public function update($cate_id){
        $input = Input::except('_token','_method');
        $res = Category::where('cate_id',$cate_id)->update($input);
        if ($res){
            return redirect('admin/category');
        }
        else{
            return back()->with('errors','更新失败！');
        }
    }

    // admin/category/{category}
    public function destroy($cate_id){
        $re = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if ($re){
            $data =['code'=>1,'msg'=>'删除成功！'];
        }else{
            $data =['code'=>2,'msg'=>'删除失败！'];
        }
        return $data;
    }
    //admin/category/{category}/edit
    public function edit($cate_id){
        $data_type = Category::where('cate_pid',0)->get();
        $data_info = Category::where('cate_id',$cate_id)->first();
        $data['data_type'] = $data_type;
        $data['data_info'] = $data_info;
        return view('admin.category.edit')->with('data',$data);
    }

    public function changeorder(){
       $input = Input::all();
       $cate = Category::find($input['cate_id']);
       $cate -> cate_order = $input['cate_order'];
       $re = $cate ->update();
       if ($re){
           $data['code'] =  1 ;
           $data['msg']  =  '修改成功' ;
       }else{
           $data['code'] =  2 ;
           $data['msg']  =  '修改失败' ;
       }
       return $data;
    }
}
