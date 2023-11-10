<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <div class="rr margin-bottom">
        <h1 class="mt-4">Mon profil</h1>
      </div>
      <div class="card plr-8">
        <h3 class="rr mt-4 mb-2">
          Mes informations
          <button style="margin-left: auto;" class="side-btn" id="modifier">Modifier <i class="fas fa-pencil-alt"></i></button>
        </h3>
        <hr/>
        <div class="row mb-4 plr-8">
          <b class="small-column">Email :</b>
          <p class="card small-column" id="inputEmail"></p>
        </div>
        <div class="row mb-4 plr-8">
          <b class="small-column">Nom :</b>
          <p class="card small-column" id="inputNom"></p>
        </div>
        <div class="row mb-4 plr-8">
          <b class="small-column">Prenom :</b>
          <p class="card small-column" id="inputPrenom"></p>
        </div>
        <div class="row mb-4 plr-8">
          <b class="small-column">Age :</b>
          <p class="card small-column" id="inputAge"></p>
          <label class="small-column p-0">ans</label>
        </div>
        <div class="row mb-4 plr-8" id="inputSexe">
          <b class="small-column">Sexe :</b>
          <div class="card small-column">
            <label>Homme
              <input type="radio" name="sexe" value="homme" disabled>
            </label>
            <label>Femme
              <input type="radio" name="sexe" value="femme" disabled>
            </label>
          </div>
        </div>
        <div class="row mb-4 plr-8">
          <b class="small-column">Poids :</b>
          <p class="card small-column" id="inputPoids"></p>
          <label class="small-column p-0">kg</label>
        </div>
        <div class="row mb-4 plr-8">
          <b class="small-column">Taille :</b>
          <p class="card small-column" id="inputTaille"></p>
          <label class="small-column p-0">cm</label>
        </div>
        <div class="row mb-4 plr-8" id="inputSport">
          <b class="small-column">Pratique sportive :</b>
          <div class="card small-column">
            <label>Bas
              <input type="radio" name="sport" value="1" disabled>
            </label>
            <label>Moyen
              <input type="radio" name="sport" value="2" disabled>
            </label>
            <label>Élevé
              <input type="radio" name="sport" value="3" disabled>
            </label>
          </div>
        </div>
      </div>
  </main>
  <script>
      const user_id = <?php echo json_encode($_SESSION['user']); ?>;
      const prefixeEndpoint = <?php echo json_encode(prefixeEndpoint); ?>;
  </script>
  <script type="text/javascript" src="../js/profil.js"></script>