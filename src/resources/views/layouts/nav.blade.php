<div class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="{{url('/dashboard')}}">
                    <img src="{{asset('public/images/logo.png')}}" alt="logo" style="width: 210px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav ml-auto">
                        <li class="{{ Request::segments()[0]=== 'dashboard' ? 'nav-item active' : 'nav-item' }}"  >
                            <a class="nav-link" href="{{url('/dashboard')}}">{{trans('messages.Dashboard')}}</a>
                        </li>
                        @if(auth()->user()->role === 'admin')
                        <li class="{{ Request::segments()[0]=== 'dashboard-categories' ? 'nav-item active' : 'nav-item' }}">
                            <a class="nav-link" href="{{url('/dashboard-categories')}}">{{trans('messages.Dashboard Categories')}}</a>
                        </li>
                        <li class="{{ Request::segments()[0]=== 'users'  ? 'nav-item active' : 'nav-item' }}">
                            <a class="nav-link" href="{{url('/users')}}">{{trans('messages.Users')}}</a>
                        </li>
                        <li class="{{ Request::segments()[0]=== 'user-groups' ? 'nav-item active' : 'nav-item' }}">
                            <a class="nav-link" href="{{url('/user-groups')}}">{{trans('messages.User Groups')}}</a>
                        </li>
                        @endif
                        <li class="{{ Request::segments()[0]=== 'edit-account' ? 'nav-item active' : 'nav-item' }}">
                            <a class="nav-link" href="{{url('/edit-account')}}">{{trans('messages.Account')}}</a>
                        </li>
                        <li class="nav-item dropdown profile-dropdown {{ Request::segments()[0]=== 'change-password' ? 'active' : ' ' }}">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ucfirst(auth()->user()->firstname)}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <!-- <a class="dropdown-item" href="{{url('/change-password')}}">Change Password</a> -->
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
</div>