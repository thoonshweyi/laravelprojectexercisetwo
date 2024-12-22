@extends("layouts.adminindex")

@section("caption","Create Leave")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
               <form action="/leaves" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                         <div class="col-md-4">

                              <div class="row">
                                   <div class="col-md-12 mb-3">
                                        <label for="images" class="gallery"><span>Choose Images</span></label>
                                        <input type="file" name="images[]" id="images" class="form-control form-control-sm rounded-0"  hidden multiple/>
                                   </div>

                                   <div class="col-md-6 mb-3">
                                        <label for="startdate">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" name="startdate" id="startdate" class="form-control form-control-sm rounded-0" value="{{ old('startdate',$gettoday) }}"/>
                                   </div>

                                   <div class="col-md-6 mb-3">
                                        <label for="enddate">End Date <span class="text-danger">*</span></label>
                                        <input type="date" name="enddate" id="enddate" class="form-control form-control-sm rounded-0" value="{{ old('enddate',$gettoday) }}"/>
                                   </div>
                                   
                              </div>
                              
                         </div>

                         <div class="col-md-8">
                              <div class="row">
                                   
                                   <div class="col-md-12 mb-3">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" placeholder="Enter Post Title" value="{{ old('title') }}"/>
                                   </div>

                                   <div class="col-md-6 mb-3">
                                        <label for="post_id">Class <span class="text-danger">*</span></label>
                                        <select name="post_id[]" id="post_id" class="form-control form-control-sm rounded-0" multiple>
                                        <!-- <option selected disabled value="">Choose Class</option>      -->
                                             @foreach($posts as $id=>$name)
                                                  <option value="{{$id}}">{{ $name }}</option>
                                             @endforeach
                                        </select>
                               
                                   </div>
 
                                   <div class="col-md-6 mb-3">
                                        <label for="tag">Tag <span class="text-danger">*</span></label>
                                        <select name="tag[]" id="tag" class="form-control form-control-sm rounded-0 select2" multiple>
                                             <!-- <option selected disabled value="">Choose authorize person</option>      -->
                                             
                                             @foreach($tags as $id=>$name)
                                                  <option value="{{$id}}">{{ $name }}</option>
                                             @endforeach
                                        </select>
                                   </div>

                                   <div class="col-md-12 mb-3">
                                        <label for="content">Content <span class="text-danger">*</span></label>
                                        <textarea name="content" id="content" class="form-control form-control-sm rounded-0" rows="5" placeholder="Say Something....">{{ old('content') }}</textarea>
                                   </div>
                                   

                                   <div class="col-md-12 d-flex justify-content-end align-items-end">
                                             <a href="{{route('posts.index')}}" class="btn btn-secondary btn-sm rounded-0 me-3">Cancel</a>
                                             <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
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
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
          
     <style type="text/css">
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
     </style>
       
@endsection

@section("scripts")
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

     {{-- summernote css1 js1 --}}
     <script src="{{ asset('assets/libs/summernote-0.8.18-dist/summernote-lite.min.js') }}" type="text/javascript"></script>
     <script type="text/javascript">
          $(document).ready(function(){

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
                         console.log(input.files);

                         for(var i = 0 ; i < totalfiles ; i++){
                              var filereader = new FileReader();


                              filereader.onload = function(e){
                                   // $(output).html(""); 
                                   $($.parseHTML('<img>')).attr('src',e.target.result).appendTo(output);
                              }

                              filereader.readAsDataURL(input.files[i]);

                         }
                    }
               
               };

               $('#images').change(function(){
                    previewimages(this,'.gallery');
               });

               // Start text editor for content
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
               // End text editor for content


               $('#tag').select2({
                    placeholder: 'Choose autorize person'
               });
               $('#post_id').select2({
                    placeholder: 'Choose class'
               });

               $("#startdate,#enddate").flatpickr({
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    maxDate: new Date().fp_incr(30)
               });
          });
     </script>
@endsection