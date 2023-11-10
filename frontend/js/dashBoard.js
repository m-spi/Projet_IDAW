$(document).ready(function () {
    console.log("22");
    var click=0;
    var table = $('#dashBoardDataTable').DataTable();
    $('.chart-button').on('click', function () {
        if (click ==0) {
            alert("Veuillez d'abord selectionner la durée du bilan dans \"Selectioner un bilan\"");
        }

    });

    filterDataByDuration(7, table,"sucre")// par default on affiche l'évolution du sucre
        .then(function ({total, dataByNutrient }) {
            console.log("Bilan: ", total);
            var userGender = returnUserGender(id_user);
            console.log("usergender :", userGender);
            Recommendations(7, total, userGender);
            //graphique
            console.log("data",dataByNutrient);
            createChart(7,dataByNutrient,"sucre");
            createBarChart(7,dataByNutrient,"sucre");

            $('.duration-button').on('click', function () {
                click++;
                var duration = $(this).data('duration');
                $('#selectedBtn').text('Bilan pour les ' + duration + ' derniers jours');
                filterDataByDuration(duration,table,"sucre")
                    .then(function ({total, dataByNutrient }) {
                        var userGender = returnUserGender(id_user);
                        Recommendations(duration, total, userGender);
                    })
                    .catch(function (error) {
                        console.error("Erreur lors de la récupération des données : ", error);
                    });
                $('.chart-button').on('click', function () {
                    console.log("click");
                    var nutriment = $(this).data('nutriment');
                    $('#selectedChartBtn').text('Bilan consommation '+nutriment);
                    filterDataByDuration(duration,table,nutriment)
                        .then(function ({total, dataByNutrient }) {
                            createChart(duration, dataByNutrient,nutriment);
                            createBarChart(duration, dataByNutrient,nutriment);
                        })
                        .catch(function (error) {
                            console.error("Erreur lors e la récupération des données pour le graphique : ", error);
                        });

                });
            });
        })
        .catch(function (error) {
            console.error("Erreur lors de la récupération des données : ", error);
        });
});

function filterDataByDuration(duration, table, nutriment) {
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
                            total.sucre +=( ((platTrouve.sucre)*plat.quantite)/100);
                            total.sel +=  parseFloat((platTrouve.sel*plat.quantite)/100);
                            total.energie +=  parseFloat((platTrouve.energie_kcal*plat.quantite)/100);
                            total.fibre +=  parseFloat((platTrouve.fibre_alimentaire*plat.quantite)/100);
                            total.matiereGrasse += parseFloat((platTrouve.matieres_grasses*plat.quantite)/100);
                            total.proteines += parseFloat((platTrouve.proteines*plat.quantite)/100);
                        });
                        Object.keys(total).forEach(function (key) {
                            total[key] = parseFloat(total[key]).toFixed(2);
                        });
                        console.log(journalFiltre,aliment);
                        var dataByNutrient = prepareDataForChart(journalFiltre,aliment,nutriment);
                        console.log("dataNutriment   ",dataByNutrient);
                        updateDataTable(total, table);
                        resolve({ total: total, dataByNutrient: dataByNutrient });

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

//fonction pour Dashboard graphique

function generateLabels(duration) { //tableau avec les dates
    var labels = [];
    var today = new Date();

    for (var i = duration - 1; i >= 0; i--) {
        var date = new Date(today);
        date.setDate(today.getDate() - i);
        labels.push((date.toISOString().split('T')[0]));
    }

    return labels;
}
function changeDateType(dates) {
    var months = [
        "janv", "fév", "mars", "avril", "mai", "juin",
        "juil", "août", "sept", "oct", "nov", "déc"
    ];

    return dates.map(function (dateStr) {
        var parts = dateStr.split("-");
        var day = parseInt(parts[2], 10);
        var month = months[parseInt(parts[1], 10) - 1];
        return day + " " + month;
    });
}
function prepareDataForChart(journal, aliment, selectedNutriment) {
    var dataNutriment = {};
    var result = [];

    journal.forEach(function (entry) {
        var platTrouve = aliment.find(function (alim) {
            return alim.id == entry.id_aliment;
        });

        if (platTrouve && platTrouve[selectedNutriment] !== undefined) {
            var dateKey = entry.date.split(' ')[0];

            if (!dataNutriment[dateKey]) {
                dataNutriment[dateKey] = 0;
            }

            // Ajoute la quantité spécifique du nutriment sélectionné
            dataNutriment[dateKey] += parseFloat(platTrouve[selectedNutriment]) * entry.quantite;
        }
    });

    // Convertit l'objet en tableau avec des entrées non redondantes
    for (var date in dataNutriment) {
        result.push({
            date: date,
            quantity: dataNutriment[date].toFixed(2),
        });
    }

    return result;
}

function getNutrient(nutrientData, labels) {
    console.log("nutriment",nutrientData);
    var data = new Array(labels.length).fill(0);

    nutrientData.forEach(function (entry) {
        var index = labels.indexOf(entry.date);

        if (index !== -1) {
            data[index] = entry.quantity;
        }
    });
    console.log("getNutrient",data);
    return data;
}
var ctx = document.getElementById('myBilanChart').getContext('2d');
var barCtx = document.getElementById('myBarBilanChart').getContext('2d');

function createChart(duration, data, nutriment) {

    var labels = generateLabels(duration);
    console.log("createChart", getNutrient(data,labels));


    var dataset = {
        label: nutriment,
        data: getNutrient(data,labels),
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    };

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: changeDateType(labels),
            datasets: [dataset]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
function createBarChart(duration, data, nutriment) {

    var labels = generateLabels(duration);
    console.log("createChart", getNutrient(data,labels));


    var dataset = {
        label: nutriment,
        data: getNutrient(data,labels),
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    };

    var myChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: changeDateType(labels),
            datasets: [dataset]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

