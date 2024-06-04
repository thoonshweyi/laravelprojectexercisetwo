@extends("layouts.adminindex")

@section("caption","attcodegenerator List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          
          <div class="col-md-12">
               <form action="{{route('attcodegenerators.store')}}" method="POST">
                    {{ csrf_field() }}

                    <div class="row align-items-end">
                         <div class="col-md-3 form-group mb-3">
                              <label for="classdate">Class Date <span class="text-danger">*</span></label>
                              @error("classdate")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror
                              <input type="date" name="classdate" id="classdate" class="form-control form-control-sm rounded-0" value="{{ $gettoday }}"/>
                         </div>

                         <div class="col-md-3 form-group mb-3">
                              <label for="post_id">Class <span class="text-danger">*</span></label>
                              @error("post_id")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror
                              <select name="post_id" id="post_id" class="form-control form-control-sm rounded-0">
                                   <option selected disabled>Choose class</option>
                                   @foreach($posts as $post)
                                        {{-- <option value="{{$post['id']}}">{{$post['title']}}</option> --}}
                                        <option value="{{$post->id}}">{{$post->title}}</option> 
                                   @endforeach     
                              </select>
                         </div>

                         <div class="col-md-3 form-group mb-3">
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

                         <div class="col-md-3 form-group mb-3">
                              <label for="attcode">Attendance Code <span class="text-danger">*</span></label>
                              @error("attcode")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror
                              <input type="text" name="attcode" id="attcode" class="form-control form-control-sm rounded-0" value="{{ old('attcode') }}"/>
                         </div>

                         <div class="col-md-12 text-end">
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
                         <th>Class</th>
                         <th>Att Code</th>
                         <th>Class Date</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                         @foreach($attcodegenerators as $idx=>$attcodegenerator)
                         <tr>
                              <td>{{++$idx}}</td>
                              <td>{{$attcodegenerator->post["title"]}}</td>
                              <td>{{ $attcodegenerator->attcode }}</td>
                              <td>{{ $attcodegenerator->classdate }}</td>
                              <td>{{  $attcodegenerator->user->name }}</td>
                              <td>{{ $attcodegenerator->created_at->format('d M Y') }}</td>
                              <td>
                                   <div class="form-checkbox form-switch">
                                        <input type="checkbox" class="form-check-input change-btn" {{  $attcodegenerator->status_id === 3 ? 'checked' : '' }} data-id="{{ $attcodegenerator->id }}" />
                                   </div>
                              </td>
                         </tr>
                         @endforeach
                    </tbody>
          
               </table>
          

          </div>
     </div>
     <!-- End Page Content Area -->

@endsection


@section("scripts")
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>   

     <script type="text/javascript">
          $(document).ready(function(){
               //Start change-btn
               $(document).on("change",".change-btn",function(){

                    var getid = $(this).data("id");
                    // console.log(getid); // 1 2

                    var setstatus = $(this).prop("checked") === true ? 3 : 4;
                    // console.log(setstatus); // 3 4

                    $.ajax({
                         url:"attcodegeneratorssstatus",
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
               
          });

          


     </script>
@endsection