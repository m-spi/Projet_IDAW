$(document).ready(function () {
    var table = $('#dashBoardDataTable').DataTable();
    filterDataByDuration(7, table)
        .then(function (bilan) {
            console.log("Bilan: ", bilan);
            var userGender = returnUserGender(id_user);
            console.log("usergender :", userGender);
            Recommendations(7, bilan, userGender);

            $('.duration-button').on('click', function () {
                var duration = $(this).data('duration');
                filterDataByDuration(duration, table)
                    .then(function (bilan) {
                        console.log("Bilan: ", bilan);
                        var userGender = returnUserGender(id_user);
                        Recommendations(duration, bilan, userGender);
                    })
                    .catch(function (error) {
                        console.error("Erreur lors de la récupération des données : ", error);
                    });
            });
        })
        .catch(function (error) {
            console.error("Erreur lors de la récupération des données : ", error);
        });
});

function filterDataByDuration(duration, table) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: prefixeEndpoint + "/backend/journal.php/user/" + id_user,
            method: "GET",
            dataType: "json",
        })
            .done(function (responseJournal) {
                var journal = responseJournal.result.journal;
                var journalFiltre = [];
                journal.forEach(function (journalEntree) {
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

                        journalFiltre.forEach(function (plat) {
                            var platTrouve = aliment.find(function (alim) {
                                return alim.id == plat.id_aliment;
                            });
                            //console.log("aliment"+ JSON.stringify(platTrouve));
                            total.sucre += parseFloat(platTrouve.sucre);
                            total.sel += parseFloat(platTrouve.sel);
                            total.energie += parseFloat(platTrouve.energie_kcal);
                            total.fibre += parseFloat(platTrouve.fibre_alimentaire);
                            total.matiereGrasse += parseFloat(platTrouve.matieres_grasses);
                        });
                        Object.keys(total).forEach(function (key) {
                            total[key] = parseFloat(total[key]).toFixed(2);
                        });
                        updateDataTable(total, table);
                        resolve(total);
                    })
                    .fail(function (error) {
                        reject(error);
                    });
            })
            .fail(function (error) {
                reject(error);
            });
    });
}

function isDateInPeriod(dateStr, periodInDays) {
    var currentDate = new Date();
    var dateToCheck = new Date(dateStr);
    var timeDiff = currentDate - dateToCheck;
    var daysDiff = timeDiff / (1000 * 3600 * 24);

    return daysDiff <= periodInDays;
}

function updateDataTable(data, table) {
    table.clear().draw();

    table.row.add([
        data.energie, data.sucre, data.sel, data.matiereGrasse, data.fibre, data.proteines
    ]).draw(false);
}


//Partie lie au recommandation
var quotasNutriments1jour = {
    'femme': {
        'sel': 5,
        'sucre': 25,
        'energie': 2000,
        'fibre': 25,
        'proteine': 53.6, //seuil minimal
        'matiere_grasse': 100,
    },
    'homme': {
        'sel': 5,
        'sucre': 37.5,
        'energie': 2500,
        'fibre': 38,
        'proteine': 64.8,
        'matiere_grasse': 111,
    }
};


function returnUserGender(id_user) {
    var userGender;
    $.ajax({
        url: prefixeEndpoint + "/backend/users.php/" + id_user,
        method: "GET",
        dataType: "json",
        async: false, // Assurez-vous que cette requête est synchrone
    })
        .done(function (response) {
            userGender = response.result.utilisateur.is_male;
            console.log("usergender.done"+userGender)
        })
        .fail(function (error) {
            alert("La requête pour obtenir le genre de l'utilisateur a échoué : " + error);
        });

    return userGender;
}

function displayRecommendation(message, enSavoirPlusLink) {
    var recommendationHtml = '';
    recommendationHtml += '<div class="col-xl-3 col-md-6 ">' +
        '<div class="card text-white mb-4 recommendation">' +
        '<div class="card-body recoSize">' + message + '</div>' +
        '<div class="card-footer d-flex align-items-center justify-content-between">' +
        '<a class="small text-white stretched-link" href="' + enSavoirPlusLink + '">En savoir plus</a>' +
        '<div class="small text-white"><i class="fas fa-angle-right"></i></div>' +
        '</div>' +
        '</div>' +
        '</div>';
    return recommendationHtml;
}

function Recommendations(duration, bilanData, userGender) {
    var recommendationHtml =''; // Initialisez la chaîne HTML vide
    console.log(bilanData);
    if (bilanData) {
        var quotas = userGender === 1 ? quotasNutriments1jour['homme'] : quotasNutriments1jour['femme'];

        if (parseFloat(bilanData.sel) > quotas.sel * duration) {
            recommendationHtml += displayRecommendation("Attention vous avez consommé trop de sel !", "/Projet_IDAW/frontend/php/index.php?page=warningSel");
            console.log("je suis dans if sel");
        }
        if (parseFloat(bilanData.sucre) > quotas.sucre * duration) {
            recommendationHtml += displayRecommendation("Attention vous avez consommé trop de sucre !", "/Projet_IDAW/frontend/php/index.php?page=warningSucre");
            console.log("je suis dans if sucre");
            console.log(recommendationHtml);
        }
        if (parseFloat(bilanData.energie) > quotas.energie * duration) {
            recommendationHtml += displayRecommendation("Attention vous avez consommé trop de calories !", "/Projet_IDAW/frontend/php/index.php?page=warningEnergie");
            console.log("je suis dans if energie");
        }
        if (parseFloat(bilanData.matieresGrasses )> quotas.matiere_grasse * duration) {
            recommendationHtml += displayRecommendation("Attention vous avez consommé trop de matière grasse !", "/Projet_IDAW/frontend/php/index.php?page=warningMatiereGrasse");
            console.log("je suis dans if matiere grasse");
        }
        if (parseFloat(bilanData.proteines) > quotas.proteine * duration) {
            recommendationHtml += displayRecommendation("Attention vous avez consommé trop de protéines !", "/Projet_IDAW/frontend/php/index.php?page=warningProteine");
            console.log("if proteine");
        }
        if (parseFloat(bilanData.fibre) < ((quotas.fibre) * duration)) {
            recommendationHtml += displayRecommendation("Attention vous ne consommez pas assez de fibres alimentaires !", "../../php/warningFibreAlimentaire.php")
            console.log("if fibre");
        }
        console.log("reco"+recommendationHtml)
    }
    $('#recommendationContainer').html(recommendationHtml);
}
