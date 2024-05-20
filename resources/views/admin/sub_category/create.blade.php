@extends('admin.layouts.app')
@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('sub_categories.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" name="subCategoryForm" id="subCategoryForm" method="post">
            @csrf

            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Category</label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                    @endif

                                    

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>    
                                </select>	
                                <p></p>
                            </div>
                        </div>									
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary">Create</button>
                <a href="{{route('sub_categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
       
    </div>
    <!-- /.card -->
</section>

@endsection
@section('customJs')
    <script>
        $("#subCategoryForm").submit(function(event){
            event.preventDefault();
            var element = $(this);
            $.ajax({
                url:'{{route("sub_categories.store")}}',
                type:'post',
                data:element.serializeArray(),
                dataType:'json',
                success:function(response){
                    if(response['status'] ==  true){
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        $("#category").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html("");
                        
                        window.location.href = "{{route('sub_categories.index')}}";
                    }
                },
                error:function(jqXHR,exception){
                    var errors = response['errors'];
                    if(errors['name']){
                        $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                    }
                    else{
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                    if(errors['slug'])
                    {
                        $("#slug").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
                    }
                    else{
                        $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                    if(errors['category']){
                        $("#category").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors['category']);
                    }
                    else{
                        $("#category").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html("");
                    }
                }
            
            })

        }) 
        </script>    
@endsection