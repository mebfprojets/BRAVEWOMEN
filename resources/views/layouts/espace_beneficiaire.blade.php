<!DOCTYPE html>
<html lang="en">

    @include("partials.beneficiaire.__entete")

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="index.html" class="logo">ESPACE BENEFICICIAIRE <b><span></span></b></a>
      
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
            
          <li><a class="logout" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Se Deconnecter
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="profile.html"><img src="{{ asset("img/logo-bravebf4.PNG") }}" class="img-circle" width="80"></a></p>
          <h5 class="centered">{{ Auth::user()->name }} {{ Auth::user()->prenom }}</h5>
          <li class="mt">
            <a class="@yield('profil')" href="{{ route("profil.beneficiaire") }}">
              <i class="fa fa-dashboard"></i>
              <span>Mon Profil</span>
              </a>
          </li>
          <li class="sub">
            <a class="@yield('pca')" href="{{ route('projet.create') }}">
              <i class="fa fa-dashboard"></i>
              <span>Soumettre mon Projet</span>
              </a>
          </li>
      @if(kyc_entreprise_is_valide(Auth::user()->code_promoteur) )
        <li class="sub-menu">
            <a class="@yield('devis')" href="{{ route("profil.mesdevis") }}">
              <i class="fa fa-desktop"></i>
              <span> Mes Devis</span>
              </a>
          </li>
          
          <li>
            <a href="inbox.html">
              <i class="fa fa-envelope"></i>
              <span> Ma Situation Financiaire</span>
              <span class="label label-theme pull-right mail-info"></span>
              </a>
          </li>
      @endif
          <li class="sub-menu">
            <a href="javascript:;">
              <i class=" fa fa-bar-chart-o"></i>
              <span>Me déconnecter</span>
              </a>
            
          </li>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper site-min-height ">
        @include('flash::message')
            @yield("content")
            
      </section>
    </section>
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
      <div class="text-center">
        <p>
          &copy; Tous droits réservés <strong>Brave women Burkina Faso</strong>
        </p>
        <div class="credits">
          
         </a>
        </div>
        <a href="index.html#" class="go-top">
          <i class="fa fa-angle-up"></i>
          </a>
      </div>
    </footer>
   
  </section>
  @yield("modal")
  @include("partials.beneficiaire.__footer")
  
</body>

</html>
