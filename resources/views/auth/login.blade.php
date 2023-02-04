@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-box-sm">
            <div class="login-card">
                <div class="row">
                    <div class="col-md-6">
                        <div class="sign-in-form text-center ">
                            <h2 class="form-heading">Sign In</h2>
                            <form action="{{route('login')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="email"
                                               placeholder="Enter Email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{old('email')}}"
                                               required
                                               autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="password"
                                               placeholder="Enter Password"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="password"
                                               required
                                               autocomplete="current-password"
                                               >
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember"
                                                   {{old('remember') ? 'checked' : ''}}> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="">Forgot your password?</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" value="SIGN IN" class="submit-btn btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>

                <div class="overlay-container" id="overlay-sign-up">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overlay">
                                <div class="overlay-content text-center">
                                    <h2 class="overlay-heading">New to CaffeineOverflow?</h2>
                                    <p class="overlay-desc">Enter personal details and sign up here!</p>
                                    <a href="{{route('register')}}" class="overlay-btn" id="overlay-sign-up-btn">SIGN UP</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-level-scripts')
    <script>
        $('#overlay-sign-up-btn').click(function (e) {
            e.preventDefault();
            $('.overlay-container').animate({
                right: "50%"
            }, "slow");
            setTimeout(function(){
                location.href="{{route('register')}}";
            }, 1100);
        });
    </script>
@endsection
