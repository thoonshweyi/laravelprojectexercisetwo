@extends("layouts.adminindex")

@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          
          <div class="col-md-12">
               <a href="javascript:void(0);" id="createmodal-btn" class="btn btn-primary btn-sm rounded-0 me-3">Create</a>
               <a href="javascript:void(0);" id="setmodal-btn" class="btn btn-info btn-sm rounded-0">Set to user</a>

          </div>
          
          <hr/>

          <div class="col-md-12 mb-2">
               <div>
                    <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a>
               </div>
               <div>
                    <form action="" method="">
                         <div class="row justify-content-end">
                              <div class="col-md-2 col-sm-6 mb-2">
                                   <div class="input-group">
                                        <input type="text" name="filtername" id="filtername" class="form-control form-control-sm rounded-0" placeholder="Search...." value="{{ request('filtername') }}"/>
                                        <button type="button" id="btn-search" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                                   </div>
                              </div>
                         </div>
                    </form>
               </div>
          </div>

          <div class="col-md-12 loader-container">
               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>
                              <input type="checkbox" name="selectalls" id="selectalls" class="form-check-input selectalls" />
                         </th>
                         <th>No</th>
                         <th>Name</th>
                         <th>Price</th>
                         <th>Duration/Day</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
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
               <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                         <div class="modal-header">
                              <h6 class="modal-title">Modal Title</h6>
                              <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                         </div>

                         <div class="modal-body">
                              <form id="createform" action="" method="">
                                   <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                             <label for="name">Name <span class="text-danger">*</span></label>
                                             <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter Package Name" value="{{ old('name') }}"/>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                             <label for="price">Price <span class="text-danger">*</span></label>
                                             <input type="number" name="price" id="price" class="form-control form-control-sm rounded-0" placeholder="Enter Price" value="{{ old('price') }}"/>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                             <label for="duration">Duration <span class="text-danger">*</span></label>
                                             <input type="number" name="duration" id="duration" class="form-control form-control-sm rounded-0" placeholder="Enter Total Dsys" value="{{ old('duration') }}"/>
                                        </div>
                                        
                                        <input type="hidden" name="packageid" id="packageid"/>

                                        <div class="col-md-12 text-end">
                                             <button type="submit" id="create-btn" class="btn btn-primary btn-sm rounded-0" value="action-type">Submit</button>
                                        </div>
                                   </div>
                              </form>
                         </div>

                         <div class="modal-footer">

                         </div>
                    </div>
               </div>
          </div>
          <!-- end create modal -->

          <!-- start set modal -->
          <div id="setmodal" class="modal fade">
               <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                         <div class="modal-header">
                              <h6 class="modal-title">Modal Title</h6>
                              <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                         </div>

                         <div class="modal-body">
                              <form id="setform" action="" method="">
                                   <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                             <label for="setuser_id">User Id <span class="text-danger">*</span></label>
                                             <input type="text" name="setuser_id" id="setuser_id" class="form-control form-control-sm rounded-0" placeholder="Enter User Id" value="{{ old('setuser_id') }}"/>
                                        </div>

                                        <div class="col-md-12 form-group mb-3">
                                             <label for="package_id">Package ID <span class="text-danger">*</span></label>
                                             <input type="number" name="package_id" id="package_id" class="form-control form-control-sm rounded-0" placeholder="Enter Package Id" value="{{ old('package_id') }}"/>
                                        </div>


                                        <div class="col-md-12 text-end">
                                             <button type="submit" id="set-btn" class="btn btn-primary btn-sm rounded-0">Submit</button>
                                        </div>
                                   </div>
                              </form>
                         </div>

                         <div class="modal-footer">

                         </div>
                    </div>
               </div>
          </div>
          <!-- end set modal -->
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
                         url:"{{route('packages.index')}}",
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

               // Start Create & Update Package
               // start create
               $("#createmodal-btn").click(function(){
               
                    // clear form data
                    // $("#createform")[0].reset();
                    $("#createform").trigger("reset");
                    
                    $("#createmodal .modal-title").text("Create Package");
                    $("#create-btn").html("Add New Package");
                    $("#create-btn").val("action-type");

                    $("#createmodal").modal("show"); // toggle() can also used.
                    
               });

               // start edit
               $(document).on("click",".edit-btns",function(){
                    const getid = $(this).data("id");
                    // console.log(getid);

                    $.get(`packages/${getid}/`,function(response){
                         console.log(response); // {id: 9, name: 'myanmar', slug: 'myanmar', status_id: 3, user_id: 1, …}
                    
                         $("#createmodal .modal-title").text("Edit Package");
                         $("#create-btn").text("Update Package");
                         $("#create-btn").val("edit-type");
                         $("#createmodal").modal("show"); // toggle() can also used.
                         
                         $("#packageid").val(response.id);
                         $("#name").val(response.name);
                         $("#price").val(response.price);
                         $("#duration").val(response.duration);
                    });
               });
               

               $("#create-btn").click(function(e){
                    e.preventDefault();

                    let actiontype = $("#create-btn").val();
                    console.log(actiontype);
                    $(this).html("Sending....");

                    if(actiontype === "action-type"){
                         // Do Create
                         $.ajax({
                              url:"{{ route('packages.store') }}",
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
                                        title: "Added!",
                                        text: "Added Successfully!",
                                        icon: "success"
                                   });
                              },
                              error:function(response){
                                   console.log("Error: ",response);
                                   $("#create-btn").html("Save Change");
                              }
                         });
                    }else  if(actiontype === "edit-type"){
                         const getid = $("#packageid").val();
                         $.ajax({
                              url:`/packages/${getid}`,
                              type:"PUT",
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
                                        title: "Updated",
                                        text: "Update Successfully!",
                                        icon: "success"
                                   });
                              },
                              error:function(response){
                                   console.log("Error: ",response);
                                   $("#create-btn").html("Save Change");
                              }
                         });
                    }
               });
               // End Create & Update Package

               // Start Single Delete
               $(document).on("click",".delete-btns",function(){
                    
                    const getid = $(this).data("id");
                    const getidx = $(this).data("idx");
               
                    // console.log(getid);
                    
                    Swal.fire({
                         title: "Are you sure?",
                         text: `You won't be able to revert this id ${getidx}`,
                         icon: "warning",
                         showCancelButton: true,
                         confirmButtonColor: "#3085d6",
                         cancelButtonColor: "#d33",
                         confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                         if (result.isConfirmed) {
                              // data remove 
                              $.ajax({
                                   url:`/packages/${getid}`,
                                   type:"DELETE",
                                   dataType:"json",
                                   // data:{_token:"{{csrf_token()}}"},
                                   success:function(response){
                                        console.log(response);   // 1
                                        
                                        if(response){
                                             fetchalldatas();
                                             
                                             Swal.fire({
                                                  title: "Deleted!",
                                                  text: "Your file has been deleted.",
                                                  icon: "success"
                                             });
                                        }
                                   },
                                   error:function(response){
                                        console.log("Error: ",response)
                                   }
                              });
                              
                         }
                    });   
               });

               // End Single Delete

               //Start change-btn
               $(document).on("change",".change-btn",function(){

                    var getid = $(this).data("id");
                    // console.log(getid); // 1 2

                    var setstatus = $(this).prop("checked") === true ? 3 : 4;
                    // console.log(setstatus); // 3 4

                    $.ajax({
                         url:"socialapplicationsstatus",
                         type:"GET",
                         dataType:"json",
                         data:{"id":getid,"status_id":setstatus},
                         success:function(response){
                              console.log(response); // {success: 'Status Change Successfully'}
                              console.log(response.success); // Status Change Successfully
                         
                              Swal.fire({
                                   title: "Updated!",
                                   text: "Updated Successfully",
                                   icon: "success"
                              });
                         }
                    });
               });
               // End change btn

               // Start Set Package 
               $("#setmodal-btn").click(function(){
                    
                    // clear form data
                    // $("#createform")[0].reset();
                    $("#setform").trigger("reset");
                    
                    $("#setmodal .modal-title").text("Set Package");
                    $("#set-btn").html("Set Package");

                    $("#setmodal").modal("show"); // toggle() can also used.
                    
               })

               $("#set-btn").click(function(e){
                    e.preventDefault();


                    // Do Set
                    $.ajax({
                         url:"{{ route('packages.setpackage') }}",
                         type:"POST",
                         dataType: "json",
                         data:$("#setform").serialize(),
                         success:function(response){
                              console.log(response);
                              // console.log(this.data); // name=&price=&duration=&packageid=

                              // $("#setform")[0].reset();
                              $("#setform").trigger("reset");

                              $("#setmodal").modal("hide"); // toggle
                              
                              $("#set-btn").html("Save Change");

                              Swal.fire({
                                   title: "Access!",
                                   text: "Package Sets Successfully!",
                                   icon: "success"
                              });
                         },
                         error:function(response){
                              console.log("Error: ",response);
                         }
                    });
               });
               // End Set Package

               // Start Bulk Delete 
               $("#selectalls").click(function(){
                    $(".singlechecks").prop("checked",$(this).prop("checked"));
               });

               $("#bulkdelete-btn").on("click",function(){
                    let getselectedids = [];
                    
                    // console.log($("input:checkbox[name=singlechecks]:checked"));
                    $("input:checkbox[name='singlechecks']:checked").each(function(){
                         getselectedids.push($(this).val());
                    });                
                    
                    // console.log(getselectedids); // (4) ['1', '2', '3', '4']

                    Swal.fire({
                         title: "Are you sure?",
                         text: `You won't be able to revert!`,
                         icon: "warning",
                         showCancelButton: true,
                         confirmButtonColor: "#3085d6",
                         cancelButtonColor: "#d33",
                         confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                         if (result.isConfirmed) {
                              // data remove 
                              $.ajax({
                                   url:"{{ route('packages.bulkdeletes') }}",
                                   type:"DELETE",
                                   dataType:"json",
                                   data:{
                                        selectedids:getselectedids,
                                        _token:"{{ csrf_token() }}"
                                   },
                                   success:function(response){
                                        console.log(response);   // 1
                                        
                                        if(response){
                                             fetchalldatas();
                                        
                                             Swal.fire({
                                                  title: "Deleted!",
                                                  text: "Your file has been deleted.",
                                                  icon: "success"
                                             });
                                        }
                                   },
                                   error:function(response){
                                        console.log("Error: ",response)
                                   }
                              });
                              
                         }
                    });   
               });
               // End Bulk Delete 

               // Start Package Search 
               async function searchpackagedatas(query=""){
                    await $.ajax({
                         url:"{{url('/packagessearch')}}",
                         method:"GET",
                         data:{"query":query},

                         beforeSend:function(){
                              $(".loader").addClass("show");
                         },
                         success:function(response){
                              console.log(response); // {status: 'scuccess', data: Array(2)}
                              
                              $("#tabledata").empty();
                             
                              $("#tabledata").html(response);
                             
                         },
                         // error:function(response){
                         //      console.log(response);
                         // },
                         complete:function(){
                              console.log("complete:");
                              $(".loader").removeClass("show");
                         }
                    });
               }

               $("#btn-search").on("click",function(e){
                    e.preventDefault();
                    const query = $("#filtername").val();
                    // console.log(query);

                    searchpackagedatas(query);
               });
               // End Package Search 
                    
          });

     </script>
@endsection