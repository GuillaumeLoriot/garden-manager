# Liste des pages

## Pages publiques
- Accueil avec barre de recherche (/)
- À propos (/about)
- Liste des familles (/families)
- Détail d’une famille (/families/{id})
- Liste des plantes (/plants)
- Détail d’une plante (/plants/{id})

## Pages privées (utilisateur connecté)
- Inscription (/register)
- Connexion (/login) et Déconnexion (/logout)
- Profil utilisateur (/user/{id})
- Modification du profil (/user/edit/{id})
- Gestion de la galerie d’images
  - Ajout / édition (/user/gallery/edit)
  - Suppression d’une image (/user/gallery/delete/{id})
- Gestion des zones (areas)
  - Liste des zones (/user/area/list)
  - Détail d’une zone (/user/area/{id})

## Pages d’administration (EasyAdmin)
- Tableau de bord admin (/admin)
  - CRUD Zones (Area)
  - CRUD Plantes (Plant)
  - CRUD Familles (Family)
  - CRUD Utilisateurs (User)
  - CRUD Images (Image)

# Liste des fonctionnalités

## Pages publiques
- Affichage des listes et détails des familles et des plantes
- Barre de recherche avec plusieurs filtres (paramétrage d’un event listener pour les filtres de période — voir explication dans la rubrique *Difficultés rencontrées*)
- Pagination
- Création d’un nouvel utilisateur

## Sécurité & authentification
- Connexion/déconnexion + contrôle d’accès via `security.yaml`

## Gestion du profil utilisateur
- Page de profil et modification utilisateur
- Galerie d’images visible dans le profil et éditable (ajout, suppression)
- Vue des zones de culture associées à l’utilisateur + plantes présentes dans les zones (ManyToMany)

## Administration (EasyAdmin)
- Dashboard admin
- CRUD avec formulaires personnalisés dans les `CrudController` admin pour chaque entité (masquage de certains champs dans l’index, affichage des images dans l’index, ajout du bouton "show" et d’icônes personnalisées)

## Infrastructure & outillage
- Import de vraies données via fixtures JSON (familles & plantes) et Faker
- Hashage des mots de passe via `EventListener`
- Service d’upload de fichiers (upload/suppression)
- Service de pagination

# Difficultés rencontrées

## Barre de recherche

J’ai rencontré plusieurs difficultés :

- J’avais décidé d’utiliser une classe pour récupérer les critères de recherche, car il y en avait beaucoup. Cette classe ressemble à une entité, mais n’en est pas une car elle n’est pas persistée en base. J’avais des erreurs avec `make:form`, car le maker attendait une entité. J’ai donc créé mon `FormType` à la main.

- Pour la recherche par période, j’ai enregistré dans la BDD des dates de début et de fin avec une année fictive (2000) car cela correspond à une période permettant des calculs. Dans ma classe et mon formulaire, j’avais besoin d’un champ `DateType` pour que l’utilisateur puisse choisir un jour et un mois, mais pas l’année.
![image](https://github.com/user-attachments/assets/bb365821-6b04-489c-bb99-c7c3fc1b3559)

  Le problème, c’est qu’on ne peut pas soumettre un formulaire avec uniquement le jour et le mois remplis. Dans le `FormType`, je ne pouvais pas fixer directement l’année. Je pouvais proposer une seule année dans la liste déroulante, mais l’utilisateur devait quand même la sélectionner manuellement.

  Je me suis d’abord dit que je pourrais récupérer le jour et le mois dans le contrôleur et y ajouter l’année, mais l’erreur apparaissait avant même d’atteindre le contrôleur, au moment de la soumission.

  J’ai finalement résolu ce problème avec un `EventListener` qui intervient au `PRE_SUBMIT` et transforme les données à ce moment-là.
  Ainsi, l’utilisateur choisit le jour et le mois, et j’ajoute automatiquement l’année 2000. J’ai aussi pu cacher le champ année dans le formulaire via le template.

- Dernier problème : la pagination (voir commentaire dans le `IndexController`).  
  D’après ce que j’ai compris, KnpPaginator recharge la page en refaisant la requête à chaque clic sur une page (2, 3, etc.). Ainsi, quand je passe à la page 2 des résultats de ma recherche (qui utilise la méthode GET), KnpPaginator n’avait plus les paramètres et ne renvoyait rien.  
  J’ai contourné le problème en lui renvoyant manuellement les données de recherche. Je pense qu’il y a une meilleure solution, mais je n’ai pas eu le temps de creuser davantage.

## Services

J’ai rencontré un gros problème avec la configuration de services dans `services.yaml`, notamment pour mes deux services : le paginator et l’upload de fichiers.

Pour l’upload (cas le plus parlant), je me suis basé sur la documentation Symfony. Même en suivant la doc, j’obtenais une erreur persistante. J’ai recréé l’erreur dans un fichier test pour te faire une capture d’écran (que je n’avais pas faite sur le moment).
![image](https://github.com/user-attachments/assets/3bf7515b-39a3-4c2a-ac32-1c19db5a9bb4) 

![image](https://github.com/user-attachments/assets/c3576d3f-44af-4abb-a534-d1df14c8cde4)

![image](https://github.com/user-attachments/assets/57bdf6f8-2636-4173-aec6-eabf9ddfbaec)

L’erreur venait du fait que je "type-hintais" une string dans le constructeur. Pourtant, le `yaml`, tel que configuré, devait fournir cette valeur. Peu importe ce que je mettais, l’erreur persistait. J’ai fini par sortir la string du constructeur pour la passer en paramètre à ma méthode.

Cela m’oblige désormais à spécifier un `$targetDirectory` à chaque appel de `upload()`. Finalement, ce n’est pas plus mal, car je peux définir dynamiquement le répertoire de destination en fonction du contexte.

J’ai eu le même problème avec mon service de pagination, où je "type-hintais" un integer dans le constructeur. J’ai appliqué la même solution.

# Conclusion

Voici les principales difficultés que j’ai rencontrées durant ce projet. Je considère qu’il n’est pas encore totalement terminé et mériterait des améliororations, mais il est très fonctionnel en l’état.

Par rapport aux objectifs définis au départ, j’ai ajouté :
- La pagination
- L’upload de fichiers
- Le début de la logique de gestion des zones d’un utilisateur (à terme, je souhaite que le système puisse signaler une incompatibilité si deux plantes non compatibles sont ajoutées à la même zone).

Dans le code, tu trouveras plusieurs commentaires à ton attention précisant certains points.
