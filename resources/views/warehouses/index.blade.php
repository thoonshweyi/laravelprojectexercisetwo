@extends("layouts.adminindex")

@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          
          <div class="col-md-12">
               <a href="javascript:void(0);" id="modal-btn" class="btn btn-primary btn-sm rounded-0">Create</a>
          </div>
          
          <hr/>

          <div class="col-md-12 mb-2">
               <div>
                    <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a>
               </div>
          </div>

          <div class="col-md-12">
               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>
                              <input type="checkbox" name="selectalls" id="selectalls" class="form-check-input selectalls" />
                         </th>
                         <th>No</th>
                         <th>Name</th>
                         <th>Status</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                        
                    </tbody>
          
               </table>

               {{-- $warehouses->links() --}}
          

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
                              <form id="formaction" action="" method="">
                                   <div class="row align-items-end px-3">
                                        <div class="col-md-7 form-group">
                                             <label for="name">Name <span class="text-danger">*</span></label>
                                             <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter Application Name" value="{{ old('name') }}"/>
                                        </div>
                                        
                                        <div class="col-md-3 form-group">
                                             <label for="status_id">Status</label>
                                             <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                                                  @foreach($statuses as $status)
                                                       <option value="{{$status['id']}}">{{$status['name']}}</option>
                                                  @endforeach     
                                             </select>
                                        </div>
                                        
                                        <input type="hidden" name="id" id="id"/>
                                        <input type="hidden" name="user_id" id="user_id" value="{{ $userdata->id }}"/>
                                   
                                        <div class="col-md-2">
                                             <button type="submit" id="action-btn" class="btn btn-primary btn-sm rounded-0" value="action-type">Submit</button>
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
     <!-- END MODAL AREA -->
@endsection

@section("css")
@endsection

@section("scripts")
     <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
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
                         // url:"{{url('api/warehouses')}}",
                         // url:"{{'api/warehouses'}}",
                         url:"{{route('api.warehouses.index')}}",
                         

                         method:"GET",
                         dataType:"json",
                         success:function(response){
                              console.log(response); // {status: 'scuccess', data: Array(2)}
                              const datas = response.data;
                              // console.log(datas);
                              
                              let html;
                              datas.forEach(function(data,idx){
                                   // console.log(data);
                                   html += `
                                   <tr id="delete_${data.id}">
                                        <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                                        <td>${++idx}</td>
                                        <td>${data.name}</td>
                                        <td>
                                             <div class="form-checkbox form-switch">
                                                  <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? "checked" : "" }  data-id="${data.id}" />
                                             </div>
                                        </td>
                                        {{-- <td>${data.user["name"]}</td> --}}
                                        <td>${data.user.name}</td>
                                        <td>${data.created_at}</td>
                                        <td>${data.updated_at}</td>
                                        <td>
                                             <a href="javascript:void(0);" class="text-info edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                             <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${idx}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                   </tr>
                                   `;

                              });
                              $("#mytable tbody").prepend(html);

                         }
                    });
               }
               fetchalldatas();
               // End Fetch All Datas

               // Start Create Form
               $("#modal-btn").click(function(){
               
                    // clear form data
                    // console.log($("#formaction")); // E.fn.init {0: form#formaction, length: 1}
                    // console.log($("#formaction")[0]); // if you use reset(), that element can't be array.
                    // =method 1
                    // $("#formaction")[0].reset();

                    // =method 2
                    $("#formaction").trigger("reset");
                    
                    $("#createmodal .modal-title").text("Create Form");
                    $("#action-btn").val("create-btn");

                    $("#createmodal").modal("show"); // toggle() can also used.
                    
               });

               $("#formaction").validate({
                    rules:{
                         name:"required"
                    },
                    messages:{
                         name:"Please enter the warehouse name"
                    },

                    submitHandler:function(form){
                         let actiontype = $("#action-btn").val();
                         console.log(actiontype);

                         if(actiontype === "create-btn"){
                              let formdata = $(form).serialize();

                              $("#action-btn").text("Sending....");

                              $.ajax({
                                   url: "{{ url('api/warehouses')}}",
                                   type:"POST",
                                   data: formdata,
                                   dataType:"json",
                                   success:function(response){
                                        console.log(response);
                                        // console.log(response.status);
                                        
                                        if(response){
                                             $("#createmodal").modal("hide"); // toggle() can also used.
                                             
                                             const data = response.data;
                                             let html = `
                                             <tr id="delete_${data.id}">
                                                  <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                                                  <td>${data.id}</td>
                                                  <td>${data.name}</td>
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

                                             $("#action-btn").html("Sutmit");

                                             Swal.fire({
                                                  title: "Added!",
                                                  text: "Added Successfully",
                                                  icon: "success"
                                             });
                                        }
                                   },
                                   error:function(response){
                                        console.log("Error:",response);
                                   }
                              })
                         }else{
                              const getid = $("#id").val();
                              
                              $("#action-btn").text("Sending....");
                              $.ajax({
                                   url:`api/warehouses/${getid}`,
                                   type:"PUT",
                                   dataType:"json",
                                   data:$("#formaction").serialize(), // name=&status_id=4
                                   success:function(response){
                                        // console.log(this.data);  //name=kpay&status_id=3
                                        console.log(response);   // paymentmethods:525 {status: 'success', data: {…}}
                                        // console.log(response.status);
                                        const data = response.data;
                                        let html = `
                                             <tr id="delete_${data.id}">
                                                  <td><input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="${data.id}" /></td>
                                                  <td>${data.id}</td>
                                                  <td>${data.name}</td>
                                                  <td>
                                                       <div class="form-checkbox form-switch">
                                                            <input type="checkbox" class="form-check-input change-btn" ${data.status_id == 3 ? "checked" : "" }  data-id="${data.id}" />
                                                       </div>
                                                  </td>
                                                  <td>${data.user["name"]}</td>
                                                  <td>${data.created_at}</td>
                                                  <td>${data.updated_at}</td>
                                                  <td>
                                                       <a href="javascript:void(0);" class="text-info edit-btns" data-id="${data.id}" ><i class="fas fa-pen"></i></a>
                                                       <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="${data.id}" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                                  </td>
                                             </tr>
                                             `;
                                        $("#delete_"+data.id).replaceWith(html);
                                        
                                        $("#action-btn").html("Update");
                                        $("#createmodal").modal("hide");

                                        // window.location.reload(); // temp reload

                                        Swal.fire({
                                             title: "Updated!",
                                             text: "Updated Successfully",
                                             icon: "success"
                                        });
                                   }
                              });
                         }
                    }
               });
               // End Create Form

               // Start Edit Form
                    $(document).on("click",".edit-btns",function(){
                         const getid = $(this).data("id");
                         // console.log(getid);

                         $.get(`warehouses/${getid}/edit`,function(response){
                              // console.log(response); // {id: 9, name: 'myanmar', slug: 'myanmar', status_id: 3, user_id: 1, …}
                         
                              $("#createmodal .modal-title").text("Edit Form");
                              $("#action-btn").text("Update");
                              $("#action-btn").val("edit-btn");
                              $("#createmodal").modal("show"); // toggle() can also used.
                              
                              $("#id").val(response.id);
                              $("#name").val(response.name);
                              $("#status_id").val(response.status_id);
                         });
                    });
               // End Edit Form

               // Start Delete Item
               // $(".delete-btns").click(function(){
               //      // console.log('hay');
          
               //      var getidx = $(this).data("idx");
               //      // console.log(getidx);

               //      if(confirm(`Are you sure !!! you want to Delete ${getidx} ?`)){
               //           $('#formdelete-'+getidx).submit();
               //           return true;
               //      }else{
               //           false;
               //      }
               // });

               // by ajax 
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
                                   url:`api/warehouses/${getid}`,
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
                         url:"api/warehousesstatus",
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

               $("#bulkdelete-btn").click(function(){
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
                                   url:"{{ route('warehouses.bulkdeletes') }}",
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
                              
                         }
                    });   
               });
               // End Bulk Delete 
                    
          });

     </script>
@endsection