<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();
        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }
        $categories = $categories->paginate(10);

        return view('admin.category.index',compact('categories'));
    }
    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:categories',
        ]);

        if($validator->passes()){
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;

            $category->save();

            $request->session()->flash('success','Category is added Successfully');
            return response()->json(['status'=>true,'message'=>'Category is added Successfully']);
        }
        else{
            return response()->json(['status'=>false,'errors'=>$validator->errors()]);
        }
    }

    public function edit(Request $request, $id){
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request,$id){
        $category = Category::find($id);
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required',

        ]);
        if($validator->passes()){
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            $request->session()->flash('success','The Category is updated successfully');
            return response()->json(['status'=>true,'success'=>'The Category is updated Successfully']);
        }
        else{
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }
      
    }

    public function delete(Request $request,$id){
        $category = Category::find($id);
        $category->delete();
        $request->session()->flash('success','The Category is deleted successfully');
        return response()->json(['status'=>true,'message'=>'The Category is deleted successfully']);
    }
}
