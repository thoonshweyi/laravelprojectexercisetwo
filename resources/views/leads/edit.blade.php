@extends("layouts.adminindex")

@section("caption","Edit Student")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">
          <div class="col-md-12">
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
                              <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" placeholder="Enter Your Email" value="{{ old('email',$lead->email)}}"/>
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
                                   <a href="{{route('leads.index')}}" class="btn btn-secondary btn-sm rounded-0 me-3">Cancel</a>
                                   <button type="submit" class="btn btn-secondary btn-sm rounded-0" {{$lead->isconverted() ? 'disabled' : ''}}>Update</button>
                              </div>
                         </div>
                    </div>
               </form>
              
          </div>
     </div>
     <!-- End Page Content Area -->
@endsection


@section("scripts")
     <script type="text/javascript">
           
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