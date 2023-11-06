<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="rr">
                <h1 class="mt-4">Mon tableau de bord</h1>
                <div class="dropdown">
                    <button class="side-btn"  id="selectedBtn">Sélectionner un bilan<span class="arrow-down"></span></button>
                    <div class="dropdown-content">
                        <a href="bilan.php?jours=7">Aujourd'hui</a>
                        <a href="bilan.php?jours=7">7 derniers jours</a>
                        <a href="bilan.php?jours=14">14 derniers jours</a>
                        <a href="bilan.php?jours=30">30 derniers jours</a>
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
            <div class="rr">
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
            </div>
            <?php
            require_once ('codeFactorisé/dataTables.php');
            $dataJSON =
               '[
        {
            "id": 1,
            "nom_aliment": "Pommes",
            "Date de consommation": "2023-10-30",
            "indice_nova": 2,
            "energie_kcal": 52.0,
            "sucre": 10.4,
            "proteine": 0.26,
            "fibre_alimentaire": 2.4,
            "matiere_grasse": 0.2,
            "alcool": 0.0
        },
        {
            "id": 2,
            "nom_aliment": "Bananes",
            "Date de consommation": "2023-10-29",
            "indice_nova": 3,
            "energie_kcal": 89.0,
            "sucre": 12.2,
            "proteine": 1.1,
            "fibre_alimentaire": 2.6,
            "matiere_grasse": 0.3,
            "alcool": 0.0
        }
    ]'

            ;

            displayDataTable($dataJSON, 'Tableau de données');

            ?>
        </div>
    </main>



