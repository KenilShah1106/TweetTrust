<header id="header" class="sticky-top">
    <nav class="navbar navbar-light bg-white p-0">
        <div class="container-fluid px-0">
            <div class="row">
                <div class="col-12 d-flex align-items-center justify-content-between p-0">
                    <div class="col-3 header-left">
                        <a href="{{route('frontend.tweets.index')}}" class="project-title m-0">TweetTrust</a>
                    </div>
                    <div class="col-9 header-right">
                        <div class="row d-flex align-items-center">
                            <div class="col-3">
                                <ul class="navbar-nav flex-row">
                                </ul>
                            </div>
                            <div class="col-7">
                                <form action="" class="input-group d-flex search-field">
                                    <input type="text"
                                            name="search"
                                            value="{{ request('search')}}"
                                            class="form-control"
                                            placeholder="Search ....">
                                    <div class="input-group-append">
                                        <button type="submit" name="submit" class="btn bg-white">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @auth
                                <div class="col-1 text-center notification">
                                    <a href="{{route('frontend.users.notifications')}}" class="btn btn-light rounded-circle notification">
                                        <i class="bi bi-bell notification-icon"></i>
                                        @php
                                            $notificationCount = auth()->user()->unreadNotifications()->count()
                                        @endphp
                                        @if($notificationCount > 0)
                                            <span class="badge-top rounded-circle">{{$notificationCount}}</span>
                                        @endif
                                    </a>
                                </div>
                                <div class="col-1">
                                    <div class="profile-container">
                                        <div class="dropdown">
                                            <div class="profile">
                                                <button class="btn m-0 p-0 dropdown-toggle profile-img" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{asset(auth()->user()->avatar)}}" alt="">
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="{{route('frontend.users.show',auth()->id())}}" class="dropdown-item">View Profile</a>
                                                    <a href="{{route('frontend.users.edit',auth()->id())}}" class="dropdown-item">Edit Profile</a>
                                                    <form action="{{route('logout')}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="col-1">
                                <a href="{{route('login')}}" class="btn btn-primary">Login</a>
                            </div>
                            <div class="col-1">
                                <a href="{{route('register')}}" class="btn btn-outline-primary">Signup</a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
