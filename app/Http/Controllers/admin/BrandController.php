<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request){
        $brands = Brand::latest();
        if($request->get('keyword')){
            $brands = $brands->where('name','like','%'.$request->get('keyword').'%');
        } 
        $brands = $brands->paginate(10);
        return view('admin.brands.index',compact('brands'));
    }

    public function create(){
        return view('admin.brands.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required:unique',
        ]);

        if($validator->passes()){
            $brands = new Brand();
            $brands->name = $request->name;
            $brands->slug = $request->slug;
            $brands->status = $request->status;
            $brands->save();

            $request->session()->flash("success",'The FoodType is Added Successfully');
            return response()->json(['status'=>true,'message'=>"The FoodType is added successfully"]);
        }
        else{
            return response()->json(['status'=>false,'errors'=>$validator->errors()]);
        }
    }

    public function edit($id){
        $brands = Brand::find($id);
        return view('admin.brands.edit',compact('brands'));
    }

    public function update(Request $request,$id){
        $brands = Brand::find($id);
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required:unique',
        ]);

        if($validator->passes()){
             $brands->name = $request->name;
             $brands->slug = $request->slug;
             $brands->status = $request->status;
             $brands->save();
            $request->session()->flash('success','The FoodType is updated succeessfully');
            return response()->json(['status'=>true,'message'=>'The FoodType is updated successfully']);
        }
        else{
            return response()->json(['status'=>false,'errors'=>$validator->errors()]);
        }
       
    }

    public function destroy(Request $request,$id){
        $brands = Brand::find($id);
        $brands->delete();
        $request->session()->flash('success','FoodType  is deleted Successfully');
        return response()->json(['status'=>true,'message'=>'FoodType is deleted Successfully']);
    }
}
