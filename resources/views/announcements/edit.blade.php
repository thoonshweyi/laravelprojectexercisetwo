@extends("layouts.adminindex")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
               <form action="/announcements/{{$announcement->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")

                    <div class="row">

                         <div class="col-md-4">

                              <div class="row">
                                   <div class="col-md-12 mb-3">

                                        <div class="row">
                                             <div class="col-md-6 text-sm-center">
                                                  <img src="{{asset($announcement->image)}}" width="200" alt="{{$announcement->title}}"/>
                                             </div>
                                             <div class="col-md-6">
                                                  <label for="image" class="gallery"><span>Choose Images</span></label>
                                                  <input type="file" name="image" id="image" class="form-control form-control-sm rounded-0" value="{{ $announcement->image }}" hidden/>
                                             </div>
                                        </div>
                                   </div>

                              </div>
                              
                         </div>

                         <div class="col-md-8">
                              <div class="row">
                                   
                                   <div class="col-md-6 mb-3">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" placeholder="Enter Post Title" value="{{ $announcement->title }}"/>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="post_id">Class <span class="text-danger">*</span></label>
                                        <select name="post_id" id="post_id" class="form-control form-control-sm rounded-0">
                                             @foreach($posts as $id=>$title)
                                                  <option value="{{$id}}"
                                                       @if($id === $announcement["post_id"])
                                                            selected
                                                       @endif
                                                  >{{ $title }}</option>
                                             @endforeach
                                        </select>
                                   </div>

                                   <div class="col-md-12 mb-3">
                                        <label for="content">Content <span class="text-danger">*</span></label>
                                        <textarea name="content" id="content" class="form-control form-control-sm rounded-0" rows="5" placeholder="Say Something....">{{$announcement->content}}</textarea>
                                   </div>

                                   

                                  
                                   <div class="col-md-12 d-flex justify-content-end align-items-end">
                                        <div class="">
                                             <a href="{{route('announcements.index')}}" class="btn btn-secondary btn-sm rounded-0 me-3">Cancel</a>
                                             <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         
                    </div>
               </form>
              
          </div>
     </div>
     <!-- End Page Content Area -->
@endsection

@section("css")
     {{-- summernote css1 js1 --}}
     <link href="{{ asset('assets/libs/summernote-0.8.18-dist/summernote-lite.min.css') }}" rel="stylesheet" type="text/css"/>
     
     <style type="text/css">
          .gallery{
               width: 100%;
               height: 100%;
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
     </style>

            
@endsection

@section("scripts")

     {{-- summernote css1 js1 --}}
     <script src="{{ asset('assets/libs/summernote-0.8.18-dist/summernote-lite.min.js') }}" type="text/javascript"></script>
     <script type="text/javascript">
          $(document).ready(function(){

               // Start Single Image Preview
                    var previewimages = function(input,output){

                    // console.log(input.files);

                    if(input.files){
                         var totalfiles = input.files.length;
                         // console.log(totalfiles);
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
               // End Single Image Preview 
               
               // text editor for content
               $('#content').summernote({
                    placeholder: 'Say Something....',
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                         ['style', ['style']],
                         ['font', ['bold', 'underline', 'clear']],
                         ['color', ['color']],
                         ['para', ['ul', 'ol', 'paragraph']],
                         ['insert', ['link']],
                    ]
               });

               // Start Day Action
               $(".dayactions").click(function(){
                    var checkboxs = $("input[type='checkbox']");
                    // console.log(checkboxs);
                    
                    // var checked = checkboxs.filter(":checked").map(function(){
                    //      // return this.value;
                    //      $(this).attr("name","newday_id[]");
                    // });

                    // var unchecked = checkboxs.not(":checked").map(function(uncheck){
                    //      // return this.value;
                    //      $(this).attr("name","oldday_id[]");
                         
                    //      // console.log(uncheck);
                    // });

                    // check or uncheck
                    // if($(this).prop('checked')){
                    //      // console.log("yes");
                    //      console.log("checked");
                    // }else{
                    //      // console.log("no");
                    //      console.log("unchecked");
                    // }
               });
          });
     </script>
@endsection