$(document).ready(function() {
    $('#register').click((event) => registerUser(event));
})

function registerUser(event) {
    event.preventDefault();

    if(
        $('#email').val().length < 1 ||
        $('nom').val().length < 1 ||
        $('age').val() ||
        $('sexe').val() ||
        $('poids').val() ||
        $('taille').val() ||
        $('sport').val() ||
        $('password').val() ||
        $('passwordConfirm').val()
    )
}