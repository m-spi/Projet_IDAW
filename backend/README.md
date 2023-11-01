# API

> __Note :__\
> Tous les éléments renvoyés sont des json.\
> Tous les paramètres envoyés sont des json.

## Aliments

### __GET__ Récupérer un aliment en particulier

___/backend/aliments.php/{id}___

> Description :\
> Renvoi l'aliment spécifié par l'id dans l'URL.\
> Les valeurs des nutriments sont une proprtion (pourcentage).

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_,
  "result": {
    "aliment": {
      "id_aliment": _int_,
      "nom_aliment": _string_,
      "isliquid": _int_,
      "indice_nova": _int_,
      "energie_kcal": _float_,
      "sucre": _float_,
      "proteines": _float_,
      "fibre_alimentaire": _float_,
      "matieres_grasses": _float_,
      "alcool": _float_
    }
  }
}
```

### __GET__ Récupérer tous les aliments

___/backend/aliments.php___

> Description :\
> Renvoi tous les aliments.

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_,
  "result": {
    "aliments": [
      {
          "nom": _string_,
          "energie_kcal": _float_,
          "sucre": _float_,
          "proteines": _float_,
          "fibre_alimentaire": _float_,
          "alcool": _float_,
          "matieres_grasses": _float_
      },
      ...
    ]
  }
}
```

### __POST__ Ajouter un nouvel aliment

___/backend/aliments.php___

> Description :\
> Ajoute un nouvel élément dans les aliments.\
> Optionnellement un aliment ajouté peut être un composant d'un autre aliment.

__Paramètre POST :__

```json
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
```

> Note :\
> Si l'aliment ne compose pas d'autre aliments, le champ `ingredient_de` doit être un tableau vide.\
> Il ne peut pas être `null` !

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_,
  "result": {
    "id": _int_         # ID de l'aliment créé
  }
}
```

### __PUT__ Changer les paramètres d'un aliment

___/backend/aliments.php/{id}___

> Description :\
> Permet de changer le nom et/ou les valeurs des nutriments.

__Parmètre PUT :__
```json
{
  "energie_kcal": _float_,
  "sucre": _float_,
  "proteines": _float_,
  "fibre_alimentaire": _float_,
  "alcool": _float_,
  "matieres_grasses": _float_
}
```

> Note :\
> Tous les paramètres omis resteront inchangés.

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_,
  "result": [           # Tableau avec l'ensemble des noms des valeurs modifiées.
    _string_,
    ...
  ]
}
```

### __POST__ Faire d'un aliment, l'ingrédient d'un autre

___/backend/aliments.php___

> Description :\
> Permet de d'ajouter dans la base de données le fait qu'un aliment est ingrédient d'un autre.

__Paramètre POST :__
```json
{
  "id_aliment": _int_,
  "id_ingredient": _int_,
  "pourcentage_ingredient": _float_,
}
```

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_
}
```

### __DELETE__ Supprimmer un aliment

___/backend/aliments.php/{id}___

> Description :\
> Permet de supprimer un aliment de la base.

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_,
  "result": {
    "id": _int_         # ID de l'aliment supprimé.
  }
}
```

### __DELETE__ Supprimmer un ingredient d'un aliment

___/backend/aliments.php/ingredient/{id}___

> Description :\
> Permet de supprimer un ingrédient d'un aliment.

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_,
  "result": {
    "id": _int_         # ID de l'ingrédient supprimé.
  }
}
```
