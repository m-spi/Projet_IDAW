$(document).ready(function() {
    $('#register').click((event) => registerUser(event));
})

function registerUser(event) {
    event.preventDefault();

    if(
        $('#email').val().length < 1 ||
        $('#nom').val().length < 1 ||
        $('#age').val().length < 1 ||
        $('#poids').val().length < 1 ||
        $('#taille').val().length < 1 ||
        $('#sexe option:selected').val().length < 1 ||
        $('#sport option:selected').val().length < 1 ||
        $('#password').val().length < 1 ||
        $('#passwordConfirm').val().length < 1
    ){
        alert('Veuillez renseigner tous les champs.');
    }else if($('#password').val() !== $('#passwordConfirm').val()){
        alert('Les mots de passe ne correspondent pas.');
    }else{
        const is_male = $('#sexe option:selected').val() === 'homme' ? 1 : 0;
        const sport = $('#sport option:selected').val();
        const data = {
            "email": $('#email').val(),
            "password": $('#password').val(),
            "nom": $('#nom').val(),
            "prenom": $('#prenom').val(),
            "age": $('#age').val(),
            "is_male": is_male,
            "poids": $('#poids').val(),
            "taille": $('#taille').val(),
            "sport": sport
        }
        console.log(data);

        $.ajax({
            url: prefixeEndpoint+"/backend/users.php",
            method: "POST",
            dataType: "json",
            data: JSON.stringify(data),
            contentType: "application/json"
        }).done(function(response) {
            // Traitement en cas de succès
            console.log("Utilisateur créer avec succès :", response);
            window.location.replace(prefixeEndpoint+"/frontend/php/login.php");
        }).fail(function(error) {
            // Traitement en cas d'échec
            console.error("Erreur lors de la création de l'utilisateur :", error);
        });
    }
}