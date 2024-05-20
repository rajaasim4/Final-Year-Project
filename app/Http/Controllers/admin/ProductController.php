<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::latest();
      
        if(!empty($request->get('keyword'))){
            $products = $products->where('title','like','%'.$request->get('keyword').'%');
        }
        $products = $products->paginate(10);

        return view('admin.products.index',compact('products'));
    }

    public function create(){
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('admin.products.create',$data);
    }

    public function store(Request $request){
         
         
            $products = new Product();
            $products->title = $request->title;
            $products->slug = $request->slug;
            $products->description = $request->description;
            $products->price = $request->price;
            $products->compare_price = $request->compare_price;
            $products->category_id = $request->category;
            $products->sub_category_id = $request->sub_category;
            $products->brand_id = $request->brand;
            $products->is_featured = $request->is_featured;
            $products->sku = $request->sku;
            $products->barcode = $request->barcode;
            $products->track_qty = $request->track_qty;
            $products->qty = $request->qty;
            $products->status = $request->status;
            $products->related_product = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';
            if($request->hasFile('cover')){
                $file = $request->file('cover');
                $imageName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('cover/'),$imageName);
                $products->cover = $imageName;
            }
            $products->save();

            if($request->hasFile('images')){
                $files = $request->file('images');
                foreach ($files as $file) {
                    $imageName = time().'_'.$file->getClientOriginalName();
                    $request['product_id'] = $products->id;
                    $request['image'] = $imageName;
                    $file->move(public_path('images/'),$imageName);
                    Image::create($request->all());
                }
            }

            $request->session()->flash('success','Product is created Successfully');
            return redirect()->route('products.index');
       
    }

    public function edit($id){
        $products = Product::find($id);
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $subCategories = SubCategory::where('category_id',$products->category_id)->get();
        $relatedProducts = [];
        if($products->related_product!=''){
            $productArr = explode(',',$products->related_product);
            $relatedProducts = Product::whereIn('id',$productArr)->get();
        }
        $data['products'] = $products;
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['subCategories'] = $subCategories;
        $data['relatedProducts'] = $relatedProducts;

        return view('admin.products.edit',$data);
    }

    public function update(Request $request,$id){
        $products = Product::find($id);
        if($request->hasFile('cover')){
            if(File::exists('cover/'.$products->cover)){
                File::delete('cover/'.$products->cover);
            }

            $file = $request->file('cover');
            $products->cover = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('cover/'),$products->cover);
        }
        $relatedProductString = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';

        $products->update([
            'title'=>$request->title,
            'slug'=>$request->slug,
            'description'=>$request->description,
            'price'=>$request->price,
            'compare_price'=>$request->compare_price,
            'category_id'=>$request->category,
            'sub_category_id'=>$request->sub_category,
            'brand_id'=>$request->brand,
            'is_featured'=>$request->is_featured,
            'sku'=>$request->sku,
            'barcode'=>$request->barcode,
            'track_qty'=>$request->track_qty,
            'qty'=>$request->qty,
            'status'=>$request->status,
            'cover'=>$products->cover,
            'related_product' => $relatedProductString,

        ]);

        if($request->hasFile('images')){
            $files = $request->file('images');
            foreach ($files as $file) {
                $imageName = time().'_'.$file->getClientOriginalName();
                $request['product_id'] = $id;
                $request['image'] = $imageName;
                $file->move(public_path('images/'),$imageName);
                Image::create($request->all());
            }
        }

        $request->session()->flash('success','The Products is updated Successfully');
        return redirect()->route('products.index');
    }
  




    public function delete(Request $request,$id){
        $products = Product::find($id);
        if(File::exists('cover/'.$products->cover)){
            File::delete('cover/'.$products->cover);
        }
        $images = Image::where('product_id',$products->id)->get();
        foreach ($images as $image) {
            if(File::exists('images/'.$image->image)){
                File::delete('images/'.$image->image);
            }
            $image->delete();
        }
        $products->delete();
        
        // To print the session messages
        $request->session()->flash('success','Product With All Of Its Specifications Are Deleted Successfully');
        return back();
    }

    public function deleteCover($id){
        $products = Product::find($id)->cover;
        if(File::exists('cover/'.$products)){
            File::delete('cover/'.$products);
        }
       
        return back();
    }
    public function deleteImages($id){
        $images = Image::find($id);
            if(File::exists('images/'.$images->image)){
                File::delete('images/'.$images->image);
            }
        
        Image::find($id)->delete();
        return back();
    }

    public function getProducts(Request $request){
        $tempProduct = [];
        if($request->term!=''){
            $products = Product::where('title','like','%'.$request->term.'%')->get();
            if($products!=null)
            {
                foreach ($products as $product) {
                    $tempProduct[] = ['id' => $product->id, 'text' => $product->title];

                }
            }

        }
    //  print_r($tempProduct); 
            return response()->json([
                'tags'=>$tempProduct,
                'status'=>true,
            ]);
    }
}
