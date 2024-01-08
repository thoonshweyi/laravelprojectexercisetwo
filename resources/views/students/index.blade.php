@extends("layouts.adminindex")

@section("caption","Student List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">

               <a href="{{route('students.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>
               <hr/>
               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>No</th>
                         <th>Reg Number</th>
                         <th>Name</th>
                         <th>Remark</th>
                         <th>Status</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                         @foreach($students as $idx=>$student)
                         <tr>
                              <td>{{++$idx}}</td>
                              <td><a href="{{route('students.show',$student->id)}}">{{$student->regnumber}}</a></td>
                              <td>{{$student->firstname}} {{$student->lastname}}</td>
                              <td>{{Str::limit($student->remark,10)}}</td>
                              <td>{{ $student->status->name }}</td>
                              <td>{{ $student->user["name"] }}</td>
                              <td>{{ $student->created_at->format('d M Y') }}</td>
                              <td>{{ $student->updated_at->format('d M Y') }}</td>
                              <td>
                                   <a href="{{ route('students.edit',$student->id) }}" class="text-info"><i class="fas fa-pen"></i></a>
                                   <!-- <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$student->id}}"><i class="fas fa-trash-alt"></i></a> -->
                                   <!-- <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a> -->
                                   <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$student->regnumber}}"><i class="fas fa-trash-alt"></i></a>
                              
                              </td>
                              <!-- <form id="formdelete-{{ $student->id }}" class="" action="{{route('students.destroy',$student->id)}}" method="POST"> -->
                              <!-- <form id="formdelete-{{ $idx }}" class="" action="{{route('students.destroy',$student->id)}}" method="POST"> -->
                              <form id="formdelete-{{ $student->regnumber }}" class="" action="{{route('students.destroy',$student->id)}}" method="POST">
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
@endsection


@section("scripts")
     <script type="text/javascript">
          $(document).ready(function(){
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
          });


     </script>
@endsection