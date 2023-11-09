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
        url: prefixeEndpoint+"/backend/journal.php",
        method: "GET",
        dataType: "json",
    })
        .done(function(responseJournal){
            console.log ("je suis dans le done GET journal");
            table.clear().draw();
            var journal = responseJournal.result.journal;

            // après avoir GET journal on GET aliment pour récupérer les infos
            $.ajax({
                url: prefixeEndpoint+"/backend/aliments.php",
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



                    journal.forEach(function(plat) {
                        var nomPlat = '<span>' + trouverNomAlimentAvecId(plat.id_aliment) + '</span>' +
                            '<input type="hidden" id="journalId" value="' + plat.id + '"/>';

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
                        var buttons = '<div class="action-button-container" >' +
                            '<button class="action-button" id="modifier-Btn">' +
                            '<i class="fas fa-pencil-alt"></i>' +
                            '</button>' +
                            '<button class=action-button" id="delete-Btn" data-id="' + plat.id + '">' +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</div>';
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
            '<span style="color: white; font-size: 1px;">AAAAAAAA</span>'+
            '<select id="alimentBDD">' +
            '<option value="">Choisir un plat*</option>' +
            alimentsTable.map(function(aliment) {
                return '<option value="' + aliment.id + '">' + aliment.nom + '</option>';
            }) +
            '</select>',
            '<label>Date de consommation* :</label>' + '<input type="datetime-local" id="dateInput" value="" placeholder="YYYY-MM-DD HH:MM:SS"/>',
            '<label> Quantité* (g ou ml)</label>' + '<input value="" placeholder="4" id="quantiteInput"/>',
            '<span style="font-size: small; font-style: italic"> Pas d\'informations requise sur les nutriments </span>',
            '<div class="valider-button-container" >' +
            '<button class="action-button" id="validerBtn"> Valider ' +
            '</button>' +
            '<button class="action-button" id="annulerBtn"> Annuler' +
            '</button>' +
            '</div>'
            + '<span class="italic" >Les champs avec un * sont obligatoires</span>'
        ]).draw(false);
        console.log(table.row.add);
        //count++;
        console.log(count);
    }


    // Gestionnaire d'événements pour le bouton "Ajouter Aliment"
    $('#ajouterJournalBtn').click(function () {
        if (enModification != 0){
            alert("Une action à la fois, terminez d'abord la modification !");
        } else {
            if (count === 0) {
                ajouterLigne();
            } else {
                alert("Formulaire déjà présent, ajoutez d'abord votre aliment");
            }
        }
    });

// creer une entree dans le journal
    function ajouterJournal(data) {
        $.ajax({
            url: prefixeEndpoint+"/backend/journal.php",
            method: "POST",
            dataType: "json",
            data: JSON.stringify(data),
            contentType: "application/json",
        })
            .done(function(response) {
                console.log("Journal ajouté avec succès :", response);
                location.reload();
            })
            .fail(function(error) {

                console.error("Erreur lors de l'ajout du journal :", error);
            });
    }

    // Gestionnaire d'événements pour le bouton "Valider"
    $(document).on('click', '#validerBtn', function () {
        // Récupérer les données des champs d'entrée
        let ok = 1 ;

        var platId = $('#alimentBDD').val();
        /*var userId;*/
        var date = $('#dateInput').val();
        date = date.replace('T', ' ');
        date += ":00";
        var quantite = $('#quantiteInput').val();
        // on vérifie que les champs sont bien complétés
        if (platId == "") {
            alert("Veuillez choisir un plat ou un aliment");
            ok = 0;
        }
        if( date == ""){
            alert ("Veuillez choisir indiquer l'heure à laquelle vous avez manger ce plat");
            ok = 0;
        }
        if (quantite == "") {
            alert("Veuillez indiquez une quantité")
            ok=0;

        }
        console.log(ok)
        // Créer un objet avec les données
        var journalData =
            {
                "id_aliment": platId,
                "id_user": 1,
                "date": date,
                "quantite": quantite,
            };
        console.log(JSON.stringify(journalData));

        if (ok === 1) {
            // Effectuer une requête AJAX pour ajouter le journal
            ajouterJournal(journalData);
        }

    });
// DELETE un journal

    $(document).on('click', '#delete-Btn', function () {
        var idJournal = $(this).data('id'); // Récupérer l'ID de l'aliment à partir de l'attribut data-id
        console.log(idJournal);
        if (confirm("Êtes-vous sûr de vouloir supprimer cette entrée ?")) {
            deleteJournal(idJournal);
        }
    });



    function deleteJournal(idJournal) {
        $.ajax({
            url: prefixeEndpoint+"/backend/journal.php/"+idJournal,
            method: "DELETE", // Utilisez la méthode appropriée (POST, PUT, etc.)
            dataType: "json",
        })
            .done(function(response) {
                // Traitement en cas de succès
                console.log("Journal supprimé avec succès :", response);
                location.reload();
            })
            .fail(function(error) {
                // Traitement en cas d'échec
                console.error("Erreur lors de la suppression du journal :", error);
            });
    }

    $(document).on('click', '#annulerBtn', function(){
        count = 0;
        console.log(count);
        var lastIndex = table.rows().count() - 1;
        table.row(lastIndex).remove().draw(false);

    });

    //modifier une entree
    function modifierJournal(data,idJournal) {
        $.ajax({
            url: prefixeEndpoint+"/backend/journal.php/" + idJournal,
            method: "PUT",
            dataType: "json",
            data: data,
            contentType: "application/json",
        })
            .done(function(response) {
                // Traitement en cas de succès
                console.log("Journal mis à jour avec succès :", response);
                location.reload();
            })
            .fail(function(error) {
                // Traitement en cas d'échec
                console.error("Erreur lors de la mise à jour du journal :", error);
            })

    }
    // get une entrée du journal
    function getJournalByID(idJournal, callback) {
        $.ajax({
            url: prefixeEndpoint+"/backend/journal.php/" + idJournal,
            method: "GET",
            dataType: "json"
        })
            .done(function(response) {
                callback(response);
            })
            .fail(function(error) {
                console.error("Erreur lors de la récupération des données de l'aliment : ", idJournal, error);
            });
    }

    function transformerLigneEnInputs(row) {
        var idJournal = $('#journalId').val();
        console.log("idJournal"+idJournal);
//on fait un get pour recup les infos et remplir les champs
        getJournalByID(idJournal, function(JournalData) {
            console.log("getJournalByid " +JSON.stringify(JournalData));
            var journal = JournalData.result.entree;

            var newInput = '<td>'+'<span style="color: white; font-size: 1px;">AAAAAAAA</span>'+'<input type="hidden" id="newIdJournal" value="' + idJournal+ '"/>'+
                '<select id="newAlimentBDD">' +
                '<option value="">Choisir un plat*</option>' +
                '<option value="' + journal.id_aliment + '">' + trouverNomAlimentAvecId(journal.id_aliment) + '</option>';
            newInput+=alimentsTable.map(function(aliment) {
                return '<option value="' + aliment.id + '">' + aliment.nom + '</option>';
            }).join('');
            newInput+='</select>'+ '</td>';

            newInput+='<td>'+'<label>Date de consommation* :</label>' + '<input type="datetime-local" id="newDateInput" value="'+ journal.date +'" placeholder="YYYY-MM-DD HH:MM:SS"/>'+
                '</td>';

            newInput+='<td>'+
                '<label> Quantité* (g/ml)</label>' + '<input value="'+ journal.quantite+'" placeholder="4" id="newQuantiteInput"/>'
                + '</td>';
            newInput += '<td>'+
                '<span style="font-size: small; font-style: italic"> Pas d\'informations requise sur les nutriments </span>'
                + '</td>';
            newInput += '<td>'+'<div class="valider-button-container" >' +
                '<button class="action-button" id="validerModificationBtn"> Valider ' +
                '</button>' +
                '<button class="action-button" id="annulerModificationBtn"> Annuler' +
                '</button>' +
                '</div>'
                + '<span class="italic" >Les champs avec un * sont obligatoires</span>' + '</td>';
            console.log("quel idee "+newInput);
            row.html(newInput);
            console.log("je suis la");
        });
    }

    $(document).on('click', '#modifier-Btn', function() {
        if (count != 0){
            alert ("Une seule action à la fois annulé d'abord l'ajout");
        } else {
            enModification = 1;
            var row = $(this).closest('tr');
            transformerLigneEnInputs(row);
        }
    });
    $(document).on('click', '#annulerModificationBtn', function() {
        console.log(enModification);
        console.log("je suis la");
        enModification= 0
        location.reload();
    });

    $(document).on('click', '#validerModificationBtn', function() {
        let modifOk = 1;
        var idNewJournal = $('#newIdJournal').val();
        var newPlatId = $('#newAlimentBDD').val();
        /*var userId;*/
       var newDate = $('#newDateInput').val();
        newDate = newDate.replace('T', ' ');
        newDate += ":00";
        var newQuantite = $('#newQuantiteInput').val();
        // on vérifie que les champs sont bien complétés
        if (newPlatId == "") {
            alert("Veuillez choisir un plat ou un aliment");
            modifOk = 0;
        }
        if( newDate == ""){
            alert ("Veuillez choisir indiquer l'heure à laquelle vous avez manger ce plat");
            modifOk = 0;
        }
        if (newQuantite == "") {
            alert("Veuillez indiquez une quantité")
            modifOk=0;
        }

        // Créer un objet avec les données
        var newJournalData =
            {
                "id_aliment": newPlatId,
                "id_user": 1,
                "date": newDate,
                "quantite": newQuantite,
            };

        console.log(modifOk);
        if (modifOk == 1) {
            console.log("newJournal: " + JSON.stringify(newJournalData));
            // Effectuer une requête AJAX pour ajouter l'aliment (à implémenter)
            modifierJournal(JSON.stringify(newJournalData),idNewJournal);
        }
    })
});
