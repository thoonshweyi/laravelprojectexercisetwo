@extends("layouts.adminindex")

@section("caption","Enrolls List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          
          <div class="col-md-12">
               <form action="{{route('enrolls.store')}}" method="POST">
                    {{ csrf_field() }}

                    <div class="row align-items-end">
                         <div class="col-md-3">
                              <label for="classdate">Class Date <span class="text-danger">*</span></label>
                              <input type="date" name="classdate" id="classdate" class="form-control form-control-sm rounded-0" value="{{ old('classdate') }}"/>
                         </div>

                         <div class="col-md-3">
                              <label for="post_id">Class <span class="text-danger">*</span></label>
                              <select name="post_id" id="post_id" class="form-control form-control-sm rounded-0">
                                   @foreach($enrolls as $enroll)
                                        {{-- <option value="{{$post['id']}}">{{$post['title']}}</option> --}}
                                        <option value="{{$enroll->id}}">{{$enroll->title}}</option> 
                                   @endforeach     
                              </select>
                         </div>

                         <div class="col-md-3">
                              <label for="attcode">Attendance Code <span class="text-danger">*</span></label>
                              <input type="text" name="attcode" id="attcode" class="form-control form-control-sm rounded-0" value="{{ old('attcode') }}"/>
                         </div>

                         <div class="col-md-3">
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
                         <th>Student Id</th>
                         <th>Class</th>
                         <th>Stage</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
                    <tbody>
                         @foreach($enrolls as $idx=>$enroll)
                         <tr>
                              <td>{{++$idx}}</td>
                              {{-- <td>{{ $enroll->student($enroll->user_id) }}</td> --}}
                              <td><a href="{{route('students.show',$enroll->studenturl())}}">{{$enroll->student()}}</a></td>
                              <td>{{$enroll->post["title"]}}</td>
                              <td>{{ $enroll->stage->name }}</td>
                              <td>{{ $enroll->created_at->format('d M Y') }}</td>
                              <td>{{ $enroll->updated_at->format('d M Y') }}</td>
                              <td>
                                   <a href="javascript:void(0);" class="text-primary me-2 quickform" data-bs-toggle="modal" data-bs-target="#quickmodal" data-id="{{$enroll->id}}" data-stage="{{$enroll->stage_id}}" data-remark="{{$enroll->remark}}"><i class="fas fa-user-check"></i></a>
                                   <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="{{$enroll->id}}" data-stage_id="{{$enroll->stage_id}}"><i class="fas fa-pen"></i></a>
                              </td>
                         </tr>
                         @endforeach
                    </tbody>
          
               </table>
          

          </div>
     </div>
     <!-- End Page Content Area -->

     <!-- START MODAL AREA -->
          <!-- start quick modal -->
          <div id="quickmodal" class="modal fade">
               <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                         <div class="modal-header">
                              <h6 class="modal-title">Quick Form</h6>
                              <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                         </div>

                         <div class="modal-body">
                              <form id="quickformaction" action="" method="">
                          
                                   <div class="row align-items-end">
                                        
                                        <div class="col-md-3 form-group">
                                             <label for="editstage_id">Stage <span class="text-danger">*</span></label>
                                             <select name="editstage_id" id="editstage_id" class="form-control form-control-sm rounded-0">
                                                  @foreach($stages as $stage)
                                                       <option value="{{$stage->id}}">{{$stage->name}}</option> 
                                                  @endforeach     
                                             </select>
                                        </div>

                                        <div class="col-md-7 form-group">
                                             <label for="editremark">Remark <span class="text-danger">*</span></label>
                                             <input type="text" name="editremark" id="editremark" class="form-control form-control-sm rounded-0"/>
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
          <!-- end quick modal -->
     <!-- END MODAL AREA -->
@endsection


@section("scripts")
     <script type="text/javascript">
          $.ajaxSetup({
               headers:{
                    "X-CSRF-TOKEN" : $("meta[name='csrf-token']").attr("content")
               }
          });
          $(document).ready(function(){

               // Start Edit Form
               $(document).on("click",".quickform",function(){
                    $("#editstage_id").val($(this).attr("data-stage"));
                    $("#editremark").val($(this).attr("data-remark"));

                    const getid = $(this).data("id");
                    // console.log(getid);

                    $("#quickformaction").attr("data-id",getid);
               });

               $("#quickformaction").submit(function(e){
                    e.preventDefault();

                    const getid = $(this).attr("data-id");

                    $.ajax({
                         url:`enrolls/${getid}`,
                         type:"PUT",
                         dataType:"json",
                         data: $(this).serialize(),
                         success:function(response){
                              if(response && response.status === "success"){
                                   console.log(response);
                                   $("#quickmodal").modal("hide");
                              }
                         }
                    });
               });

               // End Edit Form
               
          });


     </script>
@endsection