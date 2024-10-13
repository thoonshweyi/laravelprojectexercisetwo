@include("layouts.adminheader")
<div id="app">
    <div class="d-flex justify-content-center align-items-center">
        <div class="bg-white p-4">
            <h5>Register</h5>

            <form class="mt-3" action="{{ route('register') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <input type="firstname" name="firstname" class="form-control @error('firstname') is-invalid @enderror" placeholder="First Name" autofocus value="{{ old('firstname') }}"/>
                    @error('firstname')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <input type="lastname" name="lastname" class="form-control @error('lastname') is-invalid @enderror" placeholder="Last Name" autofocus value="{{ old('lastname') }}"/>
                    @error('lastname')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" autofocus value="{{ old('email') }}"/>
                    @error('email')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password') }}"/>
                    @error('password')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password-confirmation" class="form-control @error('password-confirmation') is-invalid @enderror" placeholder="Confirm Password" value="{{ old('password-confirmation') }}"/>
                    @error('password-confirmation')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="gender_id">Gender <span class="text-danger">*</span></label>
                    <select name="gender_id" id="gender_id" class="form-control  rounded-0">
                        <option value="" selected disabled>Choose a gender</option>
                        @foreach($genders as $gender)
                            <option value="{{$gender['id']}}">{{$gender['name']}}</option>
                        @endforeach     
                    </select>
                </div>
                <div class="mb-3">
                    <label for="age">Age <span class="text-danger">*</span></label>
                    <input type="number" name="age" id="age" class="form-control rounded-0" placeholder="Enter Your Age" value="{{ old('age')}}"/>
                </div>
                <div class="form-group mb-3">
                    <label for="country_id">Country</label>
                    <select name="country_id" id="country_id" class="form-control rounded-0 country_id">
                        <option value="" selected disabled>Choose a country</option>
                        @foreach($countries as $country)
                            <option value="{{$country['id']}}">{{$country['name']}}</option>
                        @endforeach     
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="city_id">City</label>
                    <select name="city_id" id="city_id" class="form-control rounded-0 city_id">
                        <option value="" selected disabled>Choose a city</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-info rounded-0">Sign Up</button>
                </div>
            </form>

            <!-- social login -->
             <div class="row">
                <small class="text-center text-muted mt-3">Sign up with</small>
                <div class="col-12 mt-2 text-center">
                    <a href="javascript:void(0);" class="btn" title="Login with Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="javascript:void(0);" class="btn" title="Login with Google"><i class="fab fa-google"></i></a>
                    <a href="javascript:void(0);" class="btn" title="Login with Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="javascript:void(0);" class="btn" title="Login with Github"><i class="fab fa-github"></i></a>
                </div>
             </div>

             <!-- register -->
             <div class="row">
                <div class="col-12 mt-2 text-center">
                    <small>Already have an account?  <a href="{{ route('login') }}" class="text-primary ms-1">Sign In</a></small>
                </div>
             </div>

             <!-- data policy -->
             <div class="row">
                <div class="col-12 mt-2 text-center text-muted">
                    <small>By clicking Sign Up, you agree to our  <a href="javascript:void(0);" class="text-primary fw-bold">Terms</a>, <a href="javascript:void(0);" class="text-primary fw-bold">Data Policy</a> and <a href="javascript:void(0);" class="text-primary fw-bold">Cookie Policy</a>. You may receive SMS notification from us.</small>
                </div>
             </div>
        </div>
    </div>
</div>
@include("layouts.adminfooter")

@section("scripts")
     <script type="text/javascript">
          
          $(document).ready(function(){
               
          });
     </script>
@endsection