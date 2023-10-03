<!DOCTYPE html>
<html lang="en">

@include("partials.beneficiaire.__entete")
<body>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
  <div id="login-page">
    <div class="container">
      <form class="form-login" action="{{ route('login') }}" method="post">
            @csrf
        <h2 class="form-login-heading">Se connecter</h2>
        <div class="login-wrap">
          <input type="text" class="form-control" name="email" placeholder="Nom d'utilisateur" autofocus>
          <br>
          <input type="password" class="form-control" name="password" placeholder="Password">
          <label class="checkbox">
            <input type="checkbox" value="remember-me"> Se Rapeller
            <span class="pull-right">
            <a data-toggle="modal" href="login.html#myModal"> Mot de passe oublier?</a>
            </span>
            </label>
          <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> SE CONNECTER</button>
          <hr>
          <div class="registration">
            Vous ne disposez pas de compte?<br/>
            <a class="" href="#">
              Créer un compte
              </a>
          </div>
        </div>
      </form>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
              </div>
              <div class="modal-body">
                <p>Entrer votre email.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
              </div>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Annuler</button>
                <button class="btn btn-theme" type="button">Valider</button>
              </div>
            </div>
          </div>
        </div>
        <!-- modal -->
      </form>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  @include("partials.beneficiaire.__footer")

</body>

</html>
