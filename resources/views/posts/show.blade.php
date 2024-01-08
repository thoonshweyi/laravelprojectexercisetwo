@extends("layouts.adminindex")

@section("caption","Post Show")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">

               <a href="{{route('posts.index')}}" class="btn btn-secondary btn-sm rounded-0">Close</a>
               <hr/>
               
               <div class="row">
                    <div class="col-md-4">
                         <div class="card rounded-0">
                              <div class="card-body">
                                   <h5 class="card-title">{{ $post->title }} | <span class="text-muted">{{ $post->status["name"] }}</span></h5>
                              </div>

                              <ul class="list-group text-center">
                                   <li class="list-group-item fw-bold"><img src="{{ asset($post->image) }}" class="" alt="{{$post->title}}" width="200"/></li>
                              </ul>

                              <div class="card-body">
                                   <div class="row">
                                        <div class="col-md-6">
                                             <i class="fas fa-user fa-sm"></i> <span>{{$post["tag"]["name"]}}</span>
                                             <br/>
                                             <i class="fas fa-user fa-sm"></i> <span>{{$post["type"]["name"]}} : {{$post->fee}} </span>
                                             <br/>
                                             <i class="fas fa-user fa-sm"></i> <span>{{$post["user"]["name"]}}</span>
                                        </div>
                                        <div class="col-md-6">
                                             <i class="fas fa-file fa-sm"></i> <span>{{$post["attstatus"]["name"]}}</span>
                                             <br/>
                                             <i class="fas fa-calendar-alt fa-sm"></i> <span>{{date('d M Y',strtotime($post->created_at))}} | {{date('h:i:s A',strtotime($post->created_at))}}</span>
                                             <br/>
                                             <i class="fas fa-edit fa-sm"></i> <span>{{date('d M Y h:i:s A',strtotime($post->updated_at))}}</span>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="col-md-8">
                         <div class="card-box rounded-0">
                              <ul class="list-group text-center rounded-0">
                                   <li class="list-group-item active">Information</li>
                              </ul>
                              <!-- start remark -->
                              <table class="table table-sm table-bordered">
                                   <thead>
                                        <tr>
                                             <th>Info....</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <tr>
                                             <td>{{$post->content}}</td>
                                        </tr>
                                   </tbody>
                              </table>
                              <!-- end remark -->
                         </div>

                         <div class="col-md-12">
                              <div class="card rounded-0">
                                   <div class="card-body">
                                        
                                   </div>
                              </div>    
                         </div>
                    </div>

               </div>
          

          </div>
     </div>
     <!-- End Page Content Area -->
@endsection