@include("layouts.adminheader")
<div id="app">
    <div class="d-flex vh-100 justify-content-center align-items-center">
        <div class="col-3 bg-white p-4">
            <h6>New Password !</h6>

            <div class="row">

                <form class="mt-3" action="{{ route('password.store') }}" method="POST">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                
                    <div class="form-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email') }}"/>
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
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" value="{{ old('password_confirmation') }}"/>
                        @error('password_confirmation')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info rounded-0">Reset Password</button>
                    </div>
                </form>

            </div>
        
        </div>
    </div>
</div>
@include("layouts.adminfooter")


