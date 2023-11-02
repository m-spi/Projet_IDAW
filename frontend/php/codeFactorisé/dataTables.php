<?php function displayDataTable($jsonData, $tableTitle)
{
    echo '<div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>' . $tableTitle . '
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Aliments/Plats</th>
                        <th>Date de consommation</th>
                        <th>Valeurs nutritionnelles (100g ou 100ml)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

    // Decode the JSON data
    $data = json_decode($jsonData, true);

    if (is_array($data)) {
        foreach ($data as $item) {
            echo
            '<tr data-id="' . $item['id'] . '"> <!--later we can access to the data-id with javascript-->
                <td>' . $item['nom_aliment'] . '</td>
                <td>' . $item['Date de consommation'] . '</td>
                <td>
                    <ul>
                        <li>Indice Nova : '.$item['indice_nova'].' /4</li>
                        <li>Énergie : '.$item['energie_kcal'].' kcal</li>
                        <li>Sucre : '.$item['sucre'].'g</li>
                        <li>Protéines : '.$item['proteine'].'g</li>
                        <li>Fibre alimentaire : '.$item['fibre_alimentaire'].' g</li>
                        <li>Matières grasses : '.$item['matiere_grasse'].'g</li>
                        <li>Alcool : '.$item['alcool'].'</li>
                    </ul>
                </td>
                <td   >
                <div class="action-button-container">
                    <button class="action-button" onclick="editRow('.$item['id'].')">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                     <button class="action-button" onclick="deleteRow('.$item['id'].')">
                        <i class="fas fa-trash"></i>
                    </button>
                    </div>
                </td>
            </tr>';
        }
    } else {
        echo '<tr><td colspan="4">Erreur aucune donnée ne semble disponible</td></tr>';
    }

    echo '</tbody>
        </table>
    </div>
</div>';
}

?>