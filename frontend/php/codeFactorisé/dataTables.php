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
                <th>Valeur nutritionnelles</th>
            </tr>
            </thead>
            <tbody>';

            // Check if $jsonData is a valid JSON array
            $data = json_decode($jsonData, true);

            if (is_array($data)) { // ou si le json s'appelle à un nom data : c'est if ($data)
            foreach ($data as $item) {
            echo '<tr>';
                echo '<td>' . $item['Aliments/Plats'] . '</td>'; // /!\ attention a changer les nom avec ceux qui seront dans la reponse de l'API
                echo '<td>' . $item['Date de consommation'] . '</td>';
                echo '<td>' . $item['Valeur nutritionnelles'] . '</td>';
                echo '</tr>';
            }
            } else {
            echo '<tr><td colspan="3">Erreur aucune donnée ne semble disponible</td></tr>';
            }

            echo '</tbody>
        </table>
    </div>
</div>';
}
?>