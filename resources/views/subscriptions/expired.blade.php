@extends("layouts.adminindex")

@section("content")
     <div class="container-fluid">
          <div class="col-md-12">
               <h6>Subscription Expired</h6>
               <p>Your subscription has expired. Please contact to admin <a href="{{ route('plans.index') }}">Click Here</a> to renew license to continue.</p>
          </div>
     </div>               
    
@endsection

@section("css")
@endsection

@section("scripts")
    
@endsection