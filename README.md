# Projet_IDAW

School project

## Pages

### Header :
 - Nom  du site
 - Image
 - Menu horizontal
 - Bouton de déconnexion

### Footer :
 - Auteur (nous)
 - Menu

### connect.php :
 - Form de connexion.
 - Un bouton de connexion

> Note :
> Toutes les pages doivent redirect vers connect.php si non connecté.
> Et un bouton de déconnexion en header.

### index.php :
 - Dashboard avec bilan de conssommation. On pourrait mettre des graphiques.
 - ex : Sel/Calories/fruits et légumes sur les 7 derniers jours.
 - On doit pouvoir changer la période de visualisation.
 - Doit redirect vers connect.php si non connecté.

### profil.php :
 - Form : Infos perso du user.
 - Gestion du compte.
 - Paramètre : tranche d'âge, sexe, pratique [, poids, taille, IMC]

### aliments.php :
 - CRUD : les différents aliments possibles à mettre dans le journal.

### journal.php :
 - CRUD : Aliments conssommés.
 - Vérifier que l'aliment existe -> le sélectionner à partir d'une liste.
   - Date + heure + aliment + quantité (en grammes).

## API

> __Note :__
> Tous les éléments renvoyés sont des json.
> Tous les paramètres envoyés sont des json.

### Aliments

#### __GET__ /backend/api/aliments.php/{id}

> Description :
> Renvoi l'aliment spécifié par l'id dans l'URL.
> Les valeurs des nutriments sont une proprtion (pourcentage).

__Format :__

{
  "http_status": _int_,
  "response": _string_,
  "result": {
    "aliment": {
      "nom": _string_,
      "energie_kcal": _float_,
      "sucre": _float_,
      "proteines": _float_,
      "fibre_alimentaire": _float_,
      "alcool": _float_,
      "matieres_grasses": _float_
    }
  }
}

#### __GET__ /backend/api/aliments.php

> Description :
> Renvoi tous les aliments.

__Format :__

{
  "http_status": _int_,
  "response": _string_,
  "result": [
    {
      "aliment": {
        "nom": _string_,
        "energie_kcal": _float_,
        "sucre": _float_,
        "proteines": _float_,
        "fibre_alimentaire": _float_,
        "alcool": _float_,
        "matieres_grasses": _float_
      }
    },
    ...
  ]
}

#### __POST__ /backend/api/aliments.php

> Description :
> Ajoute un nouvel élément dans les aliments.
> Optionnellement un aliment ajouté peut être un composant d'un autre aliment.

__Paramètre POST :__

{
  "nom": _string_,
  "energie_kcal": _float_,
  "sucre": _float_,
  "proteines": _float_,
  "fibre_alimentaire": _float_,
  "alcool": _float_,
  "matieres_grasses": _float_,
  "ingredient_de": [
    {
      "id_aliment": _int_,
      "quantite": _float_
    },
    ...
  ]
}

> Note :
> Si l'aliment ne compose pas d'autre aliments, le champ __composition__ doit être un tableau vide.
