
$(document).ready(function () {
    var table = $('#journalDataTable').DataTable();

    // Récupération de tous les plats consommé
    $.ajax({
        // L'URL de la requête
        url: prefixeEndpoint + "/TP4/exo5/user.php",
        // La méthode d'envoi (type de requête)
        method: "GET",
        // Le format de réponse attendu
        dataType: "json",
    })





    // Fonction pour ajouter une ligne vide
    function addEmptyRow() {
        table.row.add(['', '', '', '<button class="edit-btn">Modifier</button> <button class="delete-btn">Supprimer</button>']).draw();
    }

    /* Ajouter une ligne vide au chargement de la page
    addEmptyRow();*/

    // Gérer le clic sur le bouton "Ajouter"
    $('#addRowBtn').on('click', function () {
        addEmptyRow();
    });

    // Gérer le clic sur les boutons "Modifier"
    $('#journalDataTable').on('click', '.edit-btn', function () {
        var row = $(this).closest('tr');
        var data = table.row(row).data();
        var columns = row.find('td');

        // Remplacer le texte par des champs d'entrée
        columns.eq(0).html('<input type="text" value="' + data[0] + '">');
        columns.eq(1).html('<input type="text" value="' + data[1] + '">');
        columns.eq(2).html('<input type="text" value="' + data[2] + '">');
        columns.eq(3).html('<button class="update-btn">Valider</button>');
    });

    // Gérer le clic sur les boutons "Valider"
    $('#journalDataTable').on('click', '.update-btn', function () {
        var row = $(this).closest('tr');
        var columns = row.find('td');
        var rowData = [];

        // Récupérer les nouvelles données des champs d'entrée
        columns.each(function () {
            var input = $(this).find('input');
            rowData.push(input.val());
        });

        // Mettre à jour la ligne du DataTable
        table.row(row).data(rowData).draw();
    });

    // Gérer le clic sur les boutons "Supprimer"
    $('#journalDataTable').on('click', '.delete-btn', function () {
        var row = $(this).closest('tr');
        table.row(row).remove().draw();
    });
});
