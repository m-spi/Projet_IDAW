$(document).ready(function () {
    let table = $('#dashBoardDataTable').DataTable(); // Créez DataTable correctement ici
    console.log("ici");
    filterDataByDuration(7, table);
    console.log("ici");
    $('.duration-button').on('click', function () {
        var duration = $(this).data('duration');
        filterDataByDuration(duration, table);
    });

});

function filterDataByDuration(duration, table) { // Prenez la table comme paramètre
    $.ajax({
        url: prefixeEndpoint + "/backend/journal.php/user/" + id_user,
        method: "GET",
        dataType: "json",
    })
        .done(function (responseJournal) {
            var journal = responseJournal.result.journal;
            var journalFiltre = [];
            journal.forEach(function (journalEntree) { // Ajoutez "function"
                if (isDateInPeriod(journalEntree.date, duration)) {
                    journalFiltre.push(journalEntree);
                }
            });

            $.ajax({
                url: prefixeEndpoint + "/backend/aliments.php",
                method: "GET",
                dataType: "json",
            })
                .done(function (responseAliment) {
                    var aliment = responseAliment.result.aliments;
                    var total = {
                        'sucre': 0,
                        'sel': 0,
                        'energie': 0,
                        'fibre': 0,
                        'matiereGrasse': 0,
                        'proteines': 0,
                    };

                    journalFiltre.forEach(function (plat) { // Ajoutez "function"
                        var platTrouve = aliment.find(function (alim) {
                            return alim.id == plat.id_aliment;
                        });
                        console.log("aliment"+ JSON.stringify(platTrouve));
                        total.sucre += parseFloat(platTrouve.sucre);
                        total.sel += parseFloat(platTrouve.sel);
                        total.energie += parseFloat(platTrouve.energie_kcal);
                        total.fibre += parseFloat(platTrouve.fibre_alimentaire);
                        total.matiereGrasse += parseFloat(platTrouve.matieres_grasses);
                    });
                    Object.keys(total).forEach(function (key) {
                        total[key] = parseFloat(total[key]).toFixed(2);
                    });
                    updateDataTable(total, table); // Appelez updateDataTable avec la table
                })
                .fail(function (error) {
                    alert("La requête GET aliment s'est terminée en échec. Infos : " + JSON.stringify(error));
                });
        })
        .fail(function (error) {
            alert("La requête GET journal s'est terminée en échec. Infos : " + JSON.stringify(error));
        });
}

function isDateInPeriod(dateStr, periodInDays) {
    var currentDate = new Date();
    var dateToCheck = new Date(dateStr);
    var timeDiff = currentDate - dateToCheck;
    var daysDiff = timeDiff / (1000 * 3600 * 24);

    return daysDiff <= periodInDays;
}

function updateDataTable(data, table) { // Prenez la table comme paramètre
    // Réinitialisez ou mettez à jour la DataTable existante avec les nouvelles données
    table.clear().draw();

    // Ajoutez les données filtrées à la DataTable
    table.row.add([
        data.energie, data.sucre, data.sel, data.matiereGrasse, data.fibre, data.proteines
    ]).draw(false);
}
