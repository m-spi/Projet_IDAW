<?php
require_once ('codeFactorisé/header.php');
require_once ('codeFactorisé/menu.php');
renderMenuToHTML('index');
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Mon tableau de bord</h1>
            <div class="row"> <!--Etiquettes-->
                <?php
                require_once ('codeFactorisé/recommandation.php');
                displayRecommendation('reco1', 'index.html');
                displayRecommendation('reco2', 'index.html');
                ?>
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
            "Aliments/Plats": "Pommes",
            "Date de consommation": "2023-10-30",
            "Valeur nutritionnelles": "100 calories"
        },
        {
            "Aliments/Plats": "Bananes",
            "Date de consommation": "2023-10-29",
            "Valeur nutritionnelles": "90 calories"
        }
    ]'
;

            displayDataTable($dataJSON, 'Tableau de données');

            ?>
        </div>
    </main>
    <?php
    require_once ('codeFactorisé/footer.php') ?>



