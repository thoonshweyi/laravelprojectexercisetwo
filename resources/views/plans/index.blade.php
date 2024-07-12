@extends("layouts.adminindex")

@section("content")
     <div class="container-fluid">
          <div class="col-md-12">
               <h6>Plan Management</h6>
               <p>Discover our popular services.</p>
          </div>

          <div class="loader-container">
               <div id="packagedata" class="row">
                    
               </div>
               <div class="loader">
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
               </div>
          </div>
     </div>               
    
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

          // Start Fetch All Datas 
          function fetchallpackages(){
               $.ajax({
                    url:"{{route('plans.index')}}",
                    meethod:"GET",
                    beforeSend:function(){
                         $(".loader").addClass("show");
                    },
                    success:function(response){
                    //    console.log(response);
                         $("#packagedata").html(response);
                    },
                    error:function(response){
                         console.log(response);
                    },
                    complete:function(){
                         $(".loader").removeClass("show");
                    }
               });
          }
          fetchallpackages();
          // End Fetch All Datas

          // Start Add Cart Package
          $(document).on("click",".add-to-cart",function(){
               const packageid = $(this).data("package-id");
               const packageprice =  $(this).data("package-price");
               // console.log(packageid,packageprice);

               $.ajax({
                    url:"{{ route('carts.add') }}",
                    type:"POST",
                    data:{
                         package_id:packageid,
                         quantity:1,
                         price:packageprice
                    },
                    success:function(response){
                         // window.alert(response.message);
                         Swal.fire({
                              title: "Add To Cart!",
                              text: `${response.message}`,
                              icon: "success"
                         });
                    }
               });
          });
          // End Add Cart Package
               
     });

     </script>
@endsection