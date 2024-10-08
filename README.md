# Projet Symfony Recettes & Quizz
Bienvenue dans le projet Symfony Recette & Quizz ! Ce projet vous permet de créer, gérer et partager des recettes culinaires. Les utilisateurs peuvent s'inscrire, se connecter, ajouter leurs propres recettes, les modifier et les supprimer (seulement le créateur), commenter et noter les recettes des autres utilisateurs. De plus, le projet comprend un quizz pour rendre l'expérience encore plus divertissante.


## Fonctionnalités:

- **Authentification et Autorisation :** Les utilisateurs peuvent créer un compte, se connecter et se déconnecter. 

- **Gestion des Recettes :** Ajoutez, modifiez et supprimez vos propres recettes. Consultez les recettes créées par d'autres utilisateurs. Les actions de modification et de suppression de recettes sont autorisées uniquement pour le créateur de la recette.

- **Commentaires et Notations :** Les utilisateurs peuvent commenter et noter les recettes des autres utilisateurs.

- **Quizz :** Testez vos connaissances culinaires avec le quizz inclus.


## Arborescence des fichiers

**bin/ :** Contient le fichier console qui est le point d'entrée pour l'exécution de commandes Symfony en ligne de commande.

**config/ :** Contient les fichiers de configuration de l'application, tels que les routes, les services, etc.

**public/ :** Le répertoire public où sont stockés les fichiers accessibles depuis le navigateur, tels que les fichiers CSS, JS, images, etc.

**src/ :** Contient le code source de l'application, y compris les contrôleurs, les entités, les formulaires, les Repository etc.

**templates/ :** Les fichiers de template Twig utilisés pour générer les vues HTML de l'application.

**tests/ :** Le répertoire pour les tests unitaires et fonctionnels de l'application.

**vendor/ :** Le répertoire où Composer stocke les dépendances du projet.

**.env :** Le fichier de configuration pour les variables d'environnement.

**.gitignore :** Le fichier pour spécifier les fichiers et répertoires à ignorer lors du suivi des modifications avec Git.

**README.md :** Le fichier README du projet.      
      
## Technologies utilisées

- **Symfony**
- **PHP**
- **Composer**
- **MySQL**
- **Html**
- **CSS**
        


## Prérequis

Assurez-vous d'avoir installé les éléments suivants sur votre machine :

**PHP (version 7.4 ou supérieure)**  
**Composer**  
**Symfony CLI**  
**MySQL (ou un autre système de gestion de base de données pris en charge)**  

## Installation

**Cloner le Dépôt**
git clone https://github.com/boukaii/Symfony-Blog.git

**Accéder au Répertoire du Projet**
```bash
cd votre-projet
```
**Installer les Dépendances**
```bash
composer install
```
**Créer la Base de Données**
```bash
php bin/console doctrine:database:create
```
**Effectuer les Migrations**
```bash
php bin/console doctrine:migrations:migrate
```
**Démarrer le Serveur de Développement**
```bash
symfony server:start
```

Vous pouvez maintenant accéder à l'application dans votre navigateur à l'adresse http://localhost:8000.