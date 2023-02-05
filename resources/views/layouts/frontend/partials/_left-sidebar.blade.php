<div class="sidebar">
    <div class="left-sidebar">
        <ul class="list-group mt20 sidebar-items">
            <li class="list-group-item">
                <a href="{{route('frontend.tweets.index')}}" class="sidebar-item left-sidebar-item">
                    <i class="bi bi-house-door"></i>
                </a>
            </li>
            <li class="list-group-item">
                @auth
                    <a href="{{route('frontend.users.show', auth()->id())}}" class="sidebar-item">
                        <i class="bi bi-person-circle"></i>
                    </a>
                @else
                    <a href="{{route('login')}}" class="sidebar-item">
                        <i class="bi bi-person-circle"></i>
                    </a>
                @endauth
            </li>
            <li class="list-group-item">
                <a href="{{route('frontend.tweets.index')}}" class="sidebar-item">
                    <i class="bi bi-tweet-circle"></i>
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{route('frontend.tags.index')}}" class="sidebar-item">
                    <i class="bi bi-tags"></i>
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{route('frontend.users.index')}}" class="sidebar-item">
                    <i class="bi bi-people"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="left-sidebar-hover">
        <ul class="list-group mt20 sidebar-items">
            <li class="list-group-item">
                <a href="{{route('frontend.tweets.index')}}" class="sidebar-item">
                    Home
                </a>
            </li>
            <li class="list-group-item">
                @auth
                    <a href="{{route('frontend.users.show', auth()->id())}}" class="sidebar-item">
                        Profile
                    </a>
                @else
                    <a href="{{route('login')}}" class="sidebar-item">
                        Profile
                    </a>
                @endauth
            </li>
            <li class="list-group-item dropdown">
                <a href="" class="sidebar-item" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tweets
                </a>
                {{-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="{{route('frontend.tweets.index')}}">Recent Tweets</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('frontend.tweets.index')}}">Popular Tweets</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('frontend.tweets.index')}}">Hot Tweets</a>
                    </li>
                </ul> --}}
            </li>
            <li class="list-group-item">
                <a href="{{route('frontend.tags.index')}}" class="sidebar-item">
                    Tags
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{route('frontend.users.index')}}" class="sidebar-item">
                    Users
                </a>
            </li>
        </ul>
    </div>
</div>





