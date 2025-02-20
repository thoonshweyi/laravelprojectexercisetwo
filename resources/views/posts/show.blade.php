@extends("layouts.adminindex")

@section("caption","Post Show")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
               <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
               <a href="{{route('posts.index')}}" class="btn btn-secondary btn-sm rounded-0">Close</a>

               <hr/>
               
               <div class="row">
               
                    <div class="col-md-4">
                         <h6>Info</h6>
                         <div class="card border-0 rounded-0 shadow">
                              <div class="card-body">
                                   <div class="d-flex flex-column align-items-center mb-3">
                                        <div class="h5 mb-1">{{ $post->title }} </div>
                                        <div class="text-muted">
                                             <span>{{ $post["type"]["name"] }} : {{ $post->fee }}</span>
                                        </div>
                                        <img src="{{ asset($post->image) }}" class="" alt="{{$post->title}}" width="200"/>
                                   </div>

                                   <div class="w-100 d-flex flex-row justify-content-between mb-3">
                                        @if(!$post->checkenroll($userdata->id))
                                             <a href="#createmodal" class="w-100 btn btn-primary btn-sm rounded-0" data-bs-toggle="modal">Enroll</a>
                                        @endif; 

                                        @if($userdata->checkpostlike($post->id))
                                             <form class="w-100" action="{{route('posts.unlike',$post->id)}}" method="POST">
                                                  @csrf
                                                  <button type="submit" class="w-100 btn btn-outline-primary btn-sm rounded-0">Unlike</button>
                                             </form>
                                        @else 
                                             <form class="w-100" action="{{route('posts.like',$post->id)}}" method="POST">
                                                  @csrf
                                                  <button type="submit" class="w-100 btn btn-outline-primary btn-sm rounded-0">Like</button>
                                             </form>
                                        @endif;
                                       
                                   </div>

                                   <div class="mb-5">
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto">
                                                  <i class="fas fa-user"></i>
                                             </div>
                                             <div class="col ps-3">
                                                  <div class="row">
                                                       <div class="col">
                                                            <div class="">Status</div>
                                                       </div>
                                                       <div class="col-auto">
                                                            <div class="">{{ $post->status["name"] }}</div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto">
                                                  <i class="fas fa-user"></i>
                                             </div>
                                             <div class="col ps-3">
                                                  <div class="row">
                                                       <div class="col">
                                                            <div class="">Status</div>
                                                       </div>
                                                       <div class="col-auto">
                                                            <div class="">{{ $post["attstatus"]["name"] }}</div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row g-0 mb-2">
                                             <div class="col-auto">
                                                  <i class="fas fa-user"></i>
                                             </div>
                                             <div class="col ps-3">
                                                  <div class="row">
                                                       <div class="col">
                                                            <div class="">Authorize</div>
                                                       </div>
                                                       <div class="col-auto">
                                                            <div class="">{{ $post["user"]["name"] }}</div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row g-0 mb-2">
                                             <div class="col-auto">
                                                  <i class="fas fa-calendar-alt fa-sm"></i>
                                             </div>
                                             <div class="col ps-3">
                                                  <div class="row">
                                                       <div class="col">
                                                            <div class="">Created</div>
                                                       </div>
                                                       <div class="col-auto">
                                                            <div class="">{{date('d M Y',strtotime($post->created_at))}} | {{date('h:i:s A',strtotime($post->created_at))}}</div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="row g-0 mb-2">
                                             <div class="col-auto">
                                                  <i class="fas fa-edit fa-sm"></i>
                                             </div>
                                             <div class="col ps-3">
                                                  <div class="row">
                                                       <div class="col">
                                                            <div class="">Updated</div>
                                                       </div>
                                                       <div class="col-auto">
                                                            <div class="">{{date('d M Y h:i:s A',strtotime($post->updated_at))}}</div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="mb-5">
                                        <p class="text-small text-muted text-uppercase mb-2">Class Day</p>
                                        @foreach($dayables as $dayable)
                                             <div class="row g-0 mb-2">
                                                  <div class="col-auto me-2">
                                                       <i class="fas fa-calender-alt"></i>
                                                  </div>
                                                  <div class="col">{{$dayable['name']}}</div>
                                             </div>
                                        @endforeach
                                   </div>

                                   <div class="mb-5">
                                        <p class="text-small text-muted text-uppercase mb-2">Other</p>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-thumbs-up"></i>
                                             </div>
                                             <div class="col">{{ $post->likes()->count() }}</div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-hand-pointer"></i>
                                             </div>
                                             <div class="col">
                                                  @php 
                                                       $getpageurl = url()->current();
                                                       $pageview = \App\Models\Pageview::where("pageurl",$getpageurl)->first()->counter;
                                                  @endphp 
                                                  Clicked {{$pageview}} times
                                             </div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-eye"></i>
                                             </div>
                                             <div class="col">
                                                  <span id="liveviewer">0</span> watching
                                             </div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-info"></i>
                                             </div>
                                             <div class="col">Sample Data</div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-8">
                         <h6>Comments</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <div class="card-body d-flex flex-wrap gap-3">
                                   
                                   <div class="col-md-12">
                                        <div class="card rounded-0">
                                             <div class="card-body">
                                                  <ul class="list-group chat-boxs">
                                                       @forelse($comments as $comment)
                                                            <li class="list-group-item mt-2">
                                                                 <div>
                                                                      <p>{{$comment->description}}</p>
                                                                 </div>
                                                                 <div>
                                                                      <span class="small fw-bold  float-end">{{$comment->user["name"] }} | {{$comment->created_at->diffForHumans()}}</span>
                                                                      
                                                                 </div>
                                                                 
                                                            </li>
                                                            @empty
                                                            <li class="list-group-item mt-2">No Comments Found</li>
                                                       @endforelse
                                                  </ul>
                                             </div>
                                             <div class="card-body border-top">
                                                  <form action="{{route('comments.store')}}" method="POST">
                                                       @csrf
                                                       <div class="col-md-12 d-flex justify-between">
                                                            <textarea name="description" id="description"  class="form-control border-0 rounded-0" rows="1" style="resize:none;" placeholder="Comment here...."></textarea>
                                                            <button type="submit" class="btn btn-info btn-sm text-light ms-3"><i class="fas fa-paper-plane"></i></button>
                                                       </div>

                                                       <!-- Start Hidden Fields -->
                                                       <input type="hidden" name="commentable_id" id="commentable_id" value="{{$post->id}}" />
                                                       <input type="hidden" name="commentable_type" id="commentable_type" value="App\Models\Post" />
                                                       <!-- Start Hidden Fields -->

                                                  </form>
                                             </div>
                                        </div>    
                                   </div>
                              </div>
                         </div>

                         <h6>Additional Info</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <ul class="nav">
                                   <li class="nav-item">
                                        <button type="button" id="autoclick" class="tablinks" onclick="gettab(event,'follower')">Follower</button>
                                   </li>
                                   <li class="nav-item">
                                        <button type="button" class="tablinks" onclick="gettab(event,'following')">Following</button>
                                   </li>
                                   <li class="nav-item">
                                        <button type="button" class="tablinks" onclick="gettab(event,'liked')">Liked</button>
                                   </li>
                                   <li class="nav-item">
                                        <button type="button" class="tablinks" onclick="gettab(event,'remark')">Remark</button>
                                   </li>
                                   <li class="nav-item">
                                        <button type="button" class="tablinks" onclick="gettab(event,'duration')">Duration</button>
                                   </li>
                              </ul>

                              <div class="tab-content">

                                   <div id="follower" class="tab-pane">
                                        <h3>This is Home Information</h3>
                                        <p>{{ $post->content }}</p>
                                   </div>

                                   <div id="following" class="tab-pane">
                                        <h3>This is Profile Information</h3>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                   </div>

                                   <div id="liked" class="tab-pane">
                                        <h3>This is Contact Information</h3>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                   </div>

                                   <div id="remark" class="tab-pane">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                   </div>

                                   <div id="duration" class="tab-pane">
                                        <h6>This is frequently viewer's duration</h6>
                                        <table class="table table-sm table-hover border">
                                             <thead>
                                                  <tr>
                                                       <th>User</th>
                                                       <th>Duration</th>
                                                       <th>Date</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  @foreach($postviewdurations as $postviewduration)
                                                       <tr>
                                                            <td>{{ $postviewduration->user->name }}</td>
                                                            <td>{{ $postviewduration->duration }} s</td>
                                                            <td>{{ $postviewduration->created_at->format("d M Y h:m A") }}</td>
                                                       </tr>
                                                  @endforeach
                                             </tbody>
                                        </table>
                                   </div>

                              </div>
                         </div>
                    </div>

                    

               </div>
          

          </div>
     </div>
     <!-- End Page Content Area -->

     {{-- Start Hidden Area --}}
     <input type="hidden" id="setpostid" data-id="{{$post->id}}" />
     {{-- End Hidden Area --}}


     <!-- START MODAL AREA -->
          <!-- start create modal -->
          <div id="createmodal" class="modal fade">
               <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                         <div class="modal-header">
                              <h6 class="modal-title">Enroll Form</h6>
                              <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                         </div>

                         <div class="modal-body">
                              <form id="" action="{{route('enrolls.store')}}" method="POST" enctype="multipart/form-data">
                                   {{ csrf_field() }}
                                   <div class="row align-items-end">
                                        <div class="col-md-12 mb-3">
                                             <label for="image" class="gallery"><span>Choose Images</span></label>
                                             <input type="file" name="image" id="image" class="form-control form-control-sm rounded-0" value="{{ old('image')}}" hidden/>
                                        </div>
                                        <div class="col-md-10">
                                             <label for="remark">Remark <span class="text-danger">*</span></label>
                                             <textarea type="text" name="remark" id="remark" class="form-control form-control-sm rounded-0" rows="3" placeholder="Enter Remark">{{ old('remark') }}</textarea>
                                        </div>
                                        
                         
                                        <div class="col-md-2">
                                             <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                                        </div>

                                        <!-- Start Hidden Fields -->
                                        <input type="hidden" name="post_id" value="{{$post->id}}" />
                                        <!-- Start Hidden Fields -->
                                   </div>
                              </form>
                         </div>

                         <div class="modal-footer">

                         </div>
                    </div>
               </div>
          </div>
          <!-- end create modal -->
     <!-- END MODAL AREA -->
@endsection

@section("css")
     <style type="text/css">
          /* start comment */
          .chat-boxs{
               height: 200px;
               overflow-y : scroll;
          }
          /* end comment */


          /* Start for image preview */
          .gallery{
               width: 100%;
               /* height: 100%; */
               background-color: #eee;
               color: #aaa;

               display:flex;
               justify-content:center;
               align-items:center;

               text-align: center;
               padding: 10px;
          }
          .gallery img{
               width: 100px;
               height: 100px;
               border: 2px dashed #aaa;
               border-radius: 10px;
               object-fit: cover;

               padding: 5px;
               margin: 0 5px;
          }
          .removetxt span{
               display: none;
          }
          /* End Image Preview */


           /* Start Tag Box */
           .nav{
          display: flex;

          padding: 0;
          margin: 0;
          }
          .nav .nav-item{
          list-style-type: none;
          }
          .nav .tablinks{
          border: none;
          font-size: 16px;
          padding: 15px 20px;
          cursor: pointer;

          transition: background-color 0.3s ease-in;
          }
          .nav .tablinks:hover{
          background-color: #f3f3f3;
          }

          .nav .tablinks.active{
               color: blue;
          }

          .tab-pane{

          padding: 5px 15px;

          display: none;
          }
          /* End Tag Box */
     </style>     

@endsection

@section("scripts")
     <script type="text/javascript">
          // Start Back Btn
          const getbtnback = document.getElementById("btn-back");
               getbtnback.addEventListener("click",function(){
                    // window.history.back();
                    window.history.go(-1);
               });
          // End Back Btn

           // Start Tag Box
           var gettablinks = document.getElementsByClassName('tablinks');  //HTMLCollection
               var gettabpanes = document.getElementsByClassName('tab-pane');
               // console.log(gettabpanes);

               var tabpanes = Array.from(gettabpanes);

               function gettab(evn,linkid){

               tabpanes.forEach(function(tabpane){
                    tabpane.style.display = 'none';
               });

               for(var x = 0 ; x < gettablinks.length ; x++){
                    gettablinks[x].className = gettablinks[x].className.replace(' active','');
               }


               document.getElementById(linkid).style.display = 'block';


               // evn.target.className += ' active';
               // evn.target.className = evn.target.className.replace('tablinks','tablinks active');
               // evn.target.classList.add('active');

               // evn.target = evn.currentTarget
               evn.currentTarget.className += ' active';

               }

               document.getElementById('autoclick').click();
          // End Tag Box


          // Start Post View Duration 

          // beforeunload = working in reload
          $(window).on("beforeunload",function(){

                                             // toString() // Wed Jun 26 2024 14:44:52 GMT+0630 (Myanmar Time)
                    const exittime = new Date().toISOString(); // 2024-06-26T08:17:31.516Z
                    // console.log(exittime);

                    $.ajax({
                         url:"/trackdurations",
                         type:"POST",
                         data:{
                              exittime:exittime,
                              _token:"{{csrf_token()}}"
                         },       
                         success:function(response){
                              console.log(response);
                         },
                         error:function(response){
                              console.log(response);
                         }
                    })
               });
          // End Post View Duration

          // Start Pusher  Post Live Viewer  

               // Enable pusher logging - don't include this in production
               // Pusher.logToConsole = true;

               var pusher = new Pusher('e202c50a573fa42ec8ed', {
                    cluster: 'ap1'
               });

               function mainchannel(postid){
                    var channel = pusher.subscribe('postliveviewer-channel_'+postid);
                    
                    // global event binding
                    //             postliveviewer-event
                    channel.bind('App\\Events\\PostLiveViewerEvent', function(data) {
                        console.log(data);
                        document.getElementById("liveviewer").textContent = data.count;
                    });
               }

               function incrementviewer(postid){
                    $.ajax({
                         url:`/postliveviewerinc/${postid}`,
                         type:'POST',
                         data:{
                              _token:$("meta[name='csrf-token']").attr("content")
                         },
                         success:function(response){
                              console.log(response);
                              console.log("Increment = ",response.success)
                         },
                         error:function(response){
                              console.log(response);
                         }
                    });
               }
               function decrementviewer(postid){
                    $.ajax({
                         url:`/postliveviewerdec/${postid}`,
                         type:'POST',
                         data:{
                              _token:$("meta[name='csrf-token']").attr("content")
                         },
                         success:function(response){
                              console.log("Decrement Status = ",response.success)
                         }
                    });
               }
               window.addEventListener("DOMContentLoaded",function(){
                    // console.log("i am loaded");
                    const getpostid = document.getElementById("setpostid").getAttribute("data-id");
                    console.log(getpostid);

                    incrementviewer(getpostid);
                    mainchannel(getpostid);
               });
               window.addEventListener("beforeunload",function(){

                    const getpostid = document.getElementById("setpostid").getAttribute("data-id");;

                    // console.log("i am unloaded");
                    decrementviewer(getpostid)
               });

              
          // End Pusher Post Live Viewer 


          $(document).ready(function(){

               var previewimages = function(input,output){

                    console.log(input.files);

                    if(input.files){
                         var totalfiles = input.files.length;
                         console.log(totalfiles);
                         if(totalfiles > 0){
                              $('.gallery').addClass('removetxt');
                         }else{
                              $('.gallery').removeClass('removetxt');
                         }
                         for(var i = 0 ; i < totalfiles ; i++){
                              var filereader = new FileReader();


                              filereader.onload = function(e){
                                   $(output).html(""); 
                                   $($.parseHTML('<img>')).attr('src',e.target.result).appendTo(output);
                              }

                              filereader.readAsDataURL(input.files[i]);

                         }
                    }

               };

               $('#image').change(function(){
                    previewimages(this,'.gallery');
               });
          });
     </script>
@endsection