$(document).ready(function() {
    $.ajax({
        url: prefixeEndpoint+"/backend/users.php/"+user_id,
        method: "GET",
        dataType: "json"
    }).done(function(response) {
        const user = response.result.utilisateur;
        $('#inputEmail')[0].innerText = user.email;
        $('#inputNom')[0].innerText = user.nom;
        $('#inputPrenom')[0].innerText = user.prenom;
        $('#inputAge')[0].innerText = user.age;
        $('#inputPoids')[0].innerText = user.poids;
        $('#inputTaille')[0].innerText = user.taille;

        sexeInputs = $('#inputSexe').children('div').children();
        if(user.is_male)
            sexeInputs.children('[value="homme"]').attr('checked', true);
        else
            sexeInputs.children('[value="femme"]').attr('checked', true);

        sportInputs = $('#inputSport').children('div').children();
        switch (user.sport) {
            case 1:
                sportInputs.children('[value="1"]').attr('checked', true);
                break;
            case 2:
                sportInputs.children('[value="2"]').attr('checked', true);
                break;
            case 3:
                sportInputs.children('[value="3"]').attr('checked', true);
                break;
            default:
                break;
        }
    });

    placeHandlers();
});

function placeHandlers() {
    $('#modifier').click(() => modifier());
    $('#valider').click(() => valider());
}

function modifier() {
    $('.row').children('div').children().children().attr('disabled', false);
    $('#inputEmail').replaceWith(
        '<input class="card small-column" type="email" id="inputEmail" value="'+
        $('#inputEmail')[0].innerText+
        '">'
    );
    $('#inputNom').replaceWith(
        '<input class="card small-column" type="text" id="inputNom" value="'+
        $('#inputNom')[0].innerText+
        '">'
    );
    $('#inputPrenom').replaceWith(
        '<input class="card small-column" type="text" id="inputPrenom" value="'+
        $('#inputPrenom')[0].innerText+
        '">'
    );
    $('#inputAge').replaceWith(
        '<input class="card small-column" type="number" id="inputAge" value="'+
        $('#inputAge')[0].innerText+
        '">'
    );
    $('#inputPoids').replaceWith(
        '<input class="card small-column" type="number" id="inputPoids" value="'+
        $('#inputPoids')[0].innerText+
        '">'
    );
    $('#inputTaille').replaceWith(
        '<input class="card small-column" type="number" id="inputTaille" value="'+
        $('#inputTaille')[0].innerText+
        '">'
    );
    $('#inputSport').after(`
        <div class="row mb-4 plr-8 passwordInput">
          <b class="small-column">Changer de mot de passe :</b>
          <input class="card small-column" type="password" id="inputPassword">
        </div>
        <div class="row mb-4 plr-8 passwordInput">
          <b class="small-column">Confirmer le mot de passe :</b>
          <input class="card small-column" type="password" id="inputPasswordConfirm">
        </div>
    `);

    $('#modifier').replaceWith(`
            <button style="margin-left: auto;" class="side-btn" id="valider">
              Valider
            </button>
        `);

    placeHandlers();
}

function valider() {
    if($('#inputPassword').val().length){
        if($('#inputPassword').val() !== $('#inputPasswordConfirm').val()){
            alert('Les mots de passe ne correspondent pas');
            return;
        }
    }
    let is_male = $('input[name=sexe]:checked').val() == 'homme' ? true : false;
    let sport = $('input[name=sport]:checked').val()
    const data = {
        "email": $('#inputEmail').val(),
        "password": $('#inputPassword').val(),
        "nom": $('#inputNom').val(),
        "prenom": $('#inputPrenom').val(),
        "age": $('#inputAge').val(),
        "is_male": is_male,
        "poids": $('#inputPoids').val(),
        "taille": $('#inputTaille').val(),
        "sport": sport
    };

    $.ajax({
        url: prefixeEndpoint+"/backend/users.php/"+user_id,
        method: "PUT",
        dataType: "json",
        data: JSON.stringify(data),
        contentType: "application/json"
    }).done(function(response) {
        // Traitement en cas de succès
        console.log("Utilisateur mis à jour avec succès :", response);
    }).fail(function(error) {
        // Traitement en cas d'échec
        console.error("Erreur lors de la mise à jour de l'utilisateur :", error.responseJSON);
    });

    $('.row').children('div').children().children().attr('disabled', true);
    $('#inputEmail').replaceWith(
        '<p class="card small-column" id="inputEmail">'+
        $('#inputEmail').val()+'</p>'
    );
    $('#inputNom').replaceWith(
        '<p class="card small-column" id="inputNom">'+
        $('#inputNom').val()+'</p>'
    );
    $('#inputPrenom').replaceWith(
        '<p class="card small-column" id="inputPrenom">'+
        $('#inputPrenom').val()+'</p>'
    );
    $('#inputAge').replaceWith(
        '<p class="card small-column" id="inputAge">'+
        $('#inputAge').val()+'</p>'
    );
    $('#inputPoids').replaceWith(
        '<p class="card small-column" id="inputPoids">'+
        $('#inputPoids').val()+'</p>'
    );
    $('#inputTaille').replaceWith(
        '<p class="card small-column" id="inputTaille">'+
        $('#inputTaille').val()+'</p>'
    );
    $('.passwordInput').remove();

    $('#valider').replaceWith(`
            <button style="margin-left: auto;" class="side-btn" id="modifier">
              Modifier
              <i class="fas fa-pencil-alt"></i>
            </button>
        `);

    placeHandlers();
}