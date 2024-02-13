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

          <div class="col-md-12">

               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>No</th>
                         <th>Name</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                         @foreach($statuses as $idx=>$status)
                         <tr>
                              <td>{{++$idx}}</td>
                              <td>{{ $status->name }}</td>
                              <td>{{ $status->user["name"] }}</td>
                              <td>{{ $status->created_at->format('d M Y') }}</td>
                              <td>{{ $status->updated_at->format('d M Y') }}</td>
                              <td>
                                   <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="{{$status->id}}" data-name="{{$status->name}}"><i class="fas fa-pen"></i></a>
                                   <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                              
                              </td>
                              <form id="formdelete-{{ $idx }}" class="" action="{{route('statuses.destroy',$status->id)}}" method="POST">
                                   @csrf
                                   @method("DELETE")
                              </form>
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
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                         <div class="modal-content">
                              <div class="modal-header">
                                   <h6 class="modal-title">Edit Form</h6>
                                   <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <div class="modal-body">
                                   <form id="formaction" action="{{route('statuses.update',$status->id)}}" method="POST">
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


@section("scripts")
     <script type="text/javascript">

          $(document).ready(function(){
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
          });


     </script>
@endsection

<!-- {{route('statuses.update',$status->id)}} -->
<!-- http://127.0.0.1:8000/statuses/14 -->