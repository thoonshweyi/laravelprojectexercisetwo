@extends("layouts.adminindex")

@section("caption","Status List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">

          <div class="col-md-12">
               <!-- http://127.0.0.1:8000/statuses -->
               <form action="{{route('statuses.store')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="row align-items-end">
                         <div class="col-md-6">
                              <label for="name">Name <span class="text-danger">*</span></label>
                              @error("name")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror
                              <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter Status Name" value="{{ old('name') }}"/>
                         </div>

                         <div class="col-md-6 ">
                              <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                              <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                         </div>
                    </div>
               </form>
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

          <div class="col-md-12">

               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>
                              <input type="checkbox" name="selectalls" id="selectalls" class="form-check-input selectalls" />
                         </th>
                         <th>No</th>
                         <th>Name</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                        
                    </tbody>
          
               </table>

               <div class="loading">Loading....</div>

          

          </div>
     </div>
     <!-- End Page Content Area -->

     <!-- START MODAL AREA -->
          <!-- start edit modal -->
               <div id="editmodal" class="modal fade">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                         <div class="modal-content">
                              <div class="modal-header">
                                   <h6 class="modal-title">Edit Form</h6>
                                   <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <div class="modal-body">
                                   <form id="formaction" action="{{-- route('statuses.update',$status->id) --}}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="row align-items-end">
                                             <div class="col-md-8">
                                                  <label for="editname">Name <span class="text-danger">*</span></label>
                                                  <input type="text" name="name" id="editname" class="form-control form-control-sm rounded-0" placeholder="Enter Status Name" value="{{ old('name') }}"/>
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
     <style type="text/css">
          .loading{
               font-weight:bold;

               position:fixed;
               left:50%;
               top:50%;

               transform:translate(-50%,-50%);

               display:none;
          }
     </style>
@endsection

@section("scripts")
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <script type="text/javascript">

         

          $(document).ready(function(){

                // Start Passing Header Token
               $.ajaxSetup({
                    header:{
                         'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content"),
                    }
               })
               // End Passing Header Token
                    
               // Start Fetch All Datas 
               async function fetchalldatas(query=""){
                    await $.ajax({
                         // url:"{{url('api/statusessearch')}}",
                         url:"{{'api/statusessearch'}}",
                         method:"GET",
                         data:{"query":query},
                         dataType:"json",
                         success:function(response){
                              console.log(response); // {status: 'scuccess', data: Array(2)}
                              
                              $(".loading").hide();
                              $("#mytable tbody").empty();
                             
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
                              // $("#mytable tbody").html(html);

                              $("#mytable tbody").prepend(html);
                         }
                    });
               }
               fetchalldatas();
               // End Fetch All Datas

               // Start Filter by search query

               // actively searching while typing
               // $("#filtername").on("keyup",function(e){
               //      e.preventDefault();
               //      const query = $(this).val();
               //      // console.log(query);

               //      fetchalldatas(query);
               // });

               $("#btn-search").on("click",function(e){
                    e.preventDefault();
                    const query = $("#filtername").val();
                    // console.log(query);

                    if(query.length > 0){
                         $(".loading").show();
                    }
                    fetchalldatas(query);
               });
               // End Filter by search query

               // Start Delete Item
               $(".delete-btns").click(function(){
                    // console.log('hay');
          
                    var getidx = $(this).data("idx");
                    // console.log(getidx);

                    if(confirm(`Are you sure !!! you want to Delete ${getidx} ?`)){
                         $('#formdelete-'+getidx).submit();
                         return true;
                    }else{
                         false;
                    }
               });
               // End Delete Item

               // Start Edit Form
               $(document).on("click",".editform",function(e){
                    // console.log($(this).attr("data-id"),$(this).attr("data-name"));
                    
                    $("#editname").val($(this).attr("data-name"));
                    const getid = $(this).attr("data-id");
                    $("#formaction").attr("action",`/statuses/${getid}`);

                    e.preventDefault();
               });
               // End Edit Form

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
                                   url:"{{ route('statuses.bulkdeletes') }}",
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

<!-- {{-- route('statuses.update',$status->id) --}} -->
<!-- http://127.0.0.1:8000/statuses/14 -->