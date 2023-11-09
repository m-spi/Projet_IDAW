<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="rr">
                <h1 class="mt-4">Mon tableau de bord</h1>
                <div class="dropdown">
                    <button class="side-btn"  id="selectedBtn">Sélectionner un bilan<span class="arrow-down"></span></button>
                    <div class="dropdown-content">
                        <button class="duration-button" data-duration="1">Aujourd'hui</button>
                        <button class="duration-button" data-duration="7">7 derniers jours</button>
                        <button class="duration-button" data-duration="14">14 derniers jours</button>
                        <button class="duration-button" data-duration="30">30 derniers jours</button>
                    </div>
                </div>
            </div>

            <div class="row"> <!--Etiquettes-->
                <?php
                require_once ('codeFactorisé/recommandation.php');
                displayRecommendation('Attention vous consommez trop de sel !', 'index.php?page=warningSel');
                displayRecommendation('Attention vous consommez trop de matière grasse !', 'index.php?page=warningMatiereGrasse');
                displayRecommendation('Attention vous consommer trop de sucre !', 'index.php?page=warningSucre');
                displayRecommendation('Attention vous consommez trop de proteine !', 'index.php?page=warningProteine');
                displayRecommendation('Attention vous consommez trop de calories!', 'index.php?page=warningEnergie');
                ?>
            </div>
            <!---<div class="rr">
                <h1 class="mt-4 h3Size">Mon bilan en graphiques</h1>
                <div class="dropdown">
                    <button class="side-btn smallSize"  id="selectedBtn">Sélectionner une donnée<span class="arrow-down"></span></button>
                    <div class="dropdown-content ">
                        <a href="bilan.php?jours=7">sucre</a>
                        <a href="bilan.php?jours=7">sel</a>
                        <a href="bilan.php?jours=14">matière grasse</a>
                        <a href="bilan.php?jours=30">alcool</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Area Chart Example
                        </div>
                        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Bar Chart Example
                        </div>
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>-->
            <div class="container-fluid px-4">
                <div class="rr margin-bottom">
                    <h1 class="mt-4">Mon Bilan</h1>

                </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Bilan nutritionnel
                </div>
                <div class="card-body">
                    <table id="dashBoardDataTable"  class="hover  order-column row-border ">
                        <thead>
                        <tr>
                            <th>Energie (kcal)</th>
                            <th>Sucre (g)</th>
                            <th>Sel (g)</th>
                            <th>Matières grasse (g)</th>
                            <th>Fibre alimentaire</th>
                            <th>Protéines</th>
                            <!--<th>Alcool</th>-->
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
        </div>
    </main>
    <?php
    //session_start(); // Démarrez la session si ce n'est pas déjà fait

    // Récupérez la valeur de $_SESSION['user']
    $user = $_SESSION['user'];
    ?>

    <script>
        // Utilisez la variable PHP dans votre code JavaScript
        var id_user = <?php echo json_encode($user); ?>;
        console.log("id_user "+id_user);
    </script>
    <script src="../js/dashBoard.js"></script>
    <script src="../js/config.js"></script>



