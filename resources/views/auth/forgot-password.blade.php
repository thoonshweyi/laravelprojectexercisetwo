@include("layouts.adminheader")
<div id="app">
    <div class="d-flex vh-100 justify-content-center align-items-center">
        <div class="col-3 bg-white p-4">
            <h6>Forgot Password !</h6>

            <div class="row">
                <div>
                    <p>Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                </div>

                @if (session('status'))
                    <small class="text-primary text-sm mb-4">
                    A new verification link has been sent to the email address you provided during registration.'
                    </small>
                @endif

                <form class="mt-3" action="{{ route('password.email') }}" method="POST">
                    @csrf

                
                    <div class="form-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email') }}"/>
                        @error('email')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info rounded-0">Email Password Reset Link</button>
                    </div>
                </form>

            </div>
        
        </div>
    </div>
</div>
@include("layouts.adminfooter")


