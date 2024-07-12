@extends("layouts.adminindex")

@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="row px-3 mt-3">
               <div class="col-md-8 mb-3">
                    <h6><a href="{{ route('plans.index') }}" class="nav-link">Continue Shopping</a></h6>
                    <hr/>

                    <div class="text-center">
                         <span>You have {{ Auth::user()->carts()->count() }} items in your cart</span>
                    </div>

                    @foreach($carts as $idx=>$cart)
                         <div id="package_{{ $cart->package['id'] }}" class="d-flex justify-content-between align-items-center package p-2 mt-3" data-packageid="{{ $cart->package['id'] }}">
                              <div class="">
                                   <span>{{ ++$idx }}.</span>
                                   <span>{{ $cart->package["name"] }}</span>
                                   <span>{{ $cart->package["duration"] }} days</span>
                              </div>

                              <div class="">
                                   <span class="quantity">{{ $cart->quantity }} qty</span>
                              </div>

                              <div class="">
                                   <span class="me-5">{{ $cart->price }}</span>
                                   <a href="javascript:void(0);" id="removefromcart" data-packageid="{{ $cart->package['id'] }}">
                                        <i class="fas fa-trash-alt text-danger"></i>
                                   </a>
                              </div>
                         </div>
                    @endforeach
               </div>

               <div class="col-md-4">
                    <h6>Payment details</h6>
                    <hr/>

                    <div class="d-flex justify-content-between">
                         <span>Total</span>
                         <span id="carttotal">{{ $totalcost }}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                         <span>Payment Method</span>
                         <span>Point Pay</span>
                    </div>

                    <div class="d-grid mt-3">
                         <button type="button" id="paybypoints" class="btn btn-primary btn-sm rounded-0" >Pay Now</button>
                    </div>
               </div>
          </div>
     </div>
     <!-- End Page Content Area -->

@endsection

@section("css")
     <link href="{{ asset('assets/dist/css/loader.css') }}" rel="stylesheet" />     
@endsection

@section("scripts")
     <script type="text/javascript">
          
          $(document).ready(function(){
               

               // Remove from cart 
               $(document).on("click","#removefromcart",function(){
                    
                    const packageid = $(this).data("packageid");
                    // console.log(packageid);

                    $.ajax({
                         url:"{{ route('carts.remove') }}",
                         type:"POST",
                         data:{
                              _token:"{{ csrf_token() }}",
                              packageid:packageid
                         },
                         success:function(response){
                              console.log(response.message);
                              
                              // UI remove
                              // console.log("#package_"+packageid);
                              // $("#package_"+packageid).remove();
                         
                              $('div[id="package_'+packageid+'"]').remove();

                              // Calculate total 
                              console.log(response.totalcost);
                              $("#carttotal").text(response.totalcost);
                         },
                         error:function(response){
                              console.log(response);
                         }
                    });
               });

               // Start Pay with Points
               $("#paybypoints").click(function(){
                    
                    let packageid; 

                    $(".package").each(function(){
                         packageid = $(this).data("packageid");
                         // console.log(packageid); // 2, 3


                         $.ajax({
                              url:"{{ route('carts.paybypoints') }}",
                              type:"POST",
                              data:{
                                   _token:$("meta[name='csrf-token']").attr("content"),
                                   packageid:packageid
                              },
                              success:function(response){
                                   window.alert(response.message);
                              },
                              error:function(response){
                                   window.alert(response.responseJSON.message);
                              }
                         });
                    });
                    

                    
               });
               // End Pay with Points
          });
     </script>
@endsection