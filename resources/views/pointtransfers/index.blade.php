@extends("layouts.adminindex")

@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          
          <div class="col-md-12">
               <a href="javascript:void(0);" id="createmodal-btn" class="btn btn-primary btn-sm rounded-0 me-3">Transfer</a>
          </div>
          
          <hr/>

          <div class="col-md-12 loader-container">
               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>
                              <input type="checkbox" name="selectalls" id="selectalls" class="form-check-input selectalls" />
                         </th>
                         <th>No</th>
                         <th>Student Id</th>
                         <th>Points</th>
                         <th>Account Type</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                    </thead>
          
                    <tbody id="tabledata">
                         
                    </tbody>
          
               </table>
               <div class="loader">
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
               </div>
          

          </div>
     </div>
     <!-- End Page Content Area -->

     <!-- START MODAL AREA -->
          <!-- start create modal -->
          <div id="createmodal" class="modal fade">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content rounded-0">
                         <div class="modal-header">
                              <h6 class="modal-title">Modal Title</h6>
                              <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                         </div>

                         <div class="modal-body">
                              <div id="step1">
                                   <form id="verifyform" action="" method="">
                                        <div class="row">
                                             <div class="col-md-12 form-group mb-3">
                                                  <label for="student_id">Student ID <span class="text-danger">*</span></label>
                                                  <input type="text" name="student_id" id="student_id" class="form-control form-control-sm rounded-0" placeholder="Enter Student Id" value="{{ old('name') }}"/>
                                             </div>

                                             <div class="col-md-12 text-end">
                                                  <button type="button" id="verify-btn" class="btn btn-primary btn-sm rounded-0" >Next</button>
                                             </div>
                                        </div>
                                   </form>
                              </div>
                              <div id="step2" style="display:none;">
                                   <form id="createform" action="" method="">
                                        <div class="row">
                                             <div class="col-md-12 form-group mb-3">
                                                 <ul class="list-group">
                                                 </ul>
                                             </div>

                                             <div class="col-md-12 form-group mb-3">
                                                  <label for="points">Points <span class="text-danger">*</span></label>
                                                  <input type="number" name="points" id="points" class="form-control form-control-sm rounded-0" placeholder="Enter Point" value="{{ old('points') }}"/>
                                             </div>
                                             
                                             <input type="hidden" name="receiver_id" id="receiver_id"/>

                                             <div class="col-md-12 text-end">
                                                  <button type="button" id="stepback-btn" class="btn btn-secondary btn-sm rounded-0 me-3">Back</button>
                                                  <button type="submit" id="create-btn" class="btn btn-primary btn-sm rounded-0" value="action-type">Submit</button>
                                             </div>
                                        </div>
                                   </form>
                              </div>
                         </div>

                         <div class="modal-footer">

                         </div>
                    </div>
               </div>
          </div>
          <!-- end create modal -->

          <!-- start otp modal -->
          <div id="otpmodal" class="modal fade">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">

                         <div class="modal-body">
                              <form id="otpverifyform" action="" method="">
                         
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

               // Start Fetch All Datas 
               function fetchalldatas(){
                    $.ajax({
                         url:"{{route('pointtransfers.index')}}",
                         meethod:"GET",
                         beforeSend:function(){
                              $(".loader").addClass("show");
                         },
                         success:function(response){
                         //    console.log(response);
                              $("#tabledata").html(response);
                         },
                         complete:function(){
                              console.log("complete:");
                              $(".loader").removeClass("show");
                         }
                    });
               }
               fetchalldatas();
               // End Fetch All Datas

               // Start Verify & Transfer Points
               // start create
               $("#createmodal-btn").click(function(){
               
                    $("#step1").show();
                    $("#step2").hide();

                    // clear form data
                    // $("#createform")[0].reset();
                    $("#createform").trigger("reset");
                    $("#verifyform").trigger("reset");
                    
                    $("#createmodal .modal-title").text("Verify Student");
                    $("#create-btn").html("Transfer");
                    $("#create-btn").val("action-type");

                    $("#createmodal").modal("show"); // toggle() can also used.
                    
               });

               // start vefiry student 
               $("#verify-btn").click(function(){
                    const studentid = $("#student_id").val();
                    $.ajax({
                         url:"{{ route('userpoints.verifystudent') }}",
                         type:"POST",
                         dataType: "json",
                         data: {
                              studentid:studentid
                         },
                         success:function(response){
                              console.log(response);

                              let htmlview="";

                              $("#step1").hide();
                              $("#step2").show();

                              $("#createmodal .modal-title").text("Transfer Points");
                              $("#receiver_id").val(response.user.id);
                         
                              htmlview = `<li class="list-group-item"><a href="{{ URL::to('students/${response.student.id}') }}" target="_blank">${response.student.firstname} ${response.student.lastname}</a></li>`
                              $("#createmodal .modal-body #createform ul.list-group").html(htmlview);
                         },
                         error:function(response){
                              console.log("Error: ",response);
                         }
                    });
               });

               $("#stepback-btn").click(function(){
                    $("#createmodal .modal-title").text("Verify Student");

                    $("#step1").show();
                    $("#step2").hide();

                    $("#verifyform").trigger("reset");
               });
               

               // $("#create-btn").click(function(e){
               //      e.preventDefault();

               //      let actiontype = $("#create-btn").val();
               //      console.log(actiontype);
               //      $(this).html("Sending....");

               //      if(actiontype === "action-type"){
               //           // Do Create
               //           $.ajax({
               //                url:"{{ route('pointtransfers.transfers') }}",
               //                type:"POST",
               //                dataType: "json",
               //                data:$("#createform").serialize(),
               //                success:function(response){
               //                     console.log(response);
               //                     // console.log(this.data); // name=&price=&duration=&packageid=

               //                     // $("#createform")[0].reset();
               //                     $("#createform").trigger("reset");

               //                     $("#createmodal").modal("hide"); // toggle
                                   
               //                     $("#create-btn").html("Save Change");

               //                     fetchalldatas();

               //                     Swal.fire({
               //                          title: "Transfer",
               //                          text: "Transfer Successfully!",
               //                          icon: "success"
               //                     });
               //                },
               //                error:function(response){
               //                     console.log("Error: ",response);
               //                     $("#create-btn").html("Save Change");
               //                }
               //           });
               //      }
               // });

               $("#create-btn").click(function(e){
                    e.preventDefault();
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

               $("#otpverifyform").on("submit",function(e){
                    e.preventDefault();
                    $.ajax({
                         url:"/verifyotps",
                         type:"POST",
                         data:$(this).serialize(),
                         success:function(response){
                              console.log(response);
                              if(response.message){
                                   // Do Create
                                   $.ajax({
                                        url:"{{ route('pointtransfers.transfers') }}",
                                        type:"POST",
                                        dataType: "json",
                                        data:$("#createform").serialize(),
                                        success:function(response){
                                             console.log(response);
                                             // console.log(this.data); // name=&price=&duration=&packageid=

                                             // $("#createform")[0].reset();
                                             $("#createform").trigger("reset");

                                             $("#createmodal").modal("hide"); // toggle
                                             
                                             $("#create-btn").html("Save Change");

                                             fetchalldatas();

                                             Swal.fire({
                                                  title: "Transfer",
                                                  text: "Transfer Successfully!",
                                                  icon: "success"
                                             });
                                        },
                                        error:function(response){
                                             console.log("Error: ",response);
                                             $("#create-btn").html("Save Change");
                                        }
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
                                   text: "Can't Perform Transfer Process",
                                   icon: "error"
                              });
                         }
                    });
               });

               // End Verify & Transfer Package

                    
          });

     </script>
@endsection