$(document).ready(function () {
    /*function popMessage(message) {
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

    }*/

    let table = new DataTable('#alimentsDataTable');
    let alimentsTable = []; // stock l'id et le nom des aliments dans un tableau
    let count = 0; // compteur pour ajouter qu'une fois une ligne vide
    let enModification = 0;

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

                if (aliment.indice_nova != 0 && aliment.indice_nova !== "") {
                    nutrimentsData += '<li >Indice Nova : ' + aliment.indice_nova + '/4</li>';
                } else {
                    nutrimentsData += '<li>Indice Nova : Non renseigné </li>';
                }
                if (aliment.energie_kcal != 0 && aliment.indice_nova !== "") {
                    nutrimentsData += '<li >Énergie : ' + aliment.energie_kcal + 'kcal</li>';
                } else {
                    nutrimentsData += '<li>Énergie : Non renseigné </li>';
                }
                nutrimentsData +=
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
                    '<button class="action-button" id="modifier-Btn">' +
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
                ]).draw();
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

    // Fonction pour effectuer la requête AJAX pour ajouter l'aliment
    function ajouterAliment(data) {
        $.ajax({
            url: prefixeEndpoint+"/backend/aliments.php",
            method: "POST", // Utilisez la méthode appropriée (POST, PUT, etc.)
            dataType: "json",
            data: data,
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

    // Gestionnaire d'événements pour le bouton "Valider"
    $(document).on('click', '#validerBtn', function () {
            // Récupérer les données des champs d'entrée
            let ok = 1 ;

            var pourcentageComposition = $('#pourcentageCompositionInput').val();
            console.log("%" + pourcentageComposition);
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
            if (nom == "") {
                alert("Veuillez completer le champs nom de l'aliment");
                ok = 0;
            }
            if( indiceNova > 4){
                alert ("Indice Nova est entre 1 et 4");
                ok = 0;
            }
            if (indiceNova === "") {
                indiceNova = 0;

            }
            if (energie == "") {
                energie = 0;

            }
            if (isLiquid === "") {
                alert("Veuillez indiquez s'il s'agit d'un liquide ou non");
                ok = 0;
            }
            if ($('#estIngredientCheckbox').is(':checked') && ingredientDe == "" /*&& pourcentageComposition ==""*/) {
                alert("Veuillez completer les champs liées à l'ingrédient");
                ok = 0;
            }
                console.log(ok)
            // Créer un objet avec les données
            var alimentData = {
                "nom": nom,
                "is_liquid": isLiquid, // Mettez la valeur appropriée
                "indice_nova": indiceNova,
                "energie_kcal": energie,
                "sel": sel,
                "sucre": sucre,
                "proteines": proteines,
                "fibre_alimentaire": fibre,
                "matieres_grasses": matieres,
                "alcool": alcool,
                "ingredient_de": [
                    {
                        "id": ingredientDe,
                        "pourcentage_ingredient":0
                    }
                ],
                "compose_par": [
                ]
            };
            console.log(alimentData);
            console.log(typeof alimentData);
            if (ok === 1) {
                // Effectuer une requête AJAX pour ajouter l'aliment (à implémenter)
                var data = JSON.stringify(alimentData);
                console.log("data"+data);
                ajouterAliment(data);
            }

    });





    //supprimé un aliment
    $(document).on('click', '#delete-Btn', function () {
        console.log("testeeeee");
        var idAliment = $(this).data('id'); // Récupérer l'ID de l'aliment à partir de l'attribut data-id
        if (confirm("Êtes-vous sûr de vouloir supprimer cet aliment ? Cela supprimera tous les plats associé dans le journal")) {

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



    //modification d'un aliment
    // Fonction pour effectuer la requête AJAX pour mettre à jour l'aliment
    function modifierAliment(data,idAliment) {
        $.ajax({
            url: "http://localhost/Projet_IDAW/backend/aliments.php/" + idAliment,
            method: "PUT",
            dataType: "json",
            data: data,
            contentType: "application/json",
        })
            .done(function(response) {
                // Traitement en cas de succès
                console.log("Aliment mis à jour avec succès :", response);
                location.reload();
            })
            .fail(function(error) {
                // Traitement en cas d'échec
                console.error("Erreur lors de la mise à jour de l'aliment :", error);
            })

    }



    function trouverIdAlimentAvecNom(nomAliment) {

        var idAliment;
        alimentsTable.forEach(function(aliment) {
            if (aliment.nom == nomAliment) {
                idAliment = aliment.id;
            }
        });

        return idAliment;
    }

    function getAlimentByID(idAliment, callback) {
        $.ajax({
            url: "http://localhost/Projet_IDAW/backend/aliments.php/" + idAliment,
            method: "GET",
            dataType: "json"
        })
            .done(function(response) {
                callback(response);
            })
            .fail(function(error) {
                console.error("Erreur lors de la récupération des données de l'aliment : ", idAliment, error);
            });
    }

    function trouverNomAlimentAvecId(idIngredient) {
        var nomIngredient = "Inconnu";
        alimentsTable.forEach(function(aliment) {
            if (aliment.id == idIngredient) {
                nomIngredient = aliment.nom;
            }
        });
        return nomIngredient;
    }

    function transformerLigneEnInputs(row) {
        var data = row.find('td'); // Sélectionnez les cellules dans la ligne
        var nomAliment = $(data[0]).text();
        var idAliment = trouverIdAlimentAvecNom(nomAliment);
//on fait un get pour recup les infos et remplir les champs
        getAlimentByID(idAliment, function(alimentData) {
            console.log("Données de l'aliment du getById pour remplir les champs " + nomAliment + " : ", alimentData);

            var inputs = '<td><input type="text" id="newNomInput" value="' + nomAliment + '" placeholder="Nom de l\'aliment*"/><input type="hidden" id="idAliment" value="'+idAliment+'"/></td>';
            inputs += '<td><ul>' +
                '<li><label>Indice Nova (sur 4)  </label><input class="modifyInput" type="text" id="newIndiceNovaInput" value="' + alimentData.result.aliment.indice_nova + '" placeholder="Indice Nova" /></li>' +
                '<li><label>Energie (en kcal)  </label><input class="modifyInput" type="text" id="newEnergieInput" value="' + alimentData.result.aliment.energie_kcal + '" placeholder="Energie (kcal)" /></li>' +
                '<li><label>Sel (g) </label><input class="modifyInput" type="text" id="newSelInput" value="' + alimentData.result.aliment.sel + '" placeholder="Sel (g)" /></li>' +
                '<li><label>Sucre (g)  </label><input class="modifyInput" type="text" id="newSucreInput" value="' + alimentData.result.aliment.sucre + '" placeholder="Sucre (g)" /></li>' +
                '<li><label>Protéines (g)   </label><input class="modifyInput" type="text" id="newProteineInput" value="' + alimentData.result.aliment.proteines + '" placeholder="Protéines (g)" /></li>' +
                '<li><label>Fibre Alimentaire (g) </label><input class="modifyInput" type="text" id="newFibreAlimentaireInput" value="' + alimentData.result.aliment.fibre_alimentaire + '" placeholder="Fibre Alimentaire (g)" /></li>' +
                '<li><label>Matière grasse (g)  </label><input class="modifyInput" type="text" id="newMatiereGrasseInput" value="' + alimentData.result.aliment.matieres_grasses + '" placeholder="Matière grasse (g)" /></li>' +
                '<li><label>Alcool (en %)  </label><input class="modifyInput" type="text" id="newAlcoolInput" value="' + alimentData.result.aliment.alcool + '" placeholder="Alcool (en %)" /></li>' +
                '</ul></td>';

            inputs += '<td>' +
                '<div style="display: flex; flex-direction: column">' +
                '<span style="margin: 10px">' +
                '<select id="newIsLiquidInput">';

            if (alimentData.result.aliment.is_liquid === 0) {
                inputs += '<option value="0">Non liquide</option>' +
                    '<option value="1">Liquide</option>';
            } else {
                inputs += '<option value="1">Liquide</option>' +
                    '<option value="0">Non liquide</option>';
            }

            inputs += '</select>' +
                '</span>' +
                '<span>';

            /*if (alimentData.result.aliment.ingredient_de.length > 0) {
                inputs += '<input type="checkbox" id="estIngredientCheckbox" checked> Ingrédient d\'un plat ?</span>';

            } */
            inputs += '<input type="checkbox" id="estIngredientCheckbox"> Ingrédient d\'un plat ?</span>';


            inputs += '<div class="column ingredient-de-column" style="display:none;">' +
                'Ingredient de* : ' +
                '<select id="newIngredientDeInput">'+
            '<option value=""> Choisir un plat/aliment </option>'
            /*if (alimentData.result.aliment.ingredient_de.length > 0) {
              inputs += '<option value="' + alimentData.result.aliment.ingredient_de[0] + '">' + trouverNomAlimentAvecId(alimentData.result.aliment.ingredient_de[0]) +'</option>
            }*/

            inputs += alimentsTable.map(function(aliment) {
                return '<option value="' + aliment.id + '">' + aliment.nom + '</option>';
            }).join('');  // Utilisez join('') pour fusionner les éléments du tableau en une chaîne.

            inputs += '</select>' +
                '</div></div></td>';

            row.html(inputs);


            var buttons =  '<div class="action-button-container" style="display: flex ; flex-direction: column; height: 150px; margin:60px" >' +
                '<button class="action-button" id="validerModificationBtn"> Valider ' +
                '</button>' +
                '<button class="action-button" id="annulerModificationBtn"> Annuler' +
                '</button>' +
                '</div>'
                + '<span class="italic" >Les champs avec un * sont obligatoires</span>'
            row.append(buttons);
        });
    }


    $(document).on('click', '#modifier-Btn', function() {
        if (count != 0){
            alert ("Une seule action à la fois annulé d'abord l'ajout");
        } else {
            enModification = 1;
            var row = $(this).closest('tr'); // Obtenez la ligne que vous souhaitez modifier
            transformerLigneEnInputs(row);
        }
    });
    $(document).on('click', '#annulerModificationBtn', function() {
        location.reload();
    });
    $(document).on('click', '#validerModificationBtn', function() {
        let modifOk = 1;
        var pourcentageComposition = $('#pourcentageCompositionInput').val();
        var newIngredientDe = $('#newIngredientDeInput').val();
        var newIsLiquid = $('#newIsLiquidInput').val();
        var newsel = $('#newSelInput').val();
        var newNom = $('#newNomInput').val();
        var newIndiceNova = $('#newIndiceNovaInput').val();
        var newEnergie = $('#newEnergieInput').val();
        var newSucre = $('#newSucreInput').val();
        var newProteines = $('#newProteinesInput').val();
        var newFibre = $('#newFibreAlimentaireInput').val();
        var newMatieres = $('#newMatiereGrasseInput').val();
        var newAlcool = $('#newAlcoolInput').val();
        var idAliment = $('#idAliment').val();

        // on vérifie que les champs sont bien complétés
        if (newNom == "") {
            alert("Veuillez completer le champs nom de l'aliment");
            modifOk = 0;
        }
        if( newIndiceNova > 4){
            alert ("Indice Nova est entre 1 et 4");
            modifOk = 0;
        }
        if (newIndiceNova === "") {
            indiceNova = 0;

        }
        if (newEnergie == "") {
            energie = 0;

        }
        if (newIsLiquid === "") {
            alert("Veuillez indiquez s'il s'agit d'un liquide ou non");
            modifOk = 0;
        }
        if ($('#estIngredientCheckbox').is(':checked') && newIngredientDe == "" /*&& pourcentageComposition ==""*/) {
            alert("Veuillez completer les champs liées à l'ingrédient");
            modifOk = 0;
        }


        // Créer un objet avec les données
        var newAliment = {
            "nom": newNom,
            "is_liquid": newIsLiquid,
            "indice_nova": newIndiceNova,
            "energie_kcal": newEnergie,
            "sel": newsel,
            "sucre": newSucre,
            "proteines": newProteines,
            "fibre_alimentaire": newFibre,
            "matieres_grasses": newMatieres,
            "alcool": newAlcool,
            "ingredient_de": [
                {
                    "id_aliment": newIngredientDe,
                    "pourcentage_ingredient":0
                }
            ],
            "compose_par": []
        };

        if (newAliment.ingredient_de[0].id_aliment === "" || newAliment.ingredient_de[0].id_aliment === null || newAliment.ingredient_de[0].id_aliment === undefined) {
            // Crée un nouvel newAliment avec "ingredient_de" comme un tableau vide
            newAliment = {
                "nom": newNom,
                "is_liquid": newIsLiquid,
                "indice_nova": newIndiceNova,
                "energie_kcal": newEnergie,
                "sel": newsel,
                "sucre": newSucre,
                "proteines": newProteines,
                "fibre_alimentaire": newFibre,
                "matieres_grasses": newMatieres,
                "alcool": newAlcool,
                "ingredient_de": [],
                "compose_par": []
            };
        }

        console.log(idAliment);


        console.log(modifOk);
        if (modifOk == 1) {
            console.log("newAliment: " + JSON.stringify(newAliment));
            // Effectuer une requête AJAX pour ajouter l'aliment (à implémenter)
            modifierAliment(JSON.stringify(newAliment),idAliment);
        }
    })
});
