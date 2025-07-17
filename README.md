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

