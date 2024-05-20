 @extends('front.layouts.app')
 @section('content')
 <section class="section-1">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('front-assets/SliderImages/food-delivery.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('front-assets/SliderImages/food-delivery.jpg')}}" />
                    <img src="{{asset('front-assets/SliderImages/food-delivery.jpg')}}" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Order Food You love.</h1>
                        <p class="mx-md-5 px-5">Embark on a flavorful adventure with our wide range of dishes, designed to delight every palate. </p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Order Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                
                <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('front-assets/SliderImages/food.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('front-assets/SliderImages/food.jpg')}}" />
                    <img src="{{asset('front-assets/SliderImages/food.jpg')}}" alt="" />
                </picture>
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Healthy Foods</h1>
                        <p class="mx-md-5 px-5">Indulge in a culinary journey with our mouth-watering dishes. From succulent starters to delectable desserts, every bite is a celebration of flavor. Order now and experience the magic of delicious food delivered to your door.</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Order  Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                 <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('front-assets/SliderImages/lasagnaWithTomatoAndGreenLeaf.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('front-assets/SliderImages/lasagnaWithTomatoAndGreenLeaf.jpg')}}" />
                    <img src="{{asset('front-assets/SliderImages/lasagnaWithTomatoAndGreenLeaf.jpg')}}" alt="" />
                </picture>
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Delicious Food</h1>
                        <p class="mx-md-5 px-5">Satisfy your cravings with our expertly crafted meals. Our menu features a diverse selection of gourmet dishes, made with the freshest ingredients. Enjoy restaurant-quality food in the comfort of your home. Order today and taste the difference.</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Order Now</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<section class="section-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="box shadow-lg">
                    <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>                    
            </div>
            <div class="col-lg-4 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                </div>                    
            </div>

            <div class="col-lg-4 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>                    
            </div>
        </div>
    </div>
</section>
{{-- <section class="section-3">
    <div class="container">
        <div class="section-title">
            <h2>Categories</h2>
        </div>           
        <div class="row pb-3">
            @if (getCategories()->isNotEmpty())
            @foreach (getCategories() as $category)
            <div class="col-lg-3">
                <div class="cat-card">
                    <div class="left">
                        {{-- <img src="{{asset('front-assets/images/cat-1.jpg')}}" alt="" class="img-fluid"> --}}
                    {{-- </div>
                    <div class="right">
                        <div class="cat-data">
                            <h2>{{$category->name}}</h2>
                            {{-- <p>100 Products</p> --}}
                        {{-- </div>
                    </div>
                </div>
            </div>
            @endforeach
           
            @endif
           
             
        </div>
    </div>
</section> --}} 

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Featured Products</h2>
        </div>    
        <div class="row pb-3">
            @if ($featuredProducts->isNotEmpty())
               @foreach ($featuredProducts as $product)
               <div class="col-md-3">
                <div class="card product-card">
                    <div class="product-image position-relative">
                        <a href="{{route('front.product',$product->slug)}}" class="product-img"><img class="card-img-top" src="/cover/{{$product->cover}}" alt=""></a>
                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                        <div class="product-action">
                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}})">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>                            
                        </div>
                    </div>                        
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="product.php">{{$product->title}}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>${{$product->price}}</strong></span>
                            @if ($product->compare_price > 0)
                            <span class="h6 text-underline"><del>${{$product->compare_price}}</del></span>
                            @endif
                         
                        </div>
                    </div>                        
                </div> 
            </div>  
               @endforeach 
            @endif
                                                         
                          
        </div>
    </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Latest Produsts</h2>
        </div>    
        <div class="row pb-3">
            @if ($latestProducts->isNotEmpty())
               @foreach ($latestProducts as $latestProduct)
               <div class="col-md-3">
                <div class="card product-card">
                    <div class="product-image position-relative">
                        <a href="{{route('front.product',$latestProduct->slug)}}" class="product-img"><img class="card-img-top" src="/cover/{{$latestProduct->cover}}" alt=""></a>
                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                        <div class="product-action">
                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}})">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </a>                            
                        </div>
                    </div>                        
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="product.php">{{ $latestProduct->title}}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>{{ $latestProduct->price}}</strong></span>
                            @if ( $latestProduct->compare_price)
                            <span class="h6 text-underline"><del>${{$latestProduct->compare_price}}</del></span>
                            @endif

                        </div>
                    </div>                        
                </div>                                               
            </div>  
               @endforeach 
            @endif
                     
        </div>
    </div>
</section>
 @endsection
