@extends("layouts.adminindex")

@section("caption","Student List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
               <a href="{{route('students.index')}}" class="btn btn-info btn-sm rounded-0 me-2">Student</a>
               <a href="{{route('leads.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>
               <hr/>
               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>No</th>
                         <th>Lead Number</th>
                         <th>Name</th>
                         <th>Gender</th>
                         <th>Age</th>
                         <th>Email</th>
                         <th>Pipe</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                         @foreach($leads as $idx=>$lead)
                         <tr>
                              <td>{{++$idx}}</td>
                              <td><a href="{{route('leads.show',$lead->id)}}">{{$lead->leadnumber}}</a></td>
                              <td>{{$lead->firstname}} {{$lead->lastname}}</td>
                              <td>{{$lead->gender['age']}} </td>
                              <td>{{$lead->age}} </td>
                              <td>{{ $lead->email }}</td>
                              <td><span class="badge {{ $lead->converted ? 'bg-success' : 'bg-danger' }}">Pipe</span></td>
                              <td>{{ $lead->user["name"] }}</td>
                              <td>{{ $lead->created_at->format('d M Y') }}</td>
                              <td>{{ $lead->updated_at->format('d M Y') }}</td>
                              <td>
                                   <a href="{{ route('leads.edit',$lead->id) }}" class="text-info"><i class="fas fa-pen"></i></a>
                              </td>
                         </tr>
                         @endforeach
                    </tbody>
          
               </table>
          

          </div>
     </div>
     <!-- End Page Content Area -->
@endsection

@section("css")
     <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("scripts")
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>

     <script type="text/javascript">
          // for mytable
          // $("#mytable").DataTable();

     </script>
@endsection