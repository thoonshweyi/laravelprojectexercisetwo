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


      <!-- START MODAL AREA -->

          <!-- start otp modal -->
          <div id="otpmodal" class="modal fade">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">

                         <div class="modal-body">
                              <form id="verifyform" action="" method="">
                         
                                   <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                             <label for="otpcode">OTP Code <span class="text-danger">*</span></label>
                                             <input type="text" name="otpcode" id="otpcode" class="form-control form-control-sm rounded-0" placeholder="Enter your otp" />
                                        </div>
                                        
                                        <input type="hidden" name="otpuser_id" id="otpuser_id" value="{{ $userdata['id'] }}"/>

               
                                        <div class="col-md-12 text-end mb-3">
                                             <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                                        </div>
                                   </div>
                                   <p id="otpmessage"></p>
                                   <p id="">Expire in <span id="otptimer"></span> seconds</p>
                              </form>
                         </div>

                    </div>
               </div>
          </div>
          <!-- end otp modal -->
     <!-- END MODAL AREA -->

@endsection

@section("css")
     <link href="{{ asset('assets/dist/css/loader.css') }}" rel="stylesheet" />     
@endsection

@section("scripts")
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script type="text/javascript">
          
          $(document).ready(function(){
               // Start Passing Header Token
               $.ajaxSetup({
                    headers:{
                         "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                    }
               });
               // End Passing Header Token

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
               // $("#paybypoints").click(function(){
                    
               //      let packageid; 

               //      $(".package").each(function(){
               //           packageid = $(this).data("packageid");
               //           // console.log(packageid); // 2, 3


               //           $.ajax({
               //                url:"{{ route('carts.paybypoints') }}",
               //                type:"POST",
               //                data:{
               //                     _token:$("meta[name='csrf-token']").attr("content"),
               //                     packageid:packageid
               //                },
               //                success:function(response){
               //                     window.alert(response.message);
               //                },
               //                error:function(response){
               //                     window.alert(response.responseJSON.message);
               //                }
               //           });
               //      });
               // });
               // End Pay with Points

               // Start Pay with Points
               $("#paybypoints").click(function(){
                    // loading box
                    Swal.fire({
                         title: "Processing....",
                         // html: "I will close in <b></b> milliseconds.",
                         text: "Please wait while we send your OTP",
                         allowOutsideClick:false,
                         didOpen: () => {
                              Swal.showLoading();
                         }
                    });

                    $.ajax({
                         url:"/generateotps",
                         type:"POST",
                         success:function(response){
                              console.log(response);
                              Swal.close();

                              $("#otpmessage").text("Your OTP code is "+response.otp);
                              $("#otpmodal").modal("show");

                              startotptimer(60); // OTP will expires in 120s (2 minute);
                         },
                         error:function(response){
                              console.error("Error: ",response);
                         }
                    })
                    
                    // Clear form data
                    $("#verifyform").trigger("reset");
               });
               // End Pay with Points

               // Method 1
               // function startotptimer(duration){
               //      // let minutes,seconds;
               //      // let timer = duration;
               //      // console.log(timer,minutes,seconds); // 120 undefined undefined

               //      let timer = duration,minutes,seconds;
               //      // console.log(timer,minutes,seconds); // 60 undefined undefined

               
               //      let setinv = setInterval(dectimer,1000);

               //      function dectimer(){
               //           minutes = parseInt(timer/60);
               //           seconds = parseInt(timer%60);

               //           minutes = minutes < 10 ? "0"+minutes : minutes;
               //           seconds = seconds < 10 ? "0"+seconds : seconds;
                         
               //           $("#otptimer").text(`${minutes}:${seconds}`);

               //           if(timer-- < 0){
               //                clearInterval(setinv);
               //                $("#otpmodal").modal("hide");
               //           }
               //      }
               // }

               // Method 2
               function startotptimer(duration){
                    timeleft = duration; // 60 seconds

                    let setinv = setInterval(dectimer,1000);

                    function dectimer(){
                         $("#otptimer").text(timeleft);

                         timeleft--;
                         if(timeleft <= 0){
                              clearInterval(setinv);
                              $("#otpmodal").modal("hide");
                         }
                    }
               }

               $("#verifyform").on("submit",function(e){
                    e.preventDefault();
                    $.ajax({
                         url:"/verifyotps",
                         type:"POST",
                         data:$(this).serialize(),
                         success:function(response){
                              console.log(response);
                              if(response.message){
                                   
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

                                   $("#otpmodal").modal("hide");

                              }else{
                                   console.log("Invalid OTP");
                              }
                         },
                         error:function(response){
                              console.log("Error OTP: ",response);
                              Swal.fire({
                                   title: "Invalid OTP",
                                   text: "Can't Perform Pay By Point",
                                   icon: "error"
                              });
                         }
                    });
               });
               // End OTP
          });
     </script>
@endsection