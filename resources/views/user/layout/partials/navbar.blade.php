<div id="main-menu">
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="{{route('user.home')}}">
        <img style="max-width: 200px;max-height: 50px;" src="{{asset('assets/user/interfaceControl/logoIcon/logo.jpg')}}" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link @if(request()->path()=='/') active @endif" href="{{route('user.home')}}">Home</a>
            </li>
            @guest
              <li class="nav-item">
                <a class="nav-link @if(request()->path()=='about') active @endif" href="{{route('user.about')}}">About</a>
              </li>
            @endguest
            <li class="nav-item">
              <a class="nav-link @if(request()->path()=='packages') active @endif" href="{{route('user.package.index')}}">Packages</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->path()=='hotels') active @endif" href="{{route('user.hotels')}}">Hotels</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle
              @if(request()->path()=='rentcar/index') active
              @elseif(request()->path()=='pickups/index') active
              @endif" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                Vehicles
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                <a class="dropdown-item" href="{{route('user.rentcar.index')}}">Rent</a>
                <a class="dropdown-item" href="{{route('user.pickup.index')}}">Pick up</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->path()=='lounges') active @endif" href="{{route('user.lounge.index')}}">Lounges</a>
            </li>
            @auth
              <li class="nav-item">
                <a class="nav-link @if(request()->path()=='user/depositMethods') active @endif" href="{{route('users.showDepositMethods')}}">Deposit</a>
              </li>
            @endauth

            @guest
              @php
                foreach ($menus as $menu) {
                  if(request()->path() == "user/$menu->slug/pages") {
                    $active = 'active';
                    break;
                  } else {
                    $active = '';
                  }
                }
              @endphp
               @if (count($menus) > 0)
                 <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle <?php echo $active ?>" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                     Pages
                   </a>
                   <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                     @foreach ($menus as $menu)
                       <a class="dropdown-item" href="{{route('user.dynamicPage', $menu->slug)}}">{{$menu->name}}</a>
                     @endforeach
                   </div>
                 </li>
               @endif

              <li class="nav-item">
                <a class="nav-link @if(request()->path()=='user/contact') active @endif" href="{{route('user.contact')}}">Contact</a>
              </li>
            @endguest
            @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle
                @if(request()->path()=='user/package/bookings') active
                @elseif(request()->path()=='user/room/bookings') active
                @elseif(request()->path()=='user/pickup/bookings') active
                @elseif(request()->path()=='user/rentcar/bookings') active
                @elseif(request()->path()=='user/lounge/bookings') active
                @endif" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  Bookings
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                  <a class="dropdown-item" href="{{route('user.booking.package')}}">Package Bookings</a>
                  <a class="dropdown-item" href="{{route('user.booking.room')}}">Room Booking</a>
                  <a class="dropdown-item" href="{{route('user.booking.pickup')}}">Pickup Car Booking</a>
                  <a class="dropdown-item" href="{{route('user.booking.rentcar')}}">Rent Car Booking</a>
                  <a class="dropdown-item" href="{{route('user.booking.lounge')}}">Lounge Booking</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle
                @if(request()->path()=='user/edit-profile') active
                @elseif(request()->path()=='user/change-password') active
                @elseif(request()->path()=='user/transactions') active
                @endif" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  {{Auth::user()->username}}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                  <a class="dropdown-item" href="{{route('users.editprofile')}}">Edit Profile</a>
                  <a class="dropdown-item" href="{{route('users.editPassword')}}">Change Password</a>
                  <a class="dropdown-item" href="{{route('user.trxLog')}}">Balance: {{$gs->base_curr_symbol}} {{Auth::user()->balance}}</a>
                  <a class="dropdown-item" href="{{route('user.logout')}}">Logout</a>
                </div>
              </li>
            @endauth
            @guest
              <li class="nav-item">
                <a class="nav-link @if(request()->path()=='user/showLoginForm') active @endif" href="{{route('user.showLoginForm')}}">Login</a>
              </li>
            @endguest
          </ul>


      </div>
    </div>
  </nav>
</div>

<!-- =========== nav end =========== -->
