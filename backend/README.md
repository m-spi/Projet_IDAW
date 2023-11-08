# API

> __Note :__\
> Tous les éléments renvoyés sont des json.\
> Tous les paramètres envoyés sont des json.

## Aliments

### __GET__ : Récupérer un aliment en particulier

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
      "id": _int_,
      "nom": _string_,
      "is_liquid": _int_,
      "indice_nova": _int_,
      "energie_kcal": _float_,
      "sel": _float_,
      "sucre": _float_,
      "proteines": _float_,
      "fibre_alimentaire": _float_,
      "matiere_grasses": _float_,
      "alcool": _float_,
      "ingredient_de": [
        _int_,                      // ID de l'aliment composé par celui-ci,
        ...
      ],
      "compose_par": [
        _int_,                      // ID de l'aliment qui compose celui-ci
        ...
      ]
    }
  }
}
```

### __GET__ : Récupérer tous les aliments

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
        "id": _int_,
        "nom": _string_,
        "is_liquid": _int_,
        "indice_nova": _int_,
        "energie_kcal": _float_,
        "sel": _float_,
        "sucre": _float_,
        "proteines": _float_,
        "fibre_alimentaire": _float_,
        "matieres_grasses": _float_,
        "alcool": _float_,
        "ingredient_de": [
          _int_,                      // ID de l'aliment composé par celui-ci,
          ...
        ],
        "compose_par": [
          _int_,                      // ID de l'aliment qui compose celui-ci
          ...
        ]
      },
      ...
    ]
  }
}
```

### __POST__ : Ajouter un nouvel aliment

___/backend/aliments.php___

> Description :\
> Ajoute un nouvel élément dans les aliments.\
> Optionnellement un aliment ajouté peut être un composant d'un autre aliment.

__Paramètre POST :__

```json
{
  "nom": _string_,
  "is_liquid": _int_,
  "indice_nova": _int_,
  "energie_kcal": _float_,
  "sel": _float_,
  "sucre": _float_,
  "proteines": _float_,
  "fibre_alimentaire": _float_,
  "alcool": _float_,
  "matieres_grasses": _float_,
  "ingredient_de": [
    {
      "id": _int_,
      "pourcentage_ingredient": _float_
    },
    ...
  ],
  "compose_par": [
    {
      "id": _int_,
      "pourcentage_ingredient": _float_
    },
    ...
  ]
}
```

> Note :\
> Si l'aliment ne compose pas d'autre aliments, le champ `ingredient_de` doit être un tableau vide.\
> Il ne peut pas être `null` !
> Même chose pour le `compose_par`

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_,
  "result": {
    "id": _int_         // ID de l'aliment créé
  }
}
```

### __PUT__ : Changer les paramètres d'un aliment

___/backend/aliments.php/{id}___

> Description :\
> Permet de changer le nom et/ou les valeurs des nutriments.

__Paramètre PUT :__
```json
{
  "nom": _string_,
  "indice_nova": _int_,
  "is_liquid": _int_,
  "energie_kcal": _float_,
  "sel": _float_,
  "sucre": _float_,
  "proteines": _float_,
  "fibre_alimentaire": _float_,
  "alcool": _float_,
  "matieres_grasses": _float_,
  "ingredient_de": [
    {
      "id_aliment": _int_,
      "pourcentage_ingredient": _float_
    },
    ...
  ],
  "compose_par": [
    {
      "id_ingredient": _int_,
      "pourcentage_ingredient": _float_
    },
    ...
  ]
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
  "result": [           // Tableau avec l'ensemble des noms des valeurs modifiées.
    _string_,           // Exemple : "energie_kcal=200"
    ...
  ]
}
```

### __POST__ : Faire d'un aliment, l'ingrédient d'un autre

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

### __DELETE__ : Supprimmer un aliment

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
    "id": _int_         // ID de l'aliment supprimé.
  }
}
```

### __DELETE__ : Supprimmer un ingredient d'un aliment

___/backend/aliments.php/{id_aliment}/ingredient/{id_ingredient}___

> Description :\
> Permet de supprimer un ingrédient d'un aliment.

#### Réponse

__Format :__
```json
{
  "http_status": _int_,
  "response": _string_,
  "result": {
    "id_aliment": _int_,
    "id_ingredient": _int_
  }
}
```

---

## Journal

> __Note__ :\
> Les String pour les dates sont sous le format 'YYYY-MM-DD HH:MM:SS.UUUUUU',
> les 'U' étant les microsecondes, ces derniers sont optionnels.

### __GET__ : Récupérer une entrée du journal

___/backend/journal.php/{id}___

> Description :\
> Renvoi l'entrée spécifié par l'id dans l'URL.

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "entree": {
            "id": _int_,
            "id_aliment": _int_,
            "id_user": _int_,
            "date": _string_,
            "quantite": float
        }
    }
}
```

### __GET__ : Récupérer tout le journal

___/backend/journal.php___

> Description :\
> Renvoi toutes les entrées du journal.

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "journal": [
            {
                "id": _int_,
                "id_aliment": _int_,
                "id_user": _int_,
                "date": _string_,
                "quantite": float
            },
            ...
        ]
    }
}
```

### __GET__ : Récupérer tout le journal d'un user en particulier

___/backend/journal.php/user/{id}___

> Description :\
> Renvoi toutes les entrées du journal d'un user en précisant son id dans l'URL.

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "journal": [
            {
                "id": _int_,
                "id_aliment": _int_,
                "id_user": _int_,
                "date": _string_,
                "quantite": float
            },
            ...
        ]
    }
}
```

### __POST__ : Créer une entrée

___/backend/journal.php___

> Description :\
> Ajoute une entrée au journal.

__Paramètre POST :__
```json
{
    "id_aliment": _int_,
    "id_user": _int_,
    "date": _string_,
    "quantite": float
}
```

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "id": _int_
    }
}
```

### __PUT__ : Mettre à jour une entrée

___/backend/journal.php/{id}___

> Description :\
> Met à jour une entrée du journal spécifiée par l'id dans l'URL.\
> Chaque paramètre est optionnel.

__Paramètre PUT :__
```json
{
    "id_aliment": _int_,
    "id_user": _int_,
    "date": _string_,
    "quantite": float
}
```

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": [             // Tableau avec l'ensemble des noms des valeurs modifiées.
        _string_,           // Exemple : "quantite=200"
        ...
    ]
}
```

### __DELETE__ : Supprimer une entrée

___/backend/journal.php/{id}___

> Description :\
> Supprime une entrée du journal.

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "id": _int_       // ID de l'entrée supprimé
    }
}
```

---

## Utilisateurs

### __GET__ : Récupérer un utilisateur

___/backend/users.php/{id}___

> Description :\
> Renvoi l'utilisateur spécifié par l'id dans l'URL.

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "utilisateur": {
            "id": _int_,
            "email": _string_,
            "password": _string_,
            "nom": _string_,
            "prenom": _string_,
            "age": _int_,
            "is_male": _bool_,
            "poids": _float_,
            "taille": _float_,
            "sport": _int_
        }
    }
}
```

### __GET__ : Récupérer tous les utilisateurs

___/backend/users.php___

> Description :\
> Renvoi tous les utilisateurs.

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "utilisateurs": [
            {
                "id": _int_,
                "email": _string_,
                "password": _string_,
                "nom": _string_,
                "prenom": _string_,
                "age": _int_,
                "is_male": _bool_,
                "poids": _float_,
                "taille": _float_,
                "sport": _int_
            },
            ...
        ]
    }
}
```

### __POST__ : Créer un utilisateur

___/backend/users.php___

> Description :\
> Crée un utilisateur.

__Paramètre POST :__
```json
{
    "email": _string_,
    "password": _string_,
    "nom": _string_,
    "prenom": _string_,
    "age": _int_,
    "is_male": _bool_,
    "poids": _float_,
    "taille": _float_,
    "sport": _int_
}
```

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "id": _int_
    }
}
```

### __PUT__ : Changer les attributs d'un utilisateur

___/backend/users.php/{id}___

> Description :\
> Modifie l'utilisateur spécifiée par l'id dans l'URL.\
> Chaque paramètre est optionnel.

__Paramètre PUT :__
```json
{
    "email": _string_,
    "password": _string_,
    "nom": _string_,
    "prenom": _string_,
    "age": _int_,
    "is_male": _bool_,
    "poids": _float_,
    "taille": _float_,
    "sport": _int_
}
```

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": [             // Tableau avec l'ensemble des noms des valeurs modifiées.
        _string_,           // Exemple : "quantite=200"
        ...
    ]
}
```

### __DELETE__ : Supprimer un utilisateur

___/backend/users.php/{id}___

> Description :\
> Supprime un utilisateur.

#### Réponse

__Format :__
```json
{
    "http_status": _int_,
    "response": _string_,
    "result": {
        "id": _int_       // ID de l'utilisateur supprimé
    }
}
```
