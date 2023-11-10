<?php
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
                <form>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="email" id="email" placeholder="nom@exemple.fr" />
                    <label for="email">Email</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="nom" placeholder="Dupont" />
                    <label for="nom">Nom</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="prenom" placeholder="Jean" />
                    <label for="prenom">Prénom</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="number" id="age" placeholder="18" />
                    <label for="age">Âge</label>
                  </div>
                  <div class="form-floating mb-3">
                    <select class="form-control" id="sexe">
                      <option value="">Veuillez sélectionner</option>
                      <option value="femme">Femme</option>
                      <option value="homme">Homme</option>
                    </select>
                    <label for="sexe">Sexe</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="number" id="poids" placeholder="70" />
                    <label for="poids">Poids</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="number" id="taille" placeholder="175" />
                    <label for="taille">Taille</label>
                  </div>
                  <div class="form-floating mb-3">
                    <select class="form-control" id="sport">
                      <option value="">Veuillez sélectionner</option>
                      <option value="1">Bas</option>
                      <option value="2">Moyen</option>
                      <option value="3">Élevé</option>
                    </select>
                    <label for="sport">Niveau de pratique sportive</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="password" id="password" placeholder="MotDePasse" />
                    <label for="password">Mot de Passe</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input class="form-control" type="password" id="passwordConfirm" placeholder="MotDePasse" />
                    <label for="passwordConfirm">Confirmer le mot de Passe</label>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <input type="button" class="btn btn-primary" id="register" value="Créer un utilisateur">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script>
      const prefixeEndpoint = <?php echo json_encode(prefixeEndpoint); ?>;
    </script>
    <script type="text/javascript" src="../js/register.js"></script>
  </div>
<?php
require_once('codeFactorisé/footer.php');
