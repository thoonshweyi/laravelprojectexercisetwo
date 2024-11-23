@extends("layouts.adminindex")

@section("caption","City List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">

          <div class="col-md-12">
               <form id="createform">
                    {{ csrf_field() }}
                    <div class="row align-items-end">
                         <div class="col-md-2 form-group mb-3">
                              <label for="country_id">Country</label>
                              <select name="country_id" id="country_id" class="form-control form-control-sm rounded-0 country_id">
                                   <option value="" selected disabled>Choose a country</option>
                                   @foreach($countries as $country)
                                        <option value="{{$country['id']}}">{{$country['name']}}</option>
                                   @endforeach     
                              </select>
                         </div>
                         <div class="col-md-2 form-group mb-3">
                              <label for="region_id">Region</label>
                              <select name="region_id" id="region_id" class="form-control form-control-sm rounded-0 region_id">
                                   <option value="" selected disabled>Choose a city</option>
                                   {{-- @foreach($cities as $city)
                                        <option value="{{$city['id']}}">{{$city['name']}}</option>
                                   @endforeach --}}     
                              </select>
                         </div>
                         <div class="col-md-2 form-group mb-3">
                              <label for="name">Name <span class="text-danger">*</span></label>
                              {{-- @error("name")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror --}}
                              <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter City Name" value="{{ old('name') }}"/>
                         </div>

                        

                         <div class="col-md-2 form-group mb-3">
                              <label for="status_id">Status</label>
                              <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                                   @foreach($statuses as $status)
                                        <option value="{{$status['id']}}">{{$status['name']}}</option>
                                   @endforeach     
                              </select>
                         </div>

                         <input type="hidden" name="user_id" id="user_id" value="{{ $userdata['id'] }}">

                         <div class="col-md-2 mb-3 text-sm-end text-md-start">
                              <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                              <button type="submit" id="create-btn" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                         </div>
                    </div>
               </form>
          </div>

          <hr/>

          <div class="col-md-12">
               <div>
                    {{-- <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a> --}}
                    <a href="javascript:void(0);" id="generateotp-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a>
                                   
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

               <div class="table-container">
                    <table id="mytable"  class="table table-sm table-hover border">
          
                         <thead>
                              <th>
                                   <input type="checkbox" name="selectalls" id="selectalls" class="form-check-input selectalls" />
                              </th>
                              <th>Id</th>
                              <th>Name</th>
                              <th>Country</th>
                              <th>Region</th>
                              <th>Status</th>
                              <th>By</th>
                              <th>Created At</th>
                              <th>Updated At</th>
                              <th>Action</th>
                         </thead>

                         <tbody>
                    
                         </tbody>

                    </table>
                    {{-- $cities->links("pagination::bootstrap-4") --}}

               </div>                    
               <p class="text-center scrollinfo">Scroll table to the end for more cities information.</p>
               

               <div class="loader">
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
               </div>
          

          </div>
     </div>
     <!-- End Page Content Area -->

     <!-- START MODAL AREA -->
          <!-- start edit modal -->
               <div id="editmodal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                              <div class="modal-header">
                                   <h6 class="modal-title">Edit Form</h6>
                                   <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <div class="modal-body">
                                   <form id="editform">
                            
                                        <div class="row align-items-end">
                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editcountry_id">Country</label>
                                                  <select name="editcountry_id" id="editcountry_id" class="form-control form-control-sm rounded-0 country_id">
                                                       @foreach($countries as $country)
                                                            <option value="{{$country['id']}}">{{$country['name']}}</option>
                                                       @endforeach     
                                                  </select>
                                             </div>
                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editregion_id">Region</label>
                                                  <select name="editregion_id" id="editregion_id" class="form-control form-control-sm rounded-0 region_id">
                                                       {{-- @foreach($cities as $city)
                                                            <option value="{{$city['id']}}">{{$city['name']}}</option>
                                                       @endforeach --}}     
                                                  </select>
                                             </div>
                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editname">Name <span class="text-danger">*</span></label>
                                                  <input type="text" name="editname" id="editname" class="form-control form-control-sm rounded-0" placeholder="Enter city Name" value="{{ old('name') }}"/>
                                             </div>
                                             

                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="status_id">Status</label>
                                                  <select name="editstatus_id" id="editstatus_id" class="form-control form-control-sm rounded-0">
                                                       @foreach($statuses as $status)
                                                            <option value="{{$status['id']}}">{{$status['name']}}</option>
                                                       @endforeach     
                                                  </select>
                                             </div>
                                             <input type="hidden" name="id" id="id"/>
                                             <input type="hidden" name="user_id" id="user_id" value="{{ $userdata['id'] }}"/>

                    
                                             <div class="col-md-12 text-end mb-3">
                                                  <button type="submit" id="edit-btn" class="btn btn-primary btn-sm rounded-0">Update</button>
                                             </div>
                                        </div>
                                   </form>
                              </div>

                              <div class="modal-footer">

                              </div>
                         </div>
                    </div>
               </div>
          <!-- end edit modal -->

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
     <style type="text/css">
          
          .table-container{
               height:300px;
               /* background:lightblue; */
               overflow-y:scroll;

               position:relative;
          }
          .scrollinfo{
               margin: 10px 0;
          }
          
     </style>
@endsection

@section("scripts")
     <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <script type="text/javascript">

          // Start Dynamic Select Option 
          $(document).on("change",".country_id",function(){
               const getcountryid = $(this).val();
               console.log(getcountryid);

               let opforregion = "";
               $.ajax({
                    url: `/api/filter/regions/${getcountryid}`,
                    type: "GET",
                    dataType:"json",
                    success:function(response){
                         $(".city_id").empty();
                         opforregion += "<option selected disabled>Choose a region abcd</option>";
                         
                         console.log(response);
                         for(let x=0 ; x<response.data.length; x++){
                              opforregion += `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                         }

                         $(".region_id").html(opforregion);
                    },
                    error:function(response){
                         console.log("Error:( ",response);
                    }
               });
          });
          // End Dynamic Select Option

          // Start Filter
          const getfilterbtn = document.getElementById("btn-search");
          getfilterbtn.addEventListener("click",function(e){
               // console.log("hay");

               const getfiltername = document.getElementById("filtername").value;
               const getcururl = window.location.href;
               
               // console.log(getfiltername); // search value
               // console.log(getcururl); // http://127.0.0.1:8000/cities?filtername=yan
               // console.log(getcururl.split("?")); // ['http://127.0.0.1:8000/cities', 'filtername=yan']
               // console.log(getcururl.split("?")[0]); // 
               window.location.href = getcururl.split("?")[0] + "?filtername="+getfiltername;

               e.preventDefault();
          });
          // End Filter

          $(document).ready(function(){
               // Start Passing Header Token
               $.ajaxSetup({
                    headers:{
                         "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                    }
               });
               // End Passing Header Token

               // Start Fetch All Datas by paginate
               const gettbody = document.querySelector("#mytable tbody");
               const getloader = document.querySelector(".loader");
               let page = 1;

               async function fetchalldatasbypaginate(){
                    const url = `api/cities?page=${page}`;

                    let results;

                    await fetch(url).then(response=>{
                         // console.log(response);
                         return response.json();
                    }).then(data=>{
                         // console.log(data); // object
                         results = data.data;
                         // console.log(results);
                    }).catch(err=>{
                         console.log(err);
                    });

                    return results;

          
               }
               // fetchalldatasbypaginate();

               async function alldatastodom(){
                    const getresults = await fetchalldatasbypaginate()
                    // console.log(getresults);

                    getresults.forEach((data)=>{
                         const newtr = document.createElement("tr");
                         newtr.id = `delete_${data.id}`;

                         newtr.innerHTML = `
                              <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                              <td>${data.id}</td>
                              <td>${data.name}</td>
                              <td>${data.country["name"]}</td>
                              <td>${data.region["name"]}</td>
                              <td>
                                   <div class="form-checkbox form-switch">
                                        <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? "checked" : "" }  data-id="${data.id}" />
                                   </div>
                              </td>
                              <td>${data.user.name}</td>
                              <td>${data.created_at}</td>
                              <td>${data.updated_at}</td>
                              <td>
                                   <a href="javascript:void(0);" class="text-info edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                   <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                              </td>
                         `
                         
                         // console.log(newtr);
                         gettbody.appendChild(newtr);
                    });
               }
               alldatastodom();

               // document.addEventListener("scroll",()=>{
               //      // console.log(document.documentElement.scrollTop);
               //      // console.log(document.documentElement.scrollHeight);
               //      // console.log(document.documentElement.clientHeight);

               //      const {scrollTop,scrollHeight,clientHeight} = document.documentElement;

               //      if(scrollTop + clientHeight >= scrollHeight - 5){
               //           showloader();
                         
               //      }
               // });

               // Show loader & fetch more datas 
               // function showloader(){
               //      getloader.classList.add("show");

               //      setTimeout(()=>{
               //           getloader.classList.remove("show");
               //           setTimeout(()=>{
               //                page++;
               //                alldatastodom();
               //           },300)
               //      },5000)
               // }
               // Show loader & fetch more datas 


               const gettablecontainer = document.querySelector(".table-container");
               gettablecontainer.addEventListener("scroll",()=>{

                    const {scrollTop,scrollHeight,clientHeight} = document.querySelector(".table-container");
                    // console.log(scrollTop);
                    // console.log(scrollHeight);
                    // console.log(clientHeight);

                    if(scrollTop + clientHeight >= scrollHeight){
                         showloader();
                    }
               });

               // Show loader & fetch more datas 
               async function showloader(){
                    getloader.classList.add("show");
                    
                    page++;
                    const nextresults = await alldatastodom();

                    getloader.classList.remove("show");
               }
               // Show loader & fetch more datas 


               // End Fetch All Datas by paginate
               
               // Start Create Form
           
               $("#createform").validate({
                    rules:{
                         name:"required"
                    },
                    messages:{
                         name:"Please enter the city name"
                    },

                    submitHandler:function(form){

                         $("#create-btn").text("Sending....");
                         let formdata = $(form).serialize();

                         $.ajax({
                              url: "{{ url('api/cities')}}",
                              type:"POST",
                              data: formdata,
                              dataType:"json",
                              success:function(response){
                                   console.log(response);

                                   // console.log(response.status);
                                   
                                   if(response){
                                        
                                        const data = response.data;
                                        let html = `
                                        <tr id="delete_${data.id}">
                                             <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                                             <td>${data.id}</td>
                                             <td>${data.name}</td>
                                             <td>${data.country["name"]}</td>
                                             <td>${data.region["name"]}</td>

                                             <td>
                                                  <div class="form-checkbox form-switch">
                                                       <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? "checked" : "" }  data-id="${data.id}" />
                                                  </div>
                                             </td>
                                             <td>${data.user.name}</td>
                                             <td>${data.created_at}</td>
                                             <td>${data.updated_at}</td>
                                             <td>
                                                  <a href="javascript:void(0);" class="text-info edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                                  <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                             </td>
                                        </tr>
                                        `;
                                        $("#mytable tbody").prepend(html);

                                         // clear form
                                        // $("#createform")[0].reset();
                                        $("#createform").trigger("reset");
                                        
                                        $("#create-btn").html("Sutmit");

                                        Swal.fire({
                                             title: "Added!",
                                             text: "Added Successfully",
                                             icon: "success"
                                        });
                                   }
                              },
                              error:function(response){
                                   console.log("Error:",response);
                                   $("#create-btn").html("Try Again");
                              }
                         })
                    }
               });
               // End Create Form

               // Start Edit Form
               $(document).on("click",".edit-btns",async function(){
                    
                    

                    const getid = $(this).data("id");
                    // console.log(getid);

                    await $.get(`cities/${getid}/edit`,async function(response){
                         // console.log(response); // {id: 9, name: 'myanmar', slug: 'myanmar', status_id: 3, user_id: 1, …}
                    
                         $("#editmodal").modal("show"); // toggle() can also used.
                         
                         $("#id").val(response.id);
                         $("#editname").val(response.name);
                         $("#editcountry_id").val(response.country_id);
                         $("#editstatus_id").val(response.status_id);

                         const getcountryid = $(editcountry_id).val();
                         // console.log(getcountryid);
                         let opforregion = "";

                         await $.ajax({
                              url: `/api/filter/regions/${getcountryid}`,
                              type: "GET",
                              dataType:"json",
                              success:function(response){
                                   console.log(response);
                                   $(".city_id").empty();
                                   opforregion += "<option selected disabled>Choose a city abcd</option>";
                                   
                                   console.log(response);
                                   for(let x=0 ; x<response.data.length; x++){
                                        opforregion += `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                                   }

                                   $(".region_id").html(opforregion);

                                   // console.log(e.target.parentElement);
                                   // $("#editregion").val($(e.target.parentElement).attr("data-city"));

                              },
                              error:function(response){
                                   console.log("Error:( ",response);
                              }
                         });
                         $("#editregion_id").val(response.region_id);

                    });
               });
               // End Edit Form

               // Start Edit Modal
               $("#editform").validate({
                    rules:{
                         editname:"required"
                    },
                    messages:{
                         editname:"Please enter the city name"
                    },

                    submitHandler:function(form){

                         const getid = $("#id").val();

                         $("#edit-btn").text("Sending....");
                         let formdata = $(form).serialize();

                         $.ajax({
                              url: `api/cities/${getid}`,
                              type:"PUT",
                              data: formdata,
                              dataType:"json",
                              success:function(response){
                                   console.log(response);

                                   // console.log(response.status);
                                   
                                   if(response){
                                        
                                        const data = response.data;
                                        let html = `
                                        <tr id="delete_${data.id}">
                                             <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                                             <td>${data.id}</td>
                                             <td>${data.name}</td>
                                             <td>${data.country["name"]}</td>
                                             <td>${data.region["name"]}</td>
                                             <td>
                                                  <div class="form-checkbox form-switch">
                                                       <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? "checked" : "" }  data-id="${data.id}" />
                                                  </div>
                                             </td>
                                             <td>${data.user.name}</td>
                                             <td>${data.created_at}</td>
                                             <td>${data.updated_at}</td>
                                             <td>
                                                  <a href="javascript:void(0);" class="text-info edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                                  <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                             </td>
                                        </tr>
                                        `;
                                        $("#delete_"+data.id).replaceWith(html);

                                        $("#edit-btn").text("Update");
                                        $("#editmodal").modal("hide"); // toggle()

                                        Swal.fire({
                                             title: "Updated!",
                                             text: "Updated Successfully",
                                             icon: "success"
                                        });

                                   }
                              },
                              error:function(response){
                                   console.log("Error:",response);
                                   $("#edit-btn").html("Try Again");
                              }
                         })
                    }
               });
               // End Edit Modal


               // Start Delete Item
               // Using api route
               $(document).on("click",".delete-btns",function(){
                    const getidx = $(this).attr("data-idx");
                    const getid = $(this).data("id");
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
                                   url:`api/cities/${getid}`,
                                   type:"DELETE",
                                   dataType:"json",
                                   // data:{_token:"{{csrf_token()}}"},
                                   success:function(response){
                                        console.log(response);   // 1
                                        
                                        if(response){
                                             // ui remove
                                             $(`#delete_${getid}`).remove();
                                        
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
               // End Delete Item

               //Start change-btn
               $(document).on("change",".change-btn",function(){

                    var getid = $(this).data("id");
                    // console.log(getid); // 1 2

                    var setstatus = $(this).prop("checked") === true ? 3 : 4;
                    // console.log(setstatus); // 3 4

                    $.ajax({
                         url:"api/citiesstatus",
                         type:"PUT",
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

                // Start Bulk Delete 
               $("#selectalls").click(function(){
                    $(".singlechecks").prop("checked",$(this).prop("checked"));
               });

               // $("#bulkdelete-btn").click(function(){
               //      let getselectedids = [];
                    
               //      // console.log($("input:checkbox[name=singlechecks]:checked"));
               //      $("input:checkbox[name='singlechecks']:checked").each(function(){
               //           getselectedids.push($(this).val());
               //      });                
                    
               //      // console.log(getselectedids); // (4) ['1', '2', '3', '4']

               //      Swal.fire({
               //           title: "Are you sure?",
               //           text: `You won't be able to revert!`,
               //           icon: "warning",
               //           showCancelButton: true,
               //           confirmButtonColor: "#3085d6",
               //           cancelButtonColor: "#d33",
               //           confirmButtonText: "Yes, delete it!"
               //      }).then((result) => {
               //           if (result.isConfirmed) {
               //                // data remove 
               //                $.ajax({
               //                     url:"{{ route('cities.bulkdeletes') }}",
               //                     type:"DELETE",
               //                     dataType:"json",
               //                     data:{
               //                          selectedids:getselectedids,
               //                          _token:"{{ csrf_token() }}"
               //                     },
               //                     success:function(response){
               //                          console.log(response);   // 1
                                        
               //                          if(response){
               //                               // ui remove
               //                               $.each(getselectedids,function(key,val){
               //                                    $(`#delete_${val}`).remove();
               //                               });
                                        
               //                               Swal.fire({
               //                                    title: "Deleted!",
               //                                    text: "Your file has been deleted.",
               //                                    icon: "success"
               //                               });
               //                          }
               //                     },
               //                     error:function(response){
               //                          console.log("Error: ",response)
               //                     }
               //                });
                              
               //           }
               //      });   
               // });
               // End Bulk Delete 

               // Start OTP
               $("#generateotp-btn").on("click",function(){
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

               $("#verifyform").on("submit",function(e){
                    e.preventDefault();
                    $.ajax({
                         url:"/verifyotps",
                         type:"POST",
                         data:$(this).serialize(),
                         success:function(response){
                              console.log(response);
                              if(response.message){
                                   // console.log("Bulk Delete Sucessfully");
                                   
                                   // start bulk delete
                                   let getselectedids = [];
                    
                                   // console.log($("input:checkbox[name=singlechecks]:checked"));
                                   $("input:checkbox[name='singlechecks']:checked").each(function(){
                                        getselectedids.push($(this).val());
                                   });    

                                   $.ajax({
                                        url:"{{ route('cities.bulkdeletes') }}",
                                        type:"DELETE",
                                        dataType:"json",
                                        data:{
                                             selectedids:getselectedids,
                                             _token:"{{ csrf_token() }}"
                                        },
                                        success:function(response){
                                             console.log(response);   // 1
                                             
                                             if(response){
                                                  // ui remove
                                                  $.each(getselectedids,function(key,val){
                                                       $(`#delete_${val}`).remove();
                                                  });
                                             
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
                                   // end bulk delete

                                   $("#otpmodal").modal("hide");

                              }else{
                                   console.log("Invalid OTP");
                              }
                         },
                         error:function(response){
                              console.log("Error OTP: ",response);
                              Swal.fire({
                                   title: "Invalid OTP",
                                   text: "Can't Perform Bulk Delete",
                                   icon: "error"
                              });
                         }
                    });
               });
               // End OTP
          });


          // console.log(parseInt("123 hello")); // 123
          // console.log(parseInt("0123",10)); // 123 // parseInt("123", explicityly specify base-10)
          // console.log(parseInt("    0123    ",10)); // 123 // remove white spaces and leading zeros
          // console.log(parseInt("123.9",10)); // 123 // Do not taken into account for decimal points
         

     </script>
@endsection
