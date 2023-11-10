<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            <div class="row" id="recommendationContainer"> <!--Etiquettes-->

            </div>


            <div class="container-fluid px-4">

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
                            <th>Matières grasses (g)</th>
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
                <div class="rr">
                    <h1 class="mt-4 graphiqueTitle">Mon bilan en graphiques</h1>
                    <div class="dropdown">
                        <button class="side-btn smallSize"  id="selectedChartBtn">Sélectionner une donnée<span class="arrow-down"></span></button>
                        <div class="dropdown-content ">
                            <button class="chart-button" data-nutriment="energie_kcal">Energie (kcal)</button>
                            <button class="chart-button" data-nutriment="sucre">Sucre (g)</button>
                            <button class="chart-button" data-nutriment="sel">Sel (g)</button>
                            <button class="chart-button" data-nutriment="matieres_grasses">Matières grasses (g)</button>
                            <button class="chart-button" data-nutriment="fibre_alimentaire">Fibre alimentaire (g)</button>
                            <button class="chart-button" data-nutriment="proteines">Protéines (g)</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Bilan graphique
                            </div>
                            <div class="card-body"><canvas id="myBilanChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Bilan graphique en barre
                            </div>
                            <div class="card-body"><canvas id="myBarBilanChart" width="100%" height="40"></canvas></div>
                        </div>
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
    <script src="../js/config.js"></script>
    <script src="../js/dashBoard.js"></script>




