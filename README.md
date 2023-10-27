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
