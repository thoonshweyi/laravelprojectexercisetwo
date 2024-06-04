@extends("layouts.adminindex")

@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          
          <div class="col-md-12">
               <form id="createform" action="" method="">

                    <div class="row align-items-end">
                         <div class="col-md-4">
                              <label for="name">Name <span class="text-danger">*</span></label>
                              @error("name")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror
                              <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter Type Name" value="{{ old('name') }}"/>
                         </div>

                         <div class="col-md-4">
                              <label for="status_id">Status</label>
                              @error("status_id")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror
                              <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                                   @foreach($statuses as $status)
                                        <option value="{{$status['id']}}">{{$status['name']}}</option>
                                   @endforeach     
                              </select>
                         </div>

                         <div class="col-md-4">
                              <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                              <button type="submit" id="create-btn" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                         </div>
                    </div>
               </form>
          </div>
          
          <hr/>

          <div class="col-md-12">
               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>No</th>
                         <th>Name</th>
                         <th>Status</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                         @foreach($paymentmethods as $idx=>$paymentmethod)
                         <tr id="delete_{{$paymentmethod->id}}">
                              <td>{{++$idx}}</td>
                              <td>{{$paymentmethod["name"]}}</td>
                              <td>
                                   <div class="form-checkbox form-switch">
                                        <input type="checkbox" class="form-check-input change-btn" {{  $paymentmethod->status_id === 3 ? 'checked' : '' }} data-id="{{ $paymentmethod->id }}" />
                                   </div>
                              </td>
                              <td>{{ $paymentmethod["user"]["name"] }}</td>
                              <td>{{ $paymentmethod->created_at->format('d M Y') }}</td>
                              <td>{{ $paymentmethod->updated_at->format('d M Y') }}</td>
                              <td>
                                   <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="{{$paymentmethod->id}}" data-name="{{$paymentmethod->name}}" data-status="{{$paymentmethod->status_id}}"><i class="fas fa-pen"></i></a>
                                   <!-- <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a> -->
                                   <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}" data-id="{{$paymentmethod->id}}"><i class="fas fa-trash-alt"></i></a>
                              </td>
                         </tr>
                         @endforeach
                    </tbody>
          
               </table>
          

          </div>
     </div>
     <!-- End Page Content Area -->

     <!-- START MODAL AREA -->
          <!-- start edit modal -->
          <div id="editmodal" class="modal fade">
               <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                         <div class="modal-header">
                              <h6 class="modal-title">Edit Form</h6>
                              <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                         </div>

                         <div class="modal-body">
                              <form id="formaction" action="" method="">
                                   <div class="row align-items-end">
                                        <div class="col-md-7">
                                             <label for="editname">Name <span class="text-danger">*</span></label>
                                             <input type="text" name="name" id="editname" class="form-control form-control-sm rounded-0" placeholder="Enter Status Name" value="{{ old('name') }}"/>
                                        </div>
                                        
                                        <div class="col-md-3 form-group">
                                             <label for="editstatus_id">Status</label>
                                             <select name="status_id" id="editstatus_id" class="form-control form-control-sm rounded-0">
                                                  @foreach($statuses as $status)
                                                       <option value="{{$status['id']}}">{{$status['name']}}</option>
                                                  @endforeach     
                                             </select>
                                        </div>
                                        
               
                                        <div class="col-md-2">
                                             <button type="submit" class="btn btn-primary btn-sm rounded-0">Update</button>
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
     <!-- END MODAL AREA -->
@endsection

@section("css")
     <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("scripts")
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>

     <script type="text/javascript">
          
          

          $(document).ready(function(){

               // Start Passing Header Token
               $.ajaxSetup({
                    headers:{
                         "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                    }
               });
               // End Passing Header Token

               // Start Create Form
               $("#create-btn").click(function(e){
                    e.preventDefault();
                    
                    $.ajax({
                         url:"{{route('paymentmethods.store')}}",
                         type:"POST",
                         dataType:"json",
                         // data:$("#createform").serialize(),
                         data:$("#createform").serializeArray(),
                         success:function(response){
                              console.log(response);
                              // console.log(response.status);
                              // console.log(this.data);

                              const data = response.data;
                              $("#mytable").prepend(
                                   `
                                   <tr id="${'delete_'+data.id}">
                                        <td>${data.id}</td>
                                        <td>${data.name}</td>
                                        <td>
                                             <div class="form-checkbox form-switch">
                                                  <input type="checkbox" class="form-check-input change-btn" ${data.status_id === 3 ? "checked" : ""} data-id="${data.id}" />
                                             </div>
                                        </td>
                                        <td>${data.user_id}</td>
                                        <td>${data.created_at}</td>
                                        <td>${data.updated_at}</td>
                                        <td>
                                             <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="${data.id}" data-name="${data.name}" data-status="${data.status_id}"><i class="fas fa-pen"></i></a>
                                             <a href="javascript:void(0);" class="text-danger ms-2 delete-btns" data-idx="" data-id="${data.id}"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                   </tr>
                                   `
                              );
                         },
                         error:function(response){
                              console.log("Error:",response);
                         }
                    })
               });
               // End Create Form

               // Start Edit Form
               $(document).on("click",".editform",function(e){
                    
                    $("#editname").val($(this).attr("data-name"));
                    $("#editstatus_id").val($(this).data("status"));
                    
                    const getid = $(this).attr("data-id");
                    $("#formaction").attr("data-id",getid); // send id to formaction for request id from submit action
                    // console.log(getid);
               });

               $("#formaction").submit(function(e){
                    e.preventDefault();

                    const getid = $(this).attr("data-id");
                    console.log(getid);

                    $.ajax({
                         url:`paymentmethods/${getid}`,
                         type:"PUT",
                         dataType:"json",
                         data:$("#formaction").serialize(), // name=&status_id=4
                         success:function(response){
                              // console.log(this.data);  //name=kpay&status_id=3
                              // console.log(response);   // paymentmethods:525 {status: 'success', data: {…}}
                              console.log(response.status);
                              $("#editmodal").modal("hide");

                              // window.location.reload(); // temp reload
                         }
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
               // Using default laravel route
               $(".delete-btns").click(function(){
                    const getidx = $(this).attr("data-idx");
                    const getid = $(this).data("id");
                    // console.log(getid);
                    
                    if(confirm(`Are you sure !!! you want to Delete ${getidx} ?`)){
                         // ui remove
                        
                         // data remove 
                         $.ajax({
                              url:`paymentmethods/${getid}`,
                              type:"DELETE",
                              dataType:"json",
                              // data:{_token:"{{csrf_token()}}"},
                              success:function(response){
                                   if(response && response.status === "success"){
                                        const getdata = response.data;
                                        $(`#delete_${getdata.id}`).remove();
                                   }
                              }
                         });
                         return true;
                    }else{
                         return false;
                    }
               });

               // End Delete Item


               // for mytable
               $("#mytable").DataTable();

               //Start change-btn
               $(".change-btn").change(function(){
                    var getid = $(this).data("id");
                    // console.log(getid); // 1 2

                    var setstatus = $(this).prop("checked") === true ? 3 : 4;
                    // console.log(setstatus); // 3 4

                    $.ajax({
                         url:"paymentmethodsstatus",
                         type:"GET",
                         dataType:"json",
                         data:{"id":getid,"status_id":setstatus},
                         success:function(response){
                              console.log(response); // {success: 'Status Change Successfully'}
                              console.log(response.success); // Status Change Successfully
                         }
                    });
               });
               // End change btn
                    
          });

     </script>
@endsection