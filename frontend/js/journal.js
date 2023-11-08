$(document).ready(function () {
    let table = new DataTable('#journalDataTable');
    let alimentsTable = []; // stock l'id et le nom des aliments dans un tableau
    let count = 0; // compteur pour ajouter qu'une fois une ligne vide
    let enModification = 0;

    function trouverNomAlimentAvecId(idIngredient) {
        var nomIngredient = "Inconnu";
        alimentsTable.forEach(function(aliment) {
            if (aliment.id == idIngredient) {
                nomIngredient = aliment.nom;
            }
        });
        return nomIngredient;
    }
    function trouverIDAlimentAvecNom(nom) {
        var id;
        alimentsTable.forEach(function(aliment) {
            if (aliment.nom == nom) {
                id = aliment.id;
            }
        });
        return id;
    }

    // GET Journal
    $.ajax({
        url: "http://localhost/Projet_IDAW/backend/journal.php",
        method: "GET",
        dataType: "json",
    })
        .done(function(responseJournal){
            console.log ("je suis dans le done GET journal");
            table.clear().draw();
            var journal = responseJournal.result.journal;

            // après avoir GET journal on GET aliment pour récupérer les infos
            $.ajax({
                url: "http://localhost/Projet_IDAW/backend/aliments.php",
                method: "GET",
                dataType: "json",
            })
                // done du get aliments
                .done(function(responseAliment) {
                    var aliments = responseAliment.result.aliments;
                    // on remplit la table alimentsTable
                    aliments.forEach(function (aliment) {
                        alimentsTable.push({id: aliment.id, nom: aliment.nom});
                    });
                    console.log ("alimentTable" + JSON.stringify(alimentsTable));

                    var buttons = '<div class="action-button-container" >' +
                        '<button class="action-button" id="modifier-Btn">' +
                        '<i class="fas fa-pencil-alt"></i>' +
                        '</button>' +
                        '<button class=action-button" id="delete-Btn" data-id="' + journal.id_aliment + '">' +
                        '<i class="fas fa-trash"></i>' +
                        '</button>' +
                        '</div>';

                    journal.forEach(function(plat) {
                        var nomPlat = trouverNomAlimentAvecId(plat.id_aliment);
                        console.log (nomPlat);
                        var platTrouve = aliments.find ( (aliment) => aliment.id == plat.id_aliment );

                        var nutrimentsPlat = '<ul>';

                            if (platTrouve.indice_nova != 0 && platTrouve.indice_nova !== "") {
                            nutrimentsPlat += '<li >Indice Nova : ' + platTrouve.indice_nova + '/4</li>';
                        } else {
                            nutrimentsPlat += '<li>Indice Nova : Non renseigné </li>';
                        }
                            if (platTrouve.energie_kcal != 0 && platTrouve.indice_nova !== "") {
                                nutrimentsPlat += '<li >Énergie : ' + ((platTrouve.energie_kcal)*plat.quantite)/100 + 'kcal</li>';
                            } else {
                                nutrimentsPlat += '<li>Énergie : Non renseigné </li>';
                            }
                            nutrimentsPlat +=
                                '<li>Sel : ' + ((platTrouve.sel)*plat.quantite)/100 + 'g</li>' +
                                '<li>Sucre : ' + ((platTrouve.sucre)*plat.quantite)/100 + 'g</li>' +
                                '<li>Protéines : ' + ((platTrouve.proteines)*plat.quantite)/100+ 'g</li>' +
                                '<li>Fibre alimentaire : ' + ((platTrouve.fibre_alimentaire)*plat.quantite)/100 + ' g</li>' +
                                '<li>Matières grasses : ' + ((platTrouve.matieres_grasses)*plat.quantite)/100 + 'g</li>' +
                                '<li>Alcool : ' + platTrouve.alcool + '%</li>' +
                                '</ul>';

                        table.row.add([
                            nomPlat,
                            plat.date,
                            plat.quantite,
                            nutrimentsPlat,
                            buttons,
                        ]).draw(false);
                    });
                })
                .fail(function(error){
                    alert("La requête GET aliment s'est terminée en échec. Infos : " + JSON.stringify(error));
                });
        })
    .fail(function(error){
        alert("La requête GET journal s'est terminée en échec. Infos : " + JSON.stringify(error));
    });



    //Ajouter un journal

    function ajouterLigne() {
        table.row.add([
            '<select id="ingredientDeInput">' +
            '<option value="">Choisir un plat</option>' +
            alimentsTable.map(function(aliment) {
                return '<option value="' + aliment.id + '">' + aliment.nom + '</option>';
            }) +
            '</select>',
            '<label>Date de consommation</label>''<input type="datetime-local" id="dateInput" value="YYYY-MM-DDTHH:MM:SS" placeholder="YYYY-MM-DDTHH:MM:SS"/>',
            '<label> Quantité (g)</label>' + <input value="" placeholder="4" id="quantiteInput"/>

            '<div class="valider-button-container" >' +
            '<button class="action-button" id="validerBtn"> Valider ' +
            '</button>' +
            '<button class="action-button" id="annulerBtn"> Annuler' +
            '</button>' +
            '</div>'
            + '<span class="italic" >Les champs avec un * sont obligatoires</span>'
        ]).draw(false);
        count++;
    }

    // Gestionnaire d'événements pour le bouton "Ajouter Aliment"
    $('#ajouterJournalBtn').click(function () {
        if (enModification != 0){
            alert("Une action à la fois, terminé d'abord la modification !");
        } else {
            if (count === 0) {
                ajouterLigne();
            } else {
                alert("Formulaire déjà présent, ajoutez d'abord votre aliment");
            }
        }
    });
});
