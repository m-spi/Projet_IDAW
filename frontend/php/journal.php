<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="rr margin-bottom">
                <h1 class="mt-4">Mon journal</h1>
                <button class="side-btn" id="selectedBtn">Ajouter <i class="fas fa-plus-circle"></i></button>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>' . $tableTitle . '
                </div>
                <div class="card-body">
                    <table id="journalDataTable">
                        <thead>
                        <tr>
                            <th>Aliments/Plats consommé</th>
                            <th>Date de consommation</th>
                            <th>Valeurs nutritionnelles (100g ou 100ml)</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="journalTableBody">
                        </tbody>
                    </table>
                </div>
    </main>

    <?php/*
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
    ]';

            displayDataTable($dataJSON, 'Mes aliments consommés');

            */?>
