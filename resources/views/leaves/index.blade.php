@extends("layouts.adminindex")

@section("caption","Leave List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">

          <div class="col-md-12">
               <div class="row">
                    <div class="col-md-3">
                         <div class="card border-0 bg-primary rounded text-white  mb-3">
                              <div class="card-body">
                                   <h6 class="card-title">Total Leaves</h6>
                                   <span class="card-text">{{ $totalleaves }}</span>
                              </div>
                         </div>
                    </div>
                    <div class="col-md-3">
                         <div class="card bg-success border-0 rounded text-white  mb-3">
                              <div class="card-body">
                                   <h6 class="card-title">Approved</h6>
                                   <span class="card-text">{{ $approvedcount }}</span>
                              </div>
                         </div>
                    </div>
                    <div class="col-md-3">
                         <div class="card bg-warning border-0 rounded text-white  mb-3">
                              <div class="card-body">
                                   <h6 class="card-title">Pending</h6>
                                   <span class="card-text">{{ $pendingcount }}</span>
                              </div>
                         </div>
                    </div>
                    <div class="col-md-3">
                         <div class="card bg-danger border-0 rounded text-white  mb-3">
                              <div class="card-body">
                                   <h6 class="card-title">Rejected</h6>
                                   <span class="card-text">{{ $rejectedcount }}</span>
                              </div>
                         </div>
                    </div>
                   
               </div>
          </div>

          <div class="col-md-12">

               @can('create',App\Models\Leave::class)
               <a href="{{route('leaves.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>
               <hr/>
               @endcan
               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>No</th>
                         <th>Title</th>
                         <th>Tag</th>
                         <th>Start Date</th>
                         <th>End Date</th>
                         <th>Stage</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                         @foreach($leaves as $idx=>$leave)
                         <tr>
                              <td>{{++$idx}}</td>
                              <td><a href="{{ route('leaves.show',$leave->id) }}">{{Str::limit($leave->title,20)}}</a></td>
                              <td>
                                   @php 
                                        $tagids = json_decode($leave->tag,true); // Decode Json-encoded tags
                                        $tagnames = collect($tagids)->map(function($id) use($users){
                                             return $users[$id];
                                        });
                                   @endphp
                                   {{ $tagnames->join(',') }} {{-- Display names comma-seperate --}}
                                   
                                   {{-- $leave->maptagtonames($users) --}}
                              </td>
                              <td>{{ $leave->startdate }}</td>
                              <td>{{ $leave->enddate }}</td>
                              <td>{{ $leave->stage["name"] }}</td>
                              <td>{{ $leave->user["name"] }}</td>
                              <td>{{ $leave->created_at->format('d M Y') }}</td>
                              <td>{{ $leave->updated_at->format('d M Y') }}</td>
                              <td>
                                   <a href="{{ route('leaves.show',$leave->id) }}" class="text-primary"><i class="fas fa-book-reader"></i></a>
                                   <a href="{{ route('leaves.edit',$leave->id) }}" class="text-info ms-2"><i class="fas fa-pen"></i></a>
                                   <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                              </td>
                              <form id="formdelete-{{ $idx }}" class="" action="{{route('leaves.destroy',$leave->id)}}" method="POST">
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

@section("css")
     <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("scripts")
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
     <script type="text/javascript">
          $(document).ready(function(){
               // Start delete btn
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
               // End delete btn


               // for mytable
               // let table = new DataTable('#mytable');
               $("#mytable").DataTable();
               
          });


     </script>
@endsection