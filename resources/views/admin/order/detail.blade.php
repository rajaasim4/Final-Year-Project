@extends('admin.layouts.app')
@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order: #{{$order->id}}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('orders.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    @include('admin.message')
    <div class="container-fluid">
       
        <div class="row">
            <div class="col-md-9">
                <div class="card">

                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                            <h1 class="h5 mb-3">Shipping Address</h1>
                            <address>
                                <strong>{{$order->first_name.'_'.$order->last_name}}</strong><br>
                                {{$order->address}}<br>
                                Phone: {{$order->mobile}}<br>
                                Email: {{$order->email}}
                            </address>
                            </div>
                            
                            
                            
                            <div class="col-sm-4 invoice-col">
                                {{-- <b>Invoice #007612</b><br>
                                <br> --}}
                                <b>Order ID:</b> {{$order->id}}<br>
                                <b>Total:</b> ${{number_format($order->grand_total,2)}}<br>
                                <b>Status:</b> 
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-danger" >Pending</span>
                                    @else
                                        <span class="badge bg-success" >Delivered</span>
                                    @endif
                                {{-- <span class="text-success">Delivered</span> --}}
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-3">								
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="100">Qty</th>                                        
                                    <th width="100">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $orderItem)
                                <tr>
                                    <td>{{$orderItem->name}}</td>
                                    <td>${{$orderItem->price}}</td>                                        
                                    <td>{{$orderItem->qty}}</td>
                                    <td>${{$orderItem->price * $orderItem->qty}}</td>
                                </tr>
                                @endforeach
                               
                             
                                
                                <tr>
                                    <th colspan="3" class="text-right">Grand Total:</th>
                                    <td>${{number_format($order->grand_total,2)}}</td>
                                </tr>
                            </tbody>
                        </table>								
                    </div>                            
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    {{-- <form action="" name="changeOrderForm" id="changeOrderForm" >
                        @csrf
                        <div class="card-body">
                            <h2 class="h4 mb-3">Order Status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{($order->status == 'pending')?'selected':''}}>Pending</option>
                                    
                                    <option value="delievered" {{($order->status == 'delievered')?'selected':''}} >Delivered</option>
                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form> --}}
                    <form action="" name="changeOrderForm" id="changeOrderForm" >
                        @csrf
                        <div class="card-body">
                            <h2 class="h4 mb-3">Order Status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{ ($order->status == 'pending') ? 'selected' : '' }}>Pending</option>
                                    <option value="delievered" {{ ($order->status == 'delievered') ? 'selected' : '' }}>Delievered</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Send Inovice Email</h2>
                        <div class="mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="">Customer</option>                                                
                                <option value="">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('customJs')
    <script>
        // $("#changeOrderForm").submit(function(event){
        //     event.preventDefault();
        //     $.ajax({
        //         url:'{{route("orders.changeOrderStatus",$order->id)}}',
        //         type:'post',
        //         dataType:'json',
        //         data:$(this).serializeArray(),
        //         success:function(response){
        //             window.location.href = '{{route("order.detail",$order->id)}}'
        //         }
        //     });
        // });
        $("#changeOrderForm").submit(function(event) {
    event.preventDefault();
    $.ajax({
        url: '{{ route("orders.changeOrderStatus", $order->id) }}',
        type: 'post',
        dataType: 'json',
        data: $(this).serialize(),
        success: function(response) {
            if(response.status) {
                window.location.href = '{{ route("order.detail", $order->id) }}';
            } else {
                alert('Failed to update order status');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('An error occurred while updating order status');
        }
    });
});
    </script>
@endsection