@extends('front.layouts.app')
@section('content')
    <div class="col-md-12 text-center py-5">
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif
        <h1>Thankyou</h1>
        <p>Your Order Id is: {{$id}}</p>
    </div>
@endsection 