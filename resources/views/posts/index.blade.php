@extends("layouts.adminindex")

@section("caption","Post List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">

               <a href="{{route('posts.create')}}" class="btn btn-primary btn-sm rounded-0">Create</a>
               <hr/>
               
               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>No</th>
                         <th>Title</th>
                         <th>Start Date</th>
                         <th>End Date</th>
                         <th>Start Time</th>
                         <th>End Time</th>
                         <th>Fee</th>
                         <th>Type</th>
                         <th>Tag</th>
                         <th>Att Form</th>
                         <th>Status</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                         @foreach($posts as $idx=>$post)
                         <tr>
                              <td>{{++$idx}}</td>
                              <td><img src="{{ asset($post->image) }}" class="rounded-circle" alt="{{$post->title}}" width="20" height="20"/> <a href="{{route('posts.show',$post->id)}}">{{ Str::limit($post->title,20) }}</a></td>
                              <td>{{ $post->startdate }}</td>
                              <td>{{ $post->enddate }}</td>
                              <td>{{ $post->starttime }}</td>
                              <td>{{ $post->endtime }}</td>
                              <td>{{ $post->fee }}</td>
                              <td>{{ $post->type->name }}</td>
                              <td>{{ $post->tag->name }}</td>
                              <td>{{ $post->attstatus["name"] }}</td>
                              <td>{{ $post->status["name"] }}</td>
                              <td>{{ $post->user["name"] }}</td>
                              <td>{{ $post->created_at->format('d M Y') }}</td>
                              <td>{{ $post->updated_at->format('d M Y') }}</td>
                              <td>
                                   @can('edit',$post)
                                        <a href="{{ route('posts.edit',$post->id) }}" class="text-info"><i class="fas fa-pen"></i></a>
                                   @endcan
                                   @can('delete',$post)
                                        <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                                   @endcan

                              </td>
                              <form id="formdelete-{{ $idx }}" class="" action="{{route('posts.destroy',$post->id)}}" method="POST">
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