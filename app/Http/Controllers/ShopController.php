<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug=null,$subCategorySlug=null){
        $categorySelected = '';
        $subCategorySelected = '';
         $brandsArray = [];
       
        $categories = Category::orderBy('id','ASC')->where('status',1)->get();
        $brands = Brand::where('status',1)->orderBy('id','ASC')->get();
       
        $products = Product::orderBy('id','DESC');
       
      

        if(!empty($categorySlug)){
            $category = Category::where('slug',$categorySlug)->first();
            $products  = Product::where('category_id',$category->id);
            $categorySelected = $category->id;
        }
        if(!empty($subCategorySlug))
        {
            $subCategory = SubCategory::where('slug',$subCategorySlug)->first();
            $products = Product::where('sub_category_id',$subCategory->id);
            $subCategorySelected = $subCategory->id;
        }

        if(!empty($request->get('brand'))){
            $brandsArray = explode(',',$request->get('brand'));
            $products = $products->whereIn('brand_id',$brandsArray);
        }

        if($request->get('price_max')!='' && $request->get('price_min')!=''){
            if($request->get('price_max') == 1000){
                $products = $products->whereBetween('price',[intval($request->get('price_min')),1000000]);

            }
            else{
                $products = $products->whereBetween('price',[intval($request->get('price_min')),intval($request->get('price_max'))]);

            }
        }
        if(!empty($request->get('search')))
        {
            $products = $products->where('title','like','%'.$request->get('search').'%'); 
        }

        if($request->get('sort')!=''){
            if($request->get('sort') == 'latest'){
                $products = $products->orderBy('id','DESC');
            }else if($request->get('sort') == 'price_asc'){
                $products = $products->orderBy('price','ASC');

            }
            else{
                $products = $products->orderBy('id','DESC');
            }
        }
        else{
            $products = $products->orderBy('id','DESC');
        }
     
        $products = $products->where('status',1);
        $products = $products->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySlug'] = $categorySlug;
        $data['subCategorySlug'] = $subCategorySlug;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;
        $data['priceMax'] = intval(($request->get('price_max')) == 0)?1000:$request->get('price_max');
        $data['priceMin'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');
        return view('front.shop',$data);
    }

    public function product($slug){
        // echo $slug;
        $product = Product::where('slug',$slug)->with('Images')->first();
        if($product == null){
            abort(404);
        }
        $relatedProducts = [];
        if($product->related_product!=''){
            $productArr = explode(',',$product->related_product);
            $relatedProducts = Product::whereIn('id',$productArr)->with('Images')->get();
        }
        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        return view('front.product',$data);
    }

    
}
