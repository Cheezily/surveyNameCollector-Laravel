<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">

      <!-- Collapsed Hamburger -->
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <!-- Branding Image -->
      <a class="navbar-brand" href="{{ url('/') }}">
          @if(empty($option_page) && empty($participant))
            Survey Dashboard
          @else
            {{ $survey->name }}
          @endif
      </a>
    </div>

    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <!-- Left Side Of Navbar -->
      <ul class="nav navbar-nav">
        &nbsp;
      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @if(empty($participant))
          @if (Auth::guest())
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
          @else
            @if(!empty($option_page))
              <a href="{{ url('/', ['home']) }}">
                <button class="btn btn-default btn-primary logoutButton">
                  Back to Dashboard
                </button>
              </a>
            @endif
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
              <button class="btn btn-default logoutButton">
                Logout
              </button>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          @endif
        @endif
      </ul>
    </div>
  </div>
</nav>