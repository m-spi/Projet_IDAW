<?php
if(isset($_POST['register'])){
  if (!isset($_POST['email']) ||
      strlen($_POST['email']) < 1 ||
      !isset($_POST['nom']) ||
      strlen($_POST['nom']) < 1 ||
      !isset($_POST['age']) ||
      !isset($_POST['sexe']) ||
      strlen($_POST['sexe']) < 1 ||
      !isset($_POST['poids']) ||
      !isset($_POST['taille']) ||
      !isset($_POST['sport']) ||
      $_POST['sport'] == 0 ||
      !isset($_POST['password']) ||
      strlen($_POST['password']) < 1 ||
      !isset($_POST['passwordConfirm'])
  ){
    $php_alert = 'Veuillez renseigner tous les champs.';
  }elseif($_POST['password'] != $_POST['passwordConfirm']){
    $php_alert = 'Les mots de passe ne correspondent pas.';
  }else{
    require_once('config.php');

    $url = prefixeEndpoint.'/backend/users.php';
    $data = [
      'email' => $_POST['email'],
      'nom' => $_POST['nom'],
      'prenom' => $_POST['prenom'],
      'age' => $_POST['age'],
      'sexe' => $_POST['sexe'],
      'poids' => $_POST['poids'],
      'taille' => $_POST['taille'],
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/json",
            'method' => 'POST',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
      $php_alert = "Erreur requête API.";
    }
  }
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
            <div class="card shadow-lg border-0 rounded-lg mt-5 mb-5">
              <div class="card-header">
                <h3 class="text-center font-weight-light my-4">Register</h3>
              </div>
              <div class="card-body">
                <form action="register.php" method="POST">
                  <div class="form-floating mb-3">
                    <input class="form-control" type="email" name="email" placeholder="nom@exemple.fr" />
                    <label for="email">Email</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="nom" placeholder="Dupont" />
                    <label for="nom">Nom</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="prenom" placeholder="Jean" />
                    <label for="prenom">Prénom</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="number" name="age" placeholder="18" />
                    <label for="age">Âge</label>
                  </div>
                  <div class="form-floating mb-3">
                    <select class="form-control" name="sexe">
                      <option value="">Veuillez sélectionner</option>
                      <option value="femme">Femme</option>
                      <option value="homme">Homme</option>
                    </select>
                    <label for="sexe">Sexe</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="number" name="poids" placeholder="70" />
                    <label for="poids">Poids</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="number" name="taille" placeholder="175" />
                    <label for="taille">Taille</label>
                  </div>
                  <div class="form-floating mb-3">
                    <select class="form-control" name="sport">
                      <option value="0">Veuillez sélectionner</option>
                      <option value="1">Bas</option>
                      <option value="2">Moyen</option>
                      <option value="3">Élevé</option>
                    </select>
                    <label for="sport">Niveau de pratique sportive</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="password" name="password" placeholder="MotDePasse" />
                    <label for="password">Mot de Passe</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="password" name="passwordConfirm" placeholder="MotDePasse" />
                    <label for="passwordConfirm">Confirmer le mot de Passe</label>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <input type="submit" class="btn btn-primary" name="register">
                  </div>
                </form>
              </div>
              <!--
              <div class="card-footer text-center py-3">
                <div class="small">
                  <a href="register.php">Se créer un compte</a>
                </div>
              </div>
              -->
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
if($php_alert) print '<script>alert("'.$php_alert.'")</script>';
?>
</body>
</html>
