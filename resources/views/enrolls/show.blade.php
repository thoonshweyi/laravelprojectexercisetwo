@extends("layouts.adminindex")

@section("caption","enroll Show")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
               <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
               <a href="{{route('enrolls.index')}}" class="btn btn-secondary btn-sm rounded-0">Close</a>

               <hr/>
               
               <div class="row">
               
                    <div class="col-md-4">
                         <h6>Info</h6>
                         <div class="card border-0 rounded-0 shadow">
                              <div class="card-body">
                                   <div class="d-flex flex-column align-items-center mb-3">
                                        <div class="h5 mb-1">{{ $enroll->title }} </div>
                                        <div class="text-muted">
                                             <span>{{ $enroll["stage"]["name"] }}</span>
                                        </div>
                                        {{-- <img src="{{ asset($enroll->image) }}" class="" alt="{{$enroll->title}}" width="200"/> --}}
                                   </div>

                                   <div class="mb-5">
                                       

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
                                                            <div class="">
                                                                 
                                                            </div>
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
                                                            <div class="">{{date('d M Y',strtotime($enroll->created_at))}} | {{date('h:i:s A',strtotime($enroll->created_at))}}</div>
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
                                                            <div class="">{{date('d M Y h:i:s A',strtotime($enroll->updated_at))}}</div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>


                                   <div class="mb-5">
                                        <p class="text-small text-muted text-uppercase mb-2">Contact Info</p>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-calender-alt"></i>
                                             </div>
                                             <div class="col">Sample Data</div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-calender-alt"></i>
                                             </div>
                                             <div class="col">Sample Data</div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-calender-alt"></i>
                                             </div>
                                             <div class="col">Sample Data</div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-calender-alt"></i>
                                             </div>
                                             <div class="col">Sample Data</div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-8">

                         <h6>Compose</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <div class="card-body">
                                   <div class="accordion">
                                        <div class="acctitle">Email</div>
                                        <div class="acccontent">
                                             <div class="col-md-12 py-3">
                                                  <form action="{{ route('compose.mail') }}" method="POST">
                                                       @csrf
                                                       <div class="row">
                                                            <div class="col-md-6 form-group mb-3">
                                                                 <input type="email" name="cmpemail" id="cmpemail" class="form-control form-control-sm border-0 rounded-0" placeholder="To:" value="{{ $enroll->user['email'] }}" readonly />
                                                            </div>
                                                            <div class="col-md-6 form-group mb-3">
                                                                 <input type="ext" name="cmpsubject" id="cmpsubject" class="form-control form-control-sm border-0 rounded-0" placeholder="Subject" value="" />
                                                            </div>
                                                            <div class="col-md-12 form-group mb-3">
                                                                 <textarea name="cmpcontent" id="cmpcontent" class="form-control form-control-sm border-0 rounded-0" style="resize:none;" rows="3" placeholder="Your message here...."></textarea>
                                                            </div>

                                                            <div class="col d-flex justify-content-end align-items-end">
                                                                 <button type="submit" class="btn btn-secondary btn-sm rounded-0">Send</button>
                                                            </div>

                                                       </div>
                                                  </form>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         
                         <h6>Class</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <div class="card-body d-flex flex-wrap gap-3">
                                   
                                   <div class="border shadow p-3 mb-3 enrollboxes">
                                        <a href="{{ route('posts.show',$enroll->post->id) }}">{{ $enroll->post['title'] }}</a>
                                   </div>
                              </div>
                         </div>

                         <h6>Additional Info</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <ul class="nav">
                                   <li class="nav-item">
                                        <button type="button" id="autoclick" class="tablinks" onclick="gettab(event,'remarktab')">Remark</button>
                                   </li>

                                   <li class="nav-item">
                                        <button type="button" id="autoclick" class="tablinks" onclick="gettab(event,'enrollmentstab')">Enrollments</button>
                                   </li>
                              </ul>

                              <div class="tab-content">

                                   <div id="remarktab" class="tab-pane">
                                        <p>{!! $enroll->remark !!}</p>
                                        <a href="{{ asset($enroll->image) }}" data-lightbox="image" data-title="My caption">
                                             <img src="{{ asset($enroll->image) }}" alt="{{ $enroll->id }}" class="img-thumbnail" width="100" height="100"/>
                                        </a>
                                   </div>

                                   <div id="enrollmentstab" class="tab-pane">
                                        <p>{!! $enroll->remark !!}</p>
                                        <table id="mytable" class="table table-sm table-hover border">
          
                                             <thead>
                                                  <th>No</th>
                                                  <th>Student Id</th>
                                                  <th>Class</th>
                                                  <th>Stage</th>
                                                  <th>Created At</th>
                                                  <th>Updated At</th>
                                             </thead>
                                             <tbody>
                                                  @foreach($enrollments as $idx=>$enrollment)
                                                  <tr>
                                                       <td>{{++$idx}}</td>
                                                       {{-- <td>{{ $enrollment->student($enrollment->user_id) }}</td> --}}
                                                       {{-- <td><a href="{{route('students.show',$enrollment->studenturl())}}">{{$enrollment->student()}}</a></td> --}}
                                                       <td><a href="{{route('enrolls.show',$enrollment->id)}}">{{$enrollment->student()}}</a></td>
                                                       <td><a href="{{route('posts.show',$enrollment->post_id)}}">{{$enrollment->post["title"]}}</a></td>
                                                       <td>{{ $enrollment->stage->name }}</td>
                                                       <td>{{ $enrollment->created_at->format('d M Y') }}</td>
                                                       <td>{{ $enrollment->updated_at->format('d M Y') }}</td>
                                                  </tr>
                                                  @endforeach
                                             </tbody>

                                        </table>
                                   </div>

                                   

                              </div>
                         </div>

                         @if(auth()->user()->hasRoles(["Admin","Teacher"]))
                         <h6>Control Session</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <ul class="nav">
                                   <li class="nav-item">
                                        <button type="button" id="autoclick" class="tablinks" onclick="gettab(event,'authorizationtag')">Authorization</button>
                                   </li>
                              </ul>

                              <div class="tab-content">

                                   <div id="authorizationtag" class="tab-pane">
                                        <form action="{{ route('enrolls.updatestage',$enroll->id) }}" method="POST">
                                             @csrf
                                             @method("PUT")

                                                
                                                  <div class="col-md-3 form-group mb-3">
                                                       <select name="stage_id" id="stage_id" class="form-control form-control-sm rounded-0 country_id">
                                                            <option value="" disabled selected>Choose a country</option>
                                                            @foreach($stages as $stage)
                                                                 <option value="{{$stage['id']}}" {{ $enroll->stage_id == $stage->id ? 'selected' : '' }}>{{$stage['name']}}</option>
                                                            @endforeach     
                                                       </select>
                                                  </div>
                                                

                                                  @if($enroll->isconverted())
                                                       <small class="text-danger">This enroll form has already been converted to an authorized stage. Editing is disabled.</small>
                                                  @endif

                                                  <div class="col-md-3">
                                                       <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3" {{ $enroll->isconverted() ? 'disabled' : '' }}>Update</button>
                                                       </div>
                                                  </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                         @endif
                    </div>

                    

               </div>
          

          </div>
     </div>
     <!-- End Page Content Area -->


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
                              <form id="" action="{{route('enrolls.store')}}" method="enroll" enctype="multipart/form-data">
                                   {{ csrf_field() }}
                                   <div class="row align-items-end">
                                        <div class="col-md-12 mb-3">
                                             <label for="image" class="gallery"><span>Choose Images</span></label>
                                             <input type="file" name="image" id="image" class="form-control form-control-sm rounded-0" value="{{ old('image')}}" hidden/>
                                        </div>
                                        <div class="col-md-12">
                                             <label for="remark">Remark <span class="text-danger">*</span></label>
                                             <textarea type="text" name="remark" id="remark" class="form-control form-control-sm rounded-0" rows="3" placeholder="Enter Remark">{{ old('remark') }}</textarea>
                                        </div>
                                        
                         
                                        <div class="col-md-2">
                                             <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                                        </div>

                                        <!-- Start Hidden Fields -->
                                        <input type="hidden" name="leave_id" value="{{$enroll->id}}" />
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
     <!-- Lightbox2 css1 js1  -->
     <link href="{{ asset('assets/libs/lightbox2-dev/dist/css/lightbox.min.css') }}" type="text/css" rel="stylesheet"/>
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

          /* Start Accordion */
               .accordion{
               width: 100%;
               }
               .acctitle{
               font-size: 13px;
               user-select: none;

               padding: 5px;
               margin: 0;

               cursor: pointer;

               user-select: none;

               position: relative;
               }
               .acctitle::after{
               content: '\f0e0';
               font-family: 'Font Awesome 5 Free';

               /* position: absolute;
               right: 15px;
               top: 50%;
               transform: translateY(-50%); */

               float: right;
               }
               /* .active.acctitle::after{
               content: '\f068';
               } */
               .shown::after{
               content: '\f2B6';
               }
               .acccontent{
               height: 0;
               background-color: #f4f4f4;
               text-align: justify;

               padding: 0 10px;

               overflow: hidden;

               transition: height 0.3s ease-in-out;
               }
          /* End Accordion */

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
     <!-- Lightbox2 css1 js1  -->
     <script src="{{ asset('assets/libs/lightbox2-dev/dist/js/lightbox.min.js') }}" type="text/javascript"></script>
     
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

            // Start Accordion
            var getacctitles = document.getElementsByClassName('acctitle');
               // console.log(getacctitles);
               var getacccontents = document.querySelectorAll('.acccontent');
               // console.log(getacccontents);


               for(var x = 0 ; x < getacctitles.length ; x++){
               
               getacctitles[x].addEventListener('click',function(e){
                    // console.log(e.target);
                    // console.log(this);

                    this.classList.toggle('shown');

                    var getcontent = this.nextElementSibling;
                    // console.log(getcontent);

                    if(getcontent.style.height){
                         getcontent.style.height = null; //beware can't set 0
                    }else{
                         // console.log(getcontent.scrollHeight);
                         getcontent.style.height = getcontent.scrollHeight + 'px';
                    }
               });

               if(getacctitles[x].classList.contains('shown')){
                    getacccontents[x].style.height = getacccontents[x].scrollHeight + 'px';
               }
               }
          // End Accordion

          


          lightbox.option({
               'resizeDuration': 100,
               // 'wrapAround': true
          })
     </script>
@endsection