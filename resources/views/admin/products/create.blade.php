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
             <form  action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                 @csrf
                 <div class="row">
                     <div class="col-md-8">
                         <div class="card mb-3">
                             <div class="card-body">
                                 <div class="row">
                                     <div class="col-md-12">
                                         <div class="mb-3">
                                             <label for="title">Title</label>
                                             <input type="text" name="title" id="title" class="form-control"
                                                 placeholder="Title">
                                             <p class="error"></p>
                                         </div>
                                     </div>
                                     <div class="col-md-12">
                                         <div class="mb-3">
                                             <label for="title">Slug</label>
                                             <input type="text" name="slug" id="slug" class="form-control"
                                                 placeholder="Slug">
                                             <p class="error"></p>
                                         </div>
                                     </div>

                                     <div class="col-md-12">
                                         <div class="mb-3">
                                             <label for="description">Description</label>
                                             <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                                 placeholder="Description"></textarea>
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
                                             <input type="text" name="price" id="price" class="form-control"
                                                 placeholder="Price">
                                             <p class="error"></p>
                                         </div>
                                     </div>
                                     <div class="col-md-12">
                                         <div class="mb-3">
                                             <label for="compare_price">Compare at Price</label>
                                             <input type="text" name="compare_price" id="compare_price"
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
                                             <input type="text" name="sku" id="sku" class="form-control"
                                                 placeholder="sku">
                                             <p class="error"></p>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="mb-3">
                                             <label for="barcode">Barcode</label>
                                             <input type="text" name="barcode" id="barcode" class="form-control"
                                                 placeholder="Barcode">
                                             <p class="error"></p>
                                         </div>
                                     </div>
                                     <div class="col-md-12">
                                         <div class="mb-3">
                                             <div class="custom-control custom-checkbox">
                                                 <input class="custom-control-input" type="checkbox" id="track_qty"
                                                     name="track_qty" value="Yes" checked>

                                                 <label for="track_qty" class="custom-control-label">Track
                                                     Quantity</label>
                                             </div>
                                         </div>
                                         <div class="mb-3">
                                             <input type="number" min="0" name="qty" id="qty"
                                                 class="form-control" placeholder="Qty">
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
                                         <option value="1">Active</option>
                                         <option value="0">Block</option>
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
                                                 <option value="{{ $category->id }}">{{ $category->name }}</option>
                                             @endforeach
                                         @endif


                                     </select>
                                     <p class="error"></p>
                                 </div>
                                 <div class="mb-3">
                                     <label for="category">Sub category</label>
                                     <select name="sub_category" id="sub_category" class="form-control">
                                         <option value="">Select SubCategory</option>

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
                                         <option value="">Select FoodType</option>
                                         @if ($brands->isNotEmpty())
                                             @foreach ($brands as $brand)
                                                 <option value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                                         <option value="No">No</option>
                                         <option value="Yes">Yes</option>
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
                     <button class="btn btn-primary">Create</button>
                     <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
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
        });
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
