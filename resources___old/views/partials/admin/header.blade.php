<header class="navbar navbar-default">
    <!-- Left Header Navigation -->
    <ul class="nav navbar-nav-custom">
        <!-- Main Sidebar Toggle Button -->
        <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-bars fa-fw"></i>
            </a>
        </li>

        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <i class="gi gi-settings"></i>
            </a>
            <ul class="dropdown-menu dropdown-custom dropdown-options">
                <li class="dropdown-header text-center">Header Style</li>
                <li>
                    <div class="btn-group btn-group-justified btn-group-sm">
                        <a href="javascript:void(0)" class="btn btn-primary" id="options-header-default">Light</a>
                        <a href="javascript:void(0)" class="btn btn-primary" id="options-header-inverse">Dark</a>
                    </div>
                </li>
                <li class="dropdown-header text-center">Page Style</li>
                <li>
                    <div class="btn-group btn-group-justified btn-group-sm">
                        <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style">Default</a>
                        <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style-alt">Alternative</a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- END Template Options -->
    </ul>

    <form action="page_ready_search_results.html" method="post" class="navbar-form-custom">
        <div class="form-group">
            <input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search..">
        </div>
    </form>
    <!-- END Search Form -->

    <!-- Right Header Navigation -->
    <ul class="nav navbar-nav-custom pull-right">
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset("img/placeholders/avatars/avatar2.jpg") }}" alt="avatar"> <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                <li class="dropdown-header text-center">Mon Compte</li>

                <li class="divider"></li>
                <li>
                    <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.html in PHP version) -->
                    <a href="#modal-user-settings" data-toggle="modal">
                        <i class="fa fa-cog fa-fw pull-right"></i>
                        Profil utilisateur
                    </a>
                </li>
                <li class="divider"></li>
                {{-- <li>
                    <a href="page_ready_lock_screen.html"><i class="fa fa-lock fa-fw pull-right"></i> Lock Account</a>
                </li> --}}
                <li>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();"><i class="fa fa-ban fa-fw pull-right"></i>
                    Se Deconnecter
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
            </li>
            </ul>
        </li>
        <!-- END User Dropdown -->
    </ul>
    <!-- END Right Header Navigation -->
</header>
