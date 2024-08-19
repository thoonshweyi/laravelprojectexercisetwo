@extends("layouts.adminindex")

@section("caption","Region List")
@section("content")
                         
     <!-- Start Page Content Area -->
     <div class="container-fluid">

          <div class="col-md-12">
               <form action="{{route('townships.store')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="row align-items-end">
                         <div class="col-md-2 form-group mb-3">
                              <label for="country_id">Country</label>
                              <select name="country_id" id="country_id" class="form-control form-control-sm rounded-0 country_id">
                                   <option value="" selected disabled>Choose a country</option>
                                   @foreach($countries as $country)
                                        <option value="{{$country['id']}}">{{$country['name']}}</option>
                                   @endforeach     
                              </select>
                         </div>
                         <div class="col-md-2 form-group mb-3">
                              <label for="city_id">City</label>
                              <select name="city_id" id="city_id" class="form-control form-control-sm rounded-0 city_id">
                                   <option value="" selected disabled>Choose a city</option>
                                   {{-- @foreach($cities as $city)
                                        <option value="{{$city['id']}}">{{$city['name']}}</option>
                                   @endforeach --}}     
                              </select>
                         </div>
                         <div class="col-md-2 form-group mb-3">
                              <label for="region_id">Region</label>
                              <select name="region_id" id="region_id" class="form-control form-control-sm rounded-0 region_id">
                                   <option value="" selected disabled>Choose a region</option>
                                   {{-- @foreach($regions as $region)
                                        <option value="{{$region['id']}}">{{$region['name']}}</option>
                                   @endforeach --}}     
                              </select>
                         </div>
                         <div class="col-md-2 form-group mb-3">
                              <label for="name">Township Name <span class="text-danger">*</span></label>
                              @error("name")
                                   <span class="text-danger">{{ $message }}<span>
                              @enderror
                              <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter Country Name" value="{{ old('name') }}"/>
                         </div>

                         <div class="col-md-2 form-group mb-3">
                              <label for="status_id">Status</label>
                              <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                                   @foreach($statuses as $status)
                                        <option value="{{$status['id']}}">{{$status['name']}}</option>
                                   @endforeach     
                              </select>
                         </div>

                         <div class="col-md-2 mb-3 text-sm-end text-md-start">
                              <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                              <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                         </div>
                    </div>
               </form>
          </div>

          <hr/>

          <div class="col-md-12">
               <div>
                    <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a>
               </div>
               <form action="" method="">
                    <div class="row justify-content-end">
                         <div class="col-md-2 col-sm-6 mb-2">
                              <div class="input-group">
                                   <input type="text" name="filtername" id="filtername" class="form-control form-control-sm rounded-0" placeholder="Search...."/>
                                   <button type="submit" id="btn-search" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                              </div>
                         </div>
                    </div>
               </form>
          </div>
     
          <div class="col-md-12">

               <table id="mytable" class="table table-sm table-hover border">
          
                    <thead>
                         <th>
                              <input type="checkbox" name="selectalls" id="selectalls" class="form-check-input selectalls" />
                         </th>
                         <th>No</th>
                         <th>Name</th>
                         <th>Region</th>
                         <th>City</th>
                         <th>Country</th>
                         <th>Status</th>
                         <th>By</th>
                         <th>Created At</th>
                         <th>Updated At</th>
                         <th>Action</th>
                    </thead>
          
                    <tbody>
                         @foreach($townships as $idx=>$township)
                         <tr id="tablerole_{{$township->id}}">
                              <td>
                                   <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$township->id}}"/>
                              </td>
                              <td>{{++$idx}}</td>
                              <td>{{ $township->name }}</td>
                              <td>{{ $township->region["name"] }}</td>
                              <td>{{ $township->city["name"] }}</td>
                              <td>{{ $township->country["name"] }}</td>
                              
                              <td>
                                   <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input change-btn" {{ $township->status_id === 3 ? "checked" : "" }} data-id="{{ $township->id }}"/>
                                   </div>
                              </td>
                              <td>{{ $township->user["name"] }}</td>
                              <td>{{ $township->created_at->format('d M Y') }}</td>
                              <td>{{ $township->updated_at->format('d M Y') }}</td>
                              <td>
                                   <a href="javascript:void(0);" class="text-info editform" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="{{$township->id}}" data-name="{{$township->name}}" data-country="{{ $township->country_id }}" data-city="{{ $township->city_id }}" data-region="{{ $township->region_id }}" data-status="{{ $township->status_id }}"><i class="fas fa-pen"></i></a>
                                   <a href="#" class="text-danger ms-2 delete-btns" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                              
                              </td>
                              <form id="formdelete-{{ $idx }}" class="" action="{{route('townships.destroy',$township->id)}}" method="POST">
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

     <!-- START MODAL AREA -->
          <!-- start edit modal -->
               <div id="editmodal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                              <div class="modal-header">
                                   <h6 class="modal-title">Edit Form</h6>
                                   <button type="" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <div class="modal-body">
                                   <form id="formaction" action="" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="row align-items-end">
                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editcountry_id">Country</label>
                                                  <select name="editcountry_id" id="editcountry_id" class="form-control form-control-sm rounded-0 country_id">
                                                       @foreach($countries as $country)
                                                            <option value="{{$country['id']}}">{{$country['name']}}</option>
                                                       @endforeach    
                                                  </select>
                                             </div>

                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editcity_id">City</label>
                                                  <select name="editcity_id" id="editcity_id" class="form-control form-control-sm rounded-0 city_id">
                                                       {{-- @foreach($cities as $city)
                                                            <option value="{{$city['id']}}">{{$city['name']}}</option>
                                                       @endforeach --}}     
                                                  </select>
                                             </div>

                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editregion_id">Region</label>
                                                  <select name="editregion_id" id="editregion_id" class="form-control form-control-sm rounded-0 region_id">
                                                       {{-- @foreach($regions as $region)
                                                            <option value="{{$region['id']}}">{{$region['name']}}</option>
                                                       @endforeach --}}     
                                                  </select>
                                             </div>

                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editname">Name <span class="text-danger">*</span></label>
                                                  <input type="text" name="editname" id="editname" class="form-control form-control-sm rounded-0" placeholder="Enter township Name" value="{{ old('name') }}"/>
                                             </div>

                                             <div class="col-md-6 form-group mb-3">
                                                  <label for="editstatus_id">Status</label>
                                                  <select name="editstatus_id" id="editstatus_id" class="form-control form-control-sm rounded-0">
                                                       @foreach($statuses as $status)
                                                            <option value="{{$status['id']}}">{{$status['name']}}</option>
                                                       @endforeach     
                                                  </select>
                                             </div>
                    
                                             <div class="col-md-12 text-sm-end text-start mb-3">
                                                  <button type="submit" class="btn btn-primary btn-sm rounded-0">Update</button>
                                             </div>
                                        </div>
                                   </form>
                              </div>

                              <div class="modal-footer">

                              </div>
                         </div>
                    </div>
               </div>
          <!-- end edit modal -->
     <!-- END MODAL AREA -->
@endsection


@section("scripts")
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script type="text/javascript">

          $(document).ready(function(){

               // Start Dynamic Select Option 
               $(document).on("change",".country_id",function(){
                    const getcountryid = $(this).val();
                    // console.log(getcountryid);

                    let opforcity = "";
                    let opforregion = "";
                    $.ajax({
                         url: `/api/filter/cities/${getcountryid}`,
                         type: "GET",
                         dataType:"json",
                         success:function(response){
                              $(".city_id").empty();
                              $(".region_id").empty();
                              opforcity += "<option selected disabled>Choose a city ....</option>";
                              opforregion += "<option selected disabled>Choose a region ....</option>";
                              
                              console.log(response);
                              for(let x=0 ; x<response.data.length; x++){
                                   opforcity += `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                              }

                              $(".city_id").append(opforcity);
                              $(".region_id").append(opforregion);
                         },
                         error:function(response){
                              console.log("Error:( ",response);
                         }
                    });
               });
               $(document).on("change",".city_id",function(){
                    const getcityid = $(this).val();
                    // console.log(getcityid);

                    let opforregion = "";
                    $.ajax({
                         url: `/api/filter/regions/${getcityid}`,
                         type: "GET",
                         dataType:"json",
                         success:function(response){
                              // console.log(response);
                              $(".region_id").empty();
                              opforregion += "<option selected disabled>Choose a region ....</option>";
                              
                              console.log(response);
                              for(let y=0 ; y<response.data.length; y++){
                                   opforregion += `<option value="${response.data[y].id}">${response.data[y].name}</option>`;
                              }

                              $(".region_id").append(opforregion);
                         },
                         error:function(response){
                              console.log("Error:( ",response);
                              // console.log("Error:( ",response.responseText);
                         }
                    });
               });
               // End Dynamic Select Option



               // Start Delete Item
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
               // End Delete Item

               // Start Edit Form
               $(document).on("click",".editform",async function(e){
                    const getcountryid = $(this).attr("data-country");
                    // console.log(getcountryid);
                    let opforcity = "";

                    await $.ajax({
                         url: `/api/filter/cities/${getcountryid}`,
                         type: "GET",
                         dataType:"json",
                         success:function(response){
                              console.log(response);
                              $(".city_id").empty();
                              opforcity += "<option selected disabled>Choose a city abcd</option>";
                              
                              console.log(response);
                              for(let x=0 ; x<response.data.length; x++){
                                   opforcity += `<option value="${response.data[x].id}">${response.data[x].name}</option>`;
                              }

                              $(".city_id").append(opforcity);

                              // console.log(e.target.parentElement);
                              // $("#editcity_id").val($(e.target.parentElement).attr("data-city"));

                         },
                         error:function(response){
                              console.log("Error:( ",response);
                         }
                    });

                    const getcityid = $(this).attr("data-city");
                    let opforregion = "";
                    await $.ajax({
                         url: `/api/filter/regions/${getcityid}`,
                         type: "GET",
                         dataType:"json",
                         success:function(response){
                              // console.log(response);
                              $(".region_id").empty();
                              opforregion += "<option selected disabled>Choose a region ....</option>";
                              
                              console.log(response);
                              for(let y=0 ; y<response.data.length; y++){
                                   opforregion += `<option value="${response.data[y].id}">${response.data[y].name}</option>`;
                              }

                              $(".region_id").append(opforregion);

                              // $("#editregion_id").val($(e.target.parentElement).attr("data-region"));
                         },
                         error:function(response){
                              console.log("Error:( ",response);
                              // console.log("Error:( ",response.responseText);
                         }
                    });




                    // console.log($(this).attr("data-id"),$(this).attr("data-name"));
                    
                    $("#editname").val($(this).attr("data-name"));
                    $("#editcountry_id").val($(this).attr("data-country"));
                    $("#editcity_id").val($(this).attr("data-city"));
                    $("#editregion_id").val($(this).attr("data-region"));
                    $("#editstatus_id").val($(this).attr("data-status"));

                    const getid = $(this).attr("data-id");
                    $("#formaction").attr("action",`/townships/${getid}`);

                    e.preventDefault();
               });
               // End Edit Form

               // Start Bulk Delete 
               $("#selectalls").click(function(){
                    $(".singlechecks").prop("checked",$(this).prop("checked"));
               });

               $("#bulkdelete-btn").click(function(){
                    let getselectedids = [];
                    
                    console.log($("input:checkbox[name=singlechecks]:checked"));
                    $("input:checkbox[name='singlechecks']:checked").each(function(){
                         getselectedids.push($(this).val());
                    });
                    
                    
                    // console.log(getselectedids); // (4) ['1', '2', '3', '4']
          


                    Swal.fire({
                         title: "Are you sure?",
                         text: `You won't be able to revert!`,
                         icon: "warning",
                         showCancelButton: true,
                         confirmButtonColor: "#3085d6",
                         cancelButtonColor: "#d33",
                         confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                         if (result.isConfirmed) {
                              // data remove 
                              $.ajax({
                                   url:"{{ route('townships.bulkdeletes') }}",
                                   type:"DELETE",
                                   dataType:"json",
                                   data:{
                                        selectedids:getselectedids,
                                        _token:"{{ csrf_token() }}"
                                   },
                                   success:function(response){
                                        console.log(response);   // 1
                                        
                                        if(response){
                                             // ui remove
                                             $.each(getselectedids,function(key,val){
                                                  $(`#tablerole_${val}`).remove();
                                             });
                                        
                                             Swal.fire({
                                                  title: "Deleted!",
                                                  text: "Your file has been deleted.",
                                                  icon: "success"
                                             });
                                        }
                                   },
                                   error:function(response){
                                        console.log("Error: ",response)
                                   }
                              });
                              
                         }
                    });   
               });
               // End Bulk Delete 

               //Start change-btn
               $(document).on("change",".change-btn",function(){

                    var getid = $(this).data("id");
                    // console.log(getid); // 1 2

                    var setstatus = $(this).prop("checked") === true ? 3 : 4;
                    // console.log(setstatus); // 3 4

                    $.ajax({
                         url:"townshipsstatus",
                         type:"GET",
                         dataType:"json",
                         data:{"id":getid,"status_id":setstatus},
                         success:function(response){
                              console.log(response); // {success: 'Status Change Successfully'}
                              console.log(response.success); // Status Change Successfully
                         
                              Swal.fire({
                                   title: "Updated!",
                                   text: "Updated Successfully",
                                   icon: "success"
                              });
                         }
                    });
               });
               // End change btn
          });


          


     </script>
@endsection