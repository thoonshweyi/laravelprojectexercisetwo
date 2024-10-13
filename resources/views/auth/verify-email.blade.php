@include("layouts.adminheader")
<div id="app">
    <div class="d-flex vh-100 justify-content-center align-items-center">
        <div class="col-md-3 bg-white p-4">
            <h5>Email Verification</h5>

            <div class="row">
                <div>
                    <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <small class="text-primary text-sm mb-4">
                    A new verification link has been sent to the email address you provided during registration.'
                    </small>
                @endif

                <form class="mt-3" action="{{ route('verification.send') }}" method="POST" >
                    @csrf

                    <div class="d-grid">
                        <button type="submit" class="btn btn-info rounded-0">Resend Verification Email</button>
                    </div>
                </form>

                <div class="text-center mt-2">
                    <small>Don't have an action ?</small>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="small">Sign Out</a>
                    </form>
                </div>

            </div>
            

        </div>
    </div>
</div>
@include("layouts.adminfooter")
