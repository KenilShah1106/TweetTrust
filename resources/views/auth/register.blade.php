@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-box-sm">
            <div class="signup-card">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="sign-up-form text-center ">
                            <h2 class="form-heading">Create Account</h2>
                            <form action="{{route('register')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="name"
                                               placeholder="Enter Name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{old('name')}}"
                                               required
                                               autocomplete="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
                                               autocomplete="new-password"
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
                                        <input type="password"
                                               placeholder="Confirm Password"
                                               class="form-control"
                                               name="password_confirmation"
                                               required
                                               autocomplete="new-password"
                                               >
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
                                        <input type="submit" value="SIGN UP" class="submit-btn btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="overlay-container" id="overlay-sign-in">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overlay">
                                <div class="overlay-content text-center">
                                    <h2 class="overlay-heading">Already have an Account?</h2>
                                    <p class="overlay-desc">Enter personal details and sign in here!</p>
                                    <a href="{{route('login')}}" class="overlay-btn" id="overlay-sign-in-btn">SIGN IN</a>
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
        $('#overlay-sign-in-btn').click(function (e) {
            e.preventDefault();
            $('.overlay-container').animate({
                left: "50%"
            }, "slow");
            setTimeout(function(){
                location.href="{{route('login')}}";
            }, 1100);
        });
    </script>
@endsection
