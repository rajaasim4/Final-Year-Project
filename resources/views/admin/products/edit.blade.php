@extends('admin.layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('products.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form  action="{{route('products.update',$products->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" value="{{$products->title}}" id="title" class="form-control"
                                                placeholder="Title">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Slug</label>
                                            <input type="text" name="slug" value="{{$products->slug}}" id="slug" class="form-control"
                                                placeholder="Slug">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                                placeholder="Description">{{$products->description}}</textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Cover Image:</h2>
                                <div class="mb-3">
                                    <label for="" class="form-label">Cover Image</label>
                                    <input type="file" class="form-control" name="cover" id="cover" placeholder=""
                                        aria-describedby="fileHelpId" />
                                    <p class="error"></p>

                                </div>

                            </div>
                            
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Cover Image:</h2>
                                <div class="mb-3" style="display: flex; align-items:center;justify-content:center; flex-direction:row;">
                                    <div style="display: flex; align-items:center;justify-content:center; flex-direction:column; ">
                                        <img src="/cover/{{$products->cover}}" width="100px" style="margin:1rem;" class="img-responsive" alt="">
                                        
                                        {{-- <form action="{{ route('products.deletecover', ['id' => $products->id]) }}" method="post" >
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger" > Remove</button>
                                        </form> --}}
                                        {{-- <a href="/deletecover/{{$products->id}}" class="btn btn-danger">Remove</a> --}}
                                        
                                    </div>
                                    
                                </div>

                            </div>
                            <div class="card-body">
                                <h2 class="h4 mb-3">Mutliple Images:</h2>
                                <div class="mb-3 " style="display: flex; align-items:center;justify-content:center; flex-direction:row;" >
                                    @if (count($products->images)>0)
                                    @foreach ($products->images as $img)
                                    <div style="display: flex; align-items:center;justify-content:center; flex-direction:column;">
                                        <img src="/images/{{$img->image}}" style="margin:1rem 1rem;" width="100px" class="img-responsive" alt="">
                                        {{-- <form action="{{ route('products.deleteimages', ['id' => $img->id]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger">Remove</button>
    
                                        </form> --}}
                                        <a href="{{route('productImage.delete',$img->id)}}" class="btn btn-danger">Remove</a>

                                    </div>
                                   
                                    
                                    @endforeach
                                    @endif
                                   


                                </div>

                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Multiple Images for one product:</h2>
                                <div class="mb-3">
                                    <label for="" class="form-label">Images</label>
                                    <input type="file" class="form-control" name="images[]" multiple id=""
                                        placeholder="" aria-describedby="fileHelpId" />
                                    <p class="error"></p>

                                </div>

                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" value="{{$products->price}}" name="price" id="price" class="form-control"
                                                placeholder="Price">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" value="{{$products->compare_price}}" id="compare_price"
                                                class="form-control" placeholder="Compare Price">
                                            <p class="error"></p>
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at
                                                price. Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input  value="{{$products->sku}}" type="text" name="sku" id="sku" class="form-control"
                                                placeholder="sku">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" value="{{$products->barcode}}" name="barcode" id="barcode" class="form-control"
                                                placeholder="Barcode">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="track_qty"
                                                    name="track_qty" value="Yes" {{($products->track_qty == "Yes")?'checked':''}} checked>

                                                <label for="track_qty" class="custom-control-label">Track
                                                    Quantity</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty"
                                                class="form-control" value="{{$products->qty}}" placeholder="Qty">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option {{($products->status == 1)?'selected':''}} value="1">Active</option>
                                        <option {{($products->status == 0)?'selected':''}} value="0">Block</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select Category</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{($products->category_id == $category->id)?'selected':''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif


                                    </select>
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select SubCategory</option>
                                        @if ($subCategories->isNotEmpty())
                                            @foreach ($subCategories as $subCategory)
                                                <option {{($products->sub_category_id == $subCategory->id)?'selected':''}} value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select Brand</option>
                                        @if ($brands->isNotEmpty())
                                            @foreach ($brands as $brand)
                                                <option {{($products->brand_id == $brand->id)?'selected':''}} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option {{($products->is_featured == "No")?'selected':''}} value="No">No</option>
                                        <option {{($products->is_featured == "Yes")?'selected':''}} value="Yes">Yes</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Related products</h2>
                                <div class="mb-3">
                                    <select class="related_product w-100 form-control" name="related_products[]" id="related_products" multiple >
                                       @if (!empty($relatedProducts))
                                           @foreach ($relatedProducts as $relatedProduct)
                                            <option selected value="{{$relatedProduct->id}}">{{$relatedProduct->title}}</option>    
                                           @endforeach
                                       @else
                                           
                                       @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{route('products.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </section>

@endsection
@section('customJs')
    <script>
        $('.related_product').select2({
            ajax:{
                url:"{{route('products.getProducts')}}",
                dataType:'json',
                tags:true,
                multiple:true,
                minimumInputLength:3,
                processResults:function(data){
                    return{
                        results:data.tags,
                    }
                }
            }
        })
        $("#category").change(function() {
            var category_id = $(this).val();
            $.ajax({
                url: "{{ route('product-subcategories.index') }}",
                method: "get",
                data: {
                    category_id: category_id
                },
                dataType: 'json',
                success: function(response) {
                    $("#sub_category").find("option").not(":first").remove();
                    $.each(response['subCategories'], function(key, item) {
                        $("#sub_category").append(
                            `<option value='${item.id}'>${item.name}</option>`)
                    });

                },
                error: function(jqXHR, Exception) {
                    console.log('Something went wrong');
                }
            })
        });

       //  $("#productForm").submit(function(event) {
       //      event.preventDefault();
       //       var formData = $(this);

       //      $.ajax({
       //         //  url: "{{ route('products.store') }}",
       //         //  method: 'post',
       //          data: formData.serializeArray(),
       //          dataType: 'json',
       //          success: function(response) {
       //              if (response['status'] == true) {
       //                  window.location.href = "{{ route('products.index') }}";
       //              } else {
       //                  // var errors = response['errors'];
       //                  // $(".error").removeClass('invalid-feedback').html("");
       //                  // $("input[type='text'],select,input[type='number']").removeClass('is-invalid');
       //                  // $.each(errors,function(key,value){
       //                  //     $(`#${key}`).addClass('is-invalid').siblings('p').addClass("invalid-feedback").html(value);
       //                  // });
       //                  var errors = response['errors'];
       //                  $(".errors").removeClass('invalid-feedback').html("");
       //                  $("input[type='text'],select,input[type='number']").removeClass('is-invalid');
       //                  $.each(errors, function(key, value) {
       //                      $(`#${key}`).addClass('is-invalid').siblings('p').addClass(
       //                          'invalid-feedback').html(value);
       //                  });
       //              }
       //          },
       //          error: function(jqXHR, Exception) {
       //              console.log("Something Went Wrong");
       //          }
       //      })
       //  })
       

    </script>
@endsection
