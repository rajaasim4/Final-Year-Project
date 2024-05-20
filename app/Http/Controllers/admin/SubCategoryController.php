<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subCategories = SubCategory::select('sub_categories.*','categories.name as categoryName')
        ->latest('sub_categories.id')
        ->leftJoin('categories','categories.id','sub_categories.category_id');
        if(!empty($request->get('keyword'))){
            $subCategories = $subCategories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
            $subCategories = $subCategories->orWhere('categories.name','like','%'.$request->get('keyword').'%');

        }
        $data['subCategories'] = $subCategories->paginate(10);
        return view('admin.sub_category.index',$data);
        // $subCategories = SubCategory::select('sub_categories.*','categories.name as categoryName')
        // ->latest('sub_categories.id')
        // ->leftJoin('categories','categories.id','sub_categories.category_id');
        // if(!empty($request->get('keyword'))){
        //     $subCategories = $subCategories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
        //     $subCategories = $subCategories->orWhere('categories.name','like','%'.$request->get('keyword').'%');

        // }
        // $data['subCategories'] = $subCategories->paginate(10);
        // return view('admin.sub_category.index',$data);
    }

    public function create(){
        $categories = Category::latest()->get();
        $data['categories'] = $categories;
        return view('admin.sub_category.create',$data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:sub_categories',
            'category_id'=>'required|exists:categories,id',
        ]);

        if($validator->passes()){
            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->category_id = $request->category_id;
            $subCategory->status = $request->status;
            $subCategory->save();

            $request->session()->flash('success','The SubCategory is added Successfully');
            return response()->json(['status'=>true,'message'=>'The SubCategory is added Successfully']);
        }
        else{
            return response()->json(['status'=>false,'errors'=>$validator->errors()]);
        }
    }

    public function edit(Request $request,$id){
        $subCategories = SubCategory::find($id);
        $categories = Category::latest()->get();
        $data['subCategories'] = $subCategories;
        $data['categories'] = $categories;
        return view('admin.sub_category.edit',$data);
    }

    public function update(Request $request,$id){
        $subCategories = SubCategory::find($id);
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required',
            'category_id'=>'required|exists:categories,id',
        ]);

        if($validator->passes()){
            $subCategories->name = $request->name;
            $subCategories->slug  = $request->slug;
            $subCategories->status = $request->status;
            $subCategories->category_id = $request->category_id;
            $subCategories->save();

            $request->session()->flash('success','The SubCategory is updated Successfully');
            return response()->json(['status'=>true,'message'=>'The SubCategory is updated Successfully']);

        }
        else{
            return response()->json(['status'=>false,'errors'=>$validator->errors()]);
        }
    }

    public function delete(Request $request,$id){
        $subCategories = SubCategory::find($id);
        $subCategories->delete();
        $request->session()->flash('success','The Sub Category is deleted Successfully');
        return response()->json(['status'=>true,'message'=>'Sub Category is deleted Successfully']);
    }
}
