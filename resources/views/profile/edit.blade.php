@extends("layouts.adminindex")

@section("caption","Student Show")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">

               <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
               <a href="{{route('students.index')}}" class="btn btn-secondary btn-sm rounded-0">Close</a>
               
               <hr/>
               
               <div class="row">
                    <div class="col-md-4 col-lg-3 mb-2">
                    <h6>Info</h6>     
                    <div class="card border-0 rounded-0 shadow">

                              <div class="card-body">
                                   <div class="d-flex flex-column align-items-center mb-3">
                                        <div class="h5 mb-1">{{ $user->name }}</div>
                                        <div class="text-muted">
                                             <span></span>
                                        </div>
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
                                                            <div class=""></div>
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
                                                            <div class="">Lead ID</div>
                                                       </div>
                                                       <div class="col-auto">
                                                            <div class="">{{ $userdata->lead['leadnumber']}}</div>
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
                                                            <div class="">{{ date('d M Y',strtotime($user->created_at)) }} | {{ date('h:i:s A',strtotime($user->created_at)) }}</div>
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
                                                            <div class="">{{ date('d M Y',strtotime($user->updated_at)) }} | {{ date('h:i:s A',strtotime($user->updated_at)) }}</div>

                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <div class="mb-5">
                                        <p class="text-small text-muted text-uppercase mb-2">Personal Info</p>
                                        
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-envelope"></i>
                                             </div>
                                             <div class="col">{{ $user->email }}</div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-info"></i>
                                             </div>
                                             <div class="col">Sample Data</div>
                                        </div>
                                        <div class="row g-0 mb-2">
                                             <div class="col-auto me-2">
                                                  <i class="fas fa-info"></i>
                                             </div>
                                             <div class="col">Sample Data</div>
                                        </div>
                                   </div>

                                   <div class="mb-5">
                                        <p class="text-small text-muted text-uppercase mb-2">Contact Info</p>
                                        
                                        
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                         <h6>Compose</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <div class="card-body">
                                   <div class="accordion">
                                        <div class="acctitle shown">Email</div>
                                        <div class="acccontent">
                                             <div class="col-md-12 py-3">
                                                  <form action="{{ route('students.mailbox') }}" method="POST">
                                                       @csrf
                                                       <div class="row">
                                                            <div class="col-md-6 form-group mb-3">
                                                                 <input type="email" name="cmpemail" id="cmpemail" class="form-control form-control-sm border-0 rounded-0" placeholder="To:" value="" readonly />
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

                         
                         
                         <h6>Enrolls</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <div class="card-body d-flex flex-wrap gap-3">
                                   
                                  
                              </div>
                         </div>

                         <h6>Additional Info</h6>
                         <div class="card border-0 rounded-0 shadow mb-4">
                              <ul class="nav">
                                   <li class="nav-item">
                                        <button type="button" id="autoclick" class="tablinks" onclick="gettab(event,'personaltab')">Personal</button>
                                   </li>
                                   <li class="nav-item">
                                        <button type="button" class="tablinks" onclick="gettab(event,'leadtab')">Lead</button>
                                   </li>
                                   <li class="nav-item">
                                        <button type="button" class="tablinks" onclick="gettab(event,'studenttab')">Student</button>
                                   </li>
                                   <li class="nav-item">
                                        <button type="button" class="tablinks" onclick="gettab(event,'signintab')">Sign In</button>
                                   </li>
                                   <li class="nav-item">
                                        <button type="button" class="tablinks" onclick="gettab(event,'logtab')">Log</button>
                                   </li>
                              </ul>

                              <div class="tab-content">

                                   <div id="personaltab" class="tab-pane">
                                        <h3>This is Home Information</h3>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                   </div>

                                   <div id="leadtab" class="tab-pane">
                                        <h3>Lead Information</h3>
                                        <form action="/leads/{{$lead->id}}" method="POST">
                                             @csrf
                                             @method("PUT")

                                             <div class="row">
                                                  <div class="col-md-3 mb-3">
                                                       <label for="firstname">First Name <span class="text-danger">*</span></label>
                                                       <input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" placeholder="Enter First name" value="{{$lead->firstname}}"/>
                                                  </div>

                                                  <div class="col-md-3 mb-3">
                                                       <label for="lastname">Last Name <span class="text-danger">*</span></label>
                                                       <input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" placeholder="Enter Last Name" value="{{$lead->lastname}}"/>
                                                  </div>

                                                  <div class="col-md-3 form-group mb-3">
                                                       <label for="gender_id">Gender <span class="text-danger">*</span></label>
                                                       <select name="gender_id" id="gender_id" class="form-control form-control-sm rounded-0">
                                                            <option value="" disabled>Choose a gender</option>
                                                            @foreach($genders as $gender)
                                                                 {{--  <option value="{{$gender['id']}}" {{ $gender['id'] == $lead->gender_id ? 'selected' : '' }}>{{$gender['name']}}</option> --}}
                                                                 <option value="{{$gender['id']}}" {{ $gender['id'] == old('gender_id',$lead->gender_id) ? 'selected' : '' }}>{{$gender['name']}}</option>
                                                            @endforeach     
                                                       </select>
                                                  </div>

                                                  
                                                  <div class="col-md-3 mb-3">
                                                       <label for="age">Age <span class="text-danger">*</span></label>
                                                       <input type="number" name="age" id="age" class="form-control form-control-sm rounded-0" placeholder="Enter Your Age" value="{{ old('age',$lead->age)}}"/>
                                                  </div>

                                                  <div class="col-md-3 mb-3">
                                                       <label for="email">Email <span class="text-danger">*</span></label>
                                                       <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" placeholder="Enter Your Email" value="{{ old('email',$lead->email)}}" readonly/>
                                                  </div>

                                                  <div class="col-md-3 form-group mb-3">
                                                       <label for="country_id">Country</label>
                                                       <select name="country_id" id="country_id" class="form-control form-control-sm rounded-0 country_id">
                                                            <option value="" disabled>Choose a country</option>
                                                            @foreach($countries as $country)
                                                                 <option value="{{$country['id']}}" {{ $country['id'] === $lead->country_id ? 'selected' : '' }}>{{$country['name']}}</option>
                                                            @endforeach     
                                                       </select>
                                                  </div>
                                                  <div class="col-md-3 form-group mb-3">
                                                       <label for="city_id">City</label>
                                                       <select name="city_id" id="city_id" class="form-control form-control-sm rounded-0 city_id">
                                                            <option value="" disabled>Choose a city</option>
                                                            @foreach($cities as $city)
                                                                 <option value="{{$city['id']}}" {{ $city['id'] === $lead->city_id ? 'selected' : '' }}>{{$city['name']}}</option>
                                                            @endforeach  
                                                       </select>
                                                  </div>

                                                  @if($lead->isconverted())
                                                       <small>this lead have already been converted to a student. Editing is disabled.</small>
                                                  @endif

                                                  <div class="col-md-12">
                                                       <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary btn-sm rounded-0" {{$lead->isconverted() ? 'disabled' : ''}}>Update</button>
                                                       </div>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>

                                   <div id="studenttab" class="tab-pane">
                                        <h3>Student Information</h3>

                                        <form action="/students" method="POST">
                                             @csrf

                                             <div class="row">
                                                  <div class="col-md-3 mb-3">
                                                       <label for="firstname">First Name <span class="text-danger">*</span></label>
                                                       <input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" placeholder="Enter First name" value="{{ old('firstname') }}"/>
                                                       @error("firstname")
                                                            <span class="text-danger">{{ $message }}<span>
                                                       @enderror
                                                  </div>

                                                  <div class="col-md-3 mb-3">
                                                       <label for="lastname">Last Name <span class="text-danger">*</span></label>
                                                       <input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" placeholder="Enter Last Name" value="{{ old('lastname')}}"/>
                                                       @error("lastname")
                                                            <span class="text-danger">{{ $message }}<span>
                                                       @enderror
                                                  </div>


                                                  <div id="multiphone" class="col-md-3 form-group mb-3 createpage">
                                                       <label for="phone">Phone<span class="text-danger">*</span></label>
                                                       <div class="input-group phonelimit">
                                                            <input type="text" name="phone[]" id="phone" class="form-control form-control-sm rounded-0 phone" placeholder="Enter Mobile Number" value="{{ old('lastname')}}"/>
                                                            <span id="addphone" class="input-group-text" style="font-size:10px; cursor:pointer;"><i class="fas fa-plus-circle"></i></span>
                                                       </div>
                                                  </div>

                                                  {{-- <div class="col-md-4 mb-3">
                                                       <label for="regnumber">Register Number <span class="text-danger">*</span></label>
                                                       <input type="text" name="regnumber" id="regnumber" class="form-control form-control-sm rounded-0" placeholder="Enter Register Number" autocomplete="off" value="{{ old('regnumber')}}"/>
                                                       @error("regnumber")
                                                            <span class="text-danger">{{ $message }}<span>
                                                       @enderror
                                                  </div>

                                                  --}}

                                                  <div class="col-md-12 mb-3">
                                                       <label for="remark">Remark</label>
                                                       <textarea name="remark" id="remark" class="form-control rounded-0" rows="5" placeholder="Enter Remark">{{ old('remark')}}</textarea>
                                                       @error("remark")
                                                            <span class="text-danger">{{ $message }}<span>
                                                       @enderror
                                                  </div>

                                                  <div class="col-md-12">
                                                       <div class="d-flex justify-content-end">
                                                            <a href="{{route('students.index')}}" class="btn btn-secondary btn-sm rounded-0 me-3">Cancel</a>
                                                       <button type="submit" class="btn btn-secondary btn-sm rounded-0">Submit</button>
                                                       </div>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>

                                   <div id="signintab" class="tab-pane">
                                        <h6>Sign-In Password</h6>
                                        <div class="col-md-4 mx-auto">
                                            <form class="mt-3" action="{{ route('password.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group mb-3">
                                                    <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Old Password" value="{{ old('current_password') }}"/>
                                                    @error('current_password')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                
                                                <div class="form-group mb-3">
                                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="New Password" value="{{ old('password') }}"/>
                                                    @error('password')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group mb-3">
                                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" value="{{ old('password_confirmation') }}"/>
                                                    @error('password_confirmation')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            
                                                <div class="float-end mb-3">
                                                    <button type="submit" class="btn btn-info btn-sm rounded-0">Save Change</button>
                                                </div>
                                            </form>
                                        </div>
                                        

                                   </div>

                                   <div id="logtab" class="tab-pane">
                                        <h3>This is Contact Information</h3>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                   </div>

                              </div>
                         </div>
                    </div>

               </div>
          

          </div>
     </div>
     <!-- End Page Content Area -->
@endsection

@section("css")
     <style type="text/css">
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


          $(document).ready(function(){
               // Start Dynamic Select Option 
               $(document).on("change",".country_id",function(){
                    const getcountryid = $(this).val();
                    // console.log(getcountryid);

                    let opforcity = "";
                    $.ajax({
                         url: `/api/filter/cities/${getcountryid}`,
                         type: "GET",
                         dataType:"json",
                         success:function(response){
                              $(".city_id").empty();
                              opforcity += "<option selected disabled>Choose a city abcd</option>";
                              
                              console.log(response);
                              for(let x=0 ; x<response.data.length; x++){
                                   opforcity += `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                              }

                              $(".city_id").append(opforcity);
                         },
                         error:function(response){
                              console.log("Error:( ",response);
                         }
                    });
               });
               // End Dynamic Select Option
          });
     </script>


@endsection




{{--  <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
