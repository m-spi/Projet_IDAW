$(document).ready(function () {
    function popMessage(message) {
        var popup = document.createElement("div");
        popup.style.position = "fixed";
        popup.style.top = "0";
        popup.style.left = "0";
        popup.style.width = "100%";
        popup.style.backgroundColor = "#8bab36";
        popup.style.color = "white";
        popup.style.textAlign = "center";
        popup.style.padding = "10px";
        popup.style.zIndex = "1000";
        popup.innerHTML = message;

        document.body.appendChild(popup);
            console.log('popup')

    }

    let table = new DataTable('#alimentsDataTable');
    let alimentsTable = []; // stock l'id et le nom des aliments dans un tableau
    let count = 0; // compteur pour ajouter qu'une fois une ligne vide

    // affiche le tableau aliments
    $.ajax({
        // L'URL de la requête
        url: prefixeEndpoint+"/backend/aliments.php",
        // La méthode d'envoi (type de requête)
        method: "GET",
        // Le format de réponse attendu
        dataType: "json",
    })
        // Ce code sera exécuté en cas de succès - La réponse du serveur est passée à done()
        .done(function(response) {
            var aliments = response.result.aliments;
            table.clear().draw();
            aliments.forEach(function (aliment){
                alimentsTable.push({ id: aliment.id, nom: aliment.nom });

                });
            function trouverNomAlimentAvecId(idIngredient) {

                var nomIngredient = "Inconnu";
                alimentsTable.forEach(function(aliment) {
                    if (aliment.id == idIngredient) {
                        nomIngredient = aliment.nom;
                    }
                });

                return nomIngredient;
            }

            aliments.forEach(function(aliment) {

                var nutrimentsData = '<ul>';

                if (aliment.indice_nova !== 0 && aliment.indice_nova !== "") {
                    nutrimentsData += '<li >Indice Nova : ' + aliment.indice_nova + '/4</li>';
                } else {
                    nutrimentsData += '<li>Indice Nova : Non renseigné </li>';
                }

                nutrimentsData +=
                    '<li >Énergie : ' + aliment.energie_kcal + 'kcal</li>' +
                    '<li>Sel : ' + aliment.sel + 'g</li>' +
                    '<li>Sucre : ' + aliment.sucre + 'g</li>' +
                    '<li>Protéines : ' + aliment.proteines + 'g</li>' +
                    '<li>Fibre alimentaire : ' + aliment.fibre_alimentaire + ' g</li>' +
                    '<li>Matières grasses : ' + aliment.matieres_grasses + 'g</li>' +
                    '<li>Alcool : ' + aliment.alcool + '%</li>' +
                    '</ul>';
                //creer le liste pour affficher les ingredient_de
                var composé = '<ol class="composéCompositionColonne"> Ingrédient de : ';
                if (aliment.ingredient_de.length > 0) {
                    //aliment parent = ingrédient de quoi d'un aliment parent
                    aliment.ingredient_de.forEach(function(idAlimentParent) {
                        var nomAlimentParent = trouverNomAlimentAvecId(idAlimentParent);
                        composé += '<li class="ingredient_deListe">' + nomAlimentParent + '</li>';
                    });

                } else {
                    composé += '<span class="aucuneInfo">Aucune informations spécifiés</span>';
                }
                composé += '</ol> ';
                //creer le liste pour afficher les compose_par
                var composition = '<ol class="composéCompositionColonne"> Composé de : ';
                if (aliment.compose_par.length > 0) {
                    //alimentEnfant = un ingrédient
                    aliment.compose_par.forEach(function(idAlimentEnfant) {
                        var nomIngredient = trouverNomAlimentAvecId(idAlimentEnfant);
                        composition += '<li class="ingredient_deListe">' + nomIngredient + '</li>';
                    });
                } else {
                    composition += '<span class="aucuneInfo">Aucun ingrédients spécifiés</span>';
                }
                composition += '</ol> ';


                var buttons = '<div class="action-button-container" >' +
                    '<button class="action-button" >' +
                    '<i class="fas fa-pencil-alt"></i>' +
                    '</button>' +
                    '<button class=action-button" id="delete-Btn" data-id="' + aliment.id + '">' +
                    '<i class="fas fa-trash"></i>' +
                    '</button>' +
                    '</div>';
            table.row.add([
                    aliment.nom,
                    nutrimentsData,
                    composé + composition,
                    buttons,
                ]).draw(false);
            });

        })

        // Ce code sera éxécuté en cas d'échec - L'erreur est passée à fail()
        .fail(function(error){
            alert("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
        })






    // ajoute un aliment
    // Fonction pour créer une nouvelle ligne avec des champs d'entrée
    function ajouterLigne() {
        table.row.add([
            '<input type="text" id="nomInput" placeholder="Nom de l\'aliment*"/>',
            '<ul>' +
            '<li><input type="text" id="indiceNovaInput" placeholder="Indice Nova" /></li>' +
            '<li><input type="text" id="energieInput" placeholder="Énergie (kcal)" /></li>' +
            '<li><input type="text" id="selInput" placeholder="Sel (g)" /></li>' +
            '<li><input type="text" id="sucreInput" placeholder="Sucre (g)" /></li>' +
            '<li><input type="text" id="proteinesInput" placeholder="Protéines (g)" /></li>' +
            '<li><input type="text" id="fibreInput" placeholder="Fibre alimentaire (g)" /></li>' +
            '<li><input type="text" id="matieresInput" placeholder="Matières grasses (g)" /></li>' +
            '<li><input type="text" id="alcoolInput" placeholder="Alcool (ml)" /></li>' +
            '</ul>',
            '<div style="display: flex; flex-direction: column">'+
            '<span style="margin: 10px">' +
            '<select id="isLiquidInput">' +
            '<option value=""> Est-il liquide ?*</option>' +
            '<option value="0">Non liquide</option>' +
            '<option value="1">Liquide</option>' +

            '</select>' +
            '</span>' +
            '<span> <input type="checkbox" id="estIngredientCheckbox" > Ingrédient d\'un plat ?</span>' +
            // montrer les lignes qui suivent seulement si le checkbox est check
            '<div class="column ingredient-de-column" style="display:none;">' +
            'Ingredient de* : ' +
            '<select id="ingredientDeInput">' +
                '<option value="">Choisir un plat</option>' +
            alimentsTable.map(function(aliment) {
                return '<option value="' + aliment.id + '">' + aliment.nom + '</option>';
            }) +
            '</select>' +
            '</div>' +
            /*'<div class="column pourcentage-composition-column" style="display:none;">' +
            'Pourcentage de composition : ' +
            '<input type="text" id="pourcentageCompositionInput" placeholder="Pourcentage de l\'ingrédient*" />' +
            '</div>'+ */
            '</div>',// fin des lignes à montrer seulement si l'input est checked
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
    $('#ajouterAlimentsBtn').click(function () {
        if (count === 0) {
            ajouterLigne();
        } else {
            alert("Formulaire déjà présent, ajoutez d'abord votre aliment");
        }
    });



    // Gestionnaire d'événements pour la case à cocher "Est-il un ingrédient d'un plat ?"
    $(document).on('change', '#estIngredientCheckbox', function () {
        if ($(this).is(':checked')) {
            $('.ingredient-de-column').show();
            /*$('.pourcentage-composition-column').show();*/
        } else {
            $('.ingredient-de-column').hide();
            /*$('.pourcentage-composition-column').hide();*/
        }
    });


    $(document).on('click', '#annulerBtn', function(){
        count = 0;
        console.log(count);
        var lastIndex = table.rows().count() - 1;
        table.row(lastIndex).remove().draw(false);

    });



    // Gestionnaire d'événements pour le bouton "Valider"
    $(document).on('click', '#validerBtn', function () {
        // Récupérer les données des champs d'entrée
        console.log("test2");
        let ok = 0;

        var pourcentageComposition = $('#pourcentageCompositionInput').val();
        var ingredientDe = $('#ingredientDeInput').val();
        var isLiquid = $('#isLiquidInput').val();
        var sel = $('#selInput').val();
        var nom = $('#nomInput').val();
        var indiceNova = $('#indiceNovaInput').val();
        var energie = $('#energieInput').val();
        var sucre = $('#sucreInput').val();
        var proteines = $('#proteinesInput').val();
        var fibre = $('#fibreInput').val();
        var matieres = $('#matieresInput').val();
        var alcool = $('#alcoolInput').val();

        // on vérifie que les champs sont bien complétés
        if (nom == ""){
            alert("Veuillez completer le champs nom de l'aliment");
        }
        if (indiceNova === "") {
            indiceNova = 0;
        }
        if (energie == ""){
                energie = 0;
        }
        if (isLiquid === ""){
            alert("Veuillez indiquez s'il s'agit d'un liquide ou non");
        }
        if ( $('#estIngredientCheckbox').is(':checked') && ingredientDe =="" /*&& pourcentageComposition ==""*/){
            alert ("Veuillez completer les champs liées à l'ingrédient");
        }
            ok = 1;


        // Créer un objet avec les données
        var alimentData = {
            "nom": nom,
            "is_liquid": isLiquid, // Mettez la valeur appropriée
            "indice_nova": indiceNova,
            "energie_kcal": energie,
            "sel":sel,
            "sucre": sucre,
            "proteines": proteines,
            "fibre_alimentaire": fibre,
            "matieres_grasses": matieres,
            "alcool": alcool,
            "ingredient_de": [
                {
                    "id": ingredientDe,
                    "pourcentage_ingredient": pourcentageComposition,
                }
            ]
        };
        console.log(alimentData);
        if (ok === 1) {
            // Effectuer une requête AJAX pour ajouter l'aliment (à implémenter)
            ajouterAliment(alimentData);
        }
    });


    // Fonction pour effectuer la requête AJAX pour ajouter l'aliment
    function ajouterAliment(data) {
        $.ajax({
            url: prefixeEndpoint+"/backend/aliments.php",
            method: "POST", // Utilisez la méthode appropriée (POST, PUT, etc.)
            dataType: "json",
            data: JSON.stringify(data),
            contentType: "application/json",
        })
            .done(function(response) {
                // Traitement en cas de succès
                console.log("Aliment ajouté avec succès :", response);
                location.reload();
            })
            .fail(function(error) {
                // Traitement en cas d'échec
                console.error("Erreur lors de l'ajout de l'aliment :", error);
            });
    }


    //supprimé un aliment
    $(document).on('click', '#delete-Btn', function () {
        console.log("testeeeee");
        var idAliment = $(this).data('id'); // Récupérer l'ID de l'aliment à partir de l'attribut data-id
        if (confirm("Êtes-vous sûr de vouloir supprimer cet aliment ?")) {

            deleteAliment(idAliment);
        }
    });


    function deleteAliment(idAliment) {
        $.ajax({
            url: prefixeEndpoint+"/backend/aliments.php/"+idAliment,
            method: "DELETE", // Utilisez la méthode appropriée (POST, PUT, etc.)
            dataType: "json",
        })
            .done(function(response) {
                // Traitement en cas de succès
                console.log("Aliment supprimé avec succès :", response);
                location.reload();
            })
            .fail(function(error) {
                // Traitement en cas d'échec
                console.error("Erreur lors de la suppression de l'aliment id :"+ alimentsTable.find((nom) => idAliment), error);
            });
    }
});
