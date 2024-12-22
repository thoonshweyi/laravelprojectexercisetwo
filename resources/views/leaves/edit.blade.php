@extends("layouts.adminindex")

@section("caption","Edit leave")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
               <form action="/leaves/{{$leave->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")

                    <div class="row">

                         <div class="col-md-4">

                              <div class="row">
                                   <div class="col-md-12 mb-3">

                                        <div class="row">
                                             <div class="col-md-6 text-sm-center">
                                                  <img src="{{asset($leave->image)}}" width="200" alt="{{$leave->title}}"/>
                                             </div>
                                             <div class="col-md-6">
                                                  <label for="images" class="gallery"><span>Choose Images</span></label>
                                                  <input type="file" name="images[]" id="images" class="form-control form-control-sm rounded-0" value="{{ old('image',$leave->image) }}" multiple hidden/>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="col-md-6 mb-3">
                                        <label for="startdate">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" name="startdate" id="startdate" class="form-control form-control-sm rounded-0" value="{{ old('startdate',$leave->startdate) }}"/>
                                   </div>

                                   <div class="col-md-6 mb-3">
                                        <label for="enddate">End Date <span class="text-danger">*</span></label>
                                        <input type="date" name="enddate" id="enddate" class="form-control form-control-sm rounded-0" value="{{ old('enddate',$leave->enddate) }}"/>
                                   </div>
                              </div>
                              
                         </div>

                         <div class="col-md-8">
                              <div class="row">
                                   
                                   <div class="col-md-12 mb-3">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" placeholder="Enter leave Title" value="{{ old('title',$leave->title) }}"/>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="post_id">Class <span class="text-danger">*</span></label>
                                        <select name="post_id[]" id="post_id" class="form-control form-control-sm rounded-0" multiple>
                                             <!-- ?? Coalescing Operator 
                                              
                                                  $variable = $variable ?? $default value
                                             -->
                                             @foreach($posts as $id=>$name)
                                                  <option value="{{$id}}"
                                                       {{  in_array($id,json_decode($leave->post_id,true) ?? [] ) ? 'selected' : '' }}
                                                  >{{ $name }}</option>
                                             @endforeach
                                        </select>
                                   </div>

                                   <div class="col-md-6">
                                        <label for="tag">Tag <span class="text-danger">*</span></label>
                                        <select name="tag[]" id="tag" class="form-control form-control-sm rounded-0" multiple>
                                             @foreach($tags as $id=>$name)
                                                  <option value="{{$id}}"
                                                       {{ in_array($id,json_decode($leave->tag,true) ?? []) ? 'selected' : '' }}
                                                  >{{ $name }}</option>
                                             @endforeach
                                        </select>
                                   </div>


                                   <div class="col-md-12 mb-3">
                                        <label for="content">Content <span class="text-danger">*</span></label>
                                        <textarea name="content" id="content" class="form-control form-control-sm rounded-0" rows="5" placeholder="Say Something....">{{$leave->content}}</textarea>
                                   </div>                                   

                                   <div class="col-md-12 d-flex justify-content-end align-items-end">
                                        <div class="">
                                             <a href="{{route('leaves.index')}}" class="btn btn-secondary btn-sm rounded-0 me-3">Cancel</a>
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
     
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
          
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
     
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
               // $(".dayactions").click(function(){
               //      var checkboxs = $("input[type='checkbox']");
               //      // console.log(checkboxs);
                    
               //      // var checked = checkboxs.filter(":checked").map(function(){
               //      //      // return this.value;
               //      //      $(this).attr("name","newday_id[]");
               //      // });

               //      // var unchecked = checkboxs.not(":checked").map(function(uncheck){
               //      //      // return this.value;
               //      //      $(this).attr("name","oldday_id[]");
                         
               //      //      // console.log(uncheck);
               //      // });

               //      // check or uncheck
               //      // if($(this).prop('checked')){
               //      //      // console.log("yes");
               //      //      console.log("checked");
               //      // }else{
               //      //      // console.log("no");
               //      //      console.log("unchecked");
               //      // }
               // });
               // End Day Action


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