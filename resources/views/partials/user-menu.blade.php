<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">logged as {{ auth()->user()->email }} <span class="caret"></span></a>
    <ul class="dropdown-menu">
<<<<<<< HEAD
        <li><a href="{{ action('LoginController@showDashBoard') }}">Dashboard</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ action('LoginController@logout') }}">Sign out</a></li>
    </ul>
</li>
=======
        <li><a href="{{ action('HomeController@index') }}">Dashboard</a></li>
        <li role="separator" class="divider"></li>
        <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
    </ul>
</li>
>>>>>>> Reset
