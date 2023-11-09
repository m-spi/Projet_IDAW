<?php
session_start();

if(isset($_GET['disconnect'])){
  session_unset();
  session_destroy();
  header("Location: login.php");
}

if(isset($_POST['emailInput']) && isset($_POST['passwordInput'])){
  require_once ('config.php');
  $users = json_decode(file_get_contents(prefixeEndpoint.'/backend/users.php'));

  foreach($users->result->utilisateurs as $u){
    if($u->email == $_POST['emailInput'] && $u->password == $_POST['passwordInput']){
      $_SESSION['user'] = $u->id;
      $_SESSION['prenom'] = $u->prenom;
      header('Location: index.php', true, 303);
      exit(0);
    }
  }


} else {
    $wrong = true;
}

require_once('codeFactorisé/smallHeader.php');
?>
<body class="loginBackground">
<div id="layoutAuthentication">
  <div id="layoutAuthentication_content">
    <main>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
              <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
              <div class="card-body">
                <form action="login.php" method="POST">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="inputEmail" type="email" name="emailInput" placeholder="name@example.com" />
                    <label for="inputEmail">Email address</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" id="inputPassword" type="password" name="passwordInput" placeholder="Mot de Passe" />
                    <label for="inputPassword">Password</label>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <input type="submit" class="btn btn-primary" value="Login">
                  </div>
                </form>
              </div>
              <!--<div class="card-footer text-center py-3">
                <div class="small"><a href="register.php">Se créer un compte</a></div>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <div id="layoutAuthentication_footer">
    <footer class="py-4 bg-light mt-auto">
      <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
          <div class="text-muted">Copyright &copy; Traque ta bouffe 2023</div>
        </div>
      </div>
    </footer>
  </div>
</div>
<script src="../../node_modules/startbootstrap-sb-admin/dist/js/scripts.js"></script>
<?php
if($wrong) echo '<script>alert("Mauvais identifiants, veuillez réessayer.")</script>';
?>
</body>
</html>
