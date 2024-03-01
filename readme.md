## Vite 
``` bash
# Lancement du container
docker compose up -d
```
**Url :** http://0.0.0.0:3000/build/

## Ajout de eslint
``` bash
# Installantion des dépendances
docker compose run --rm node npm install

# Pour lancer eslint
docker compose run --rm node npm run lint
```

## Ajout de phpcs et phpstan
``` bash
# commandes phpcs
docker compose exec php composer run-script phpcs src
docker compose exec php composer run-script phpcbf src

# commande phpstan
docker compose exec php composer run-script phpstan src
```

# Annuaire d'entreprise

Ce projet est un petit annuaire d'entreprises.  
Il permet de lister plusieurs entreprises, et d'en voir leur bureaux et employées.

## Technologies utilisées
- PHP 8.2
- MariaDB 10
- Slim 4
- Eloquent 10

## Préréquis pour une installation local
- Docker
- Docker compose
- Git

## Installation local
1) Cloner le projet

2) Copier le fichier .env.example en .env, et l'alimenter 
`cp .env.example .env`

3) Installer les dépendances  
`docker compose run --rm php composer install`

4) Lancer le container  
`docker compose up`

## (re)Créer et alimenter la base de données
Il faut que le container database soit lancé pour effectuer ces commandes.
 
**Supprimer et re-créer la base de données**  
`dexec php bin/console db:create`   

**Alimenter la base de données**  
`dexec php bin/console db:populate`   

## Structure du projet
- **bin** : Contient le script permettant de lancer des commandes. 
- **config** : Contient les fichiers de configuration de l'application.
- **public** : Contient les fichiers accessibles publiquement
    - **assets** : Contient les fichiers css, js, images, etc.
- **src** : Contient le code source de l'application
    - **Console** : Contient les commandes de l'application
    - **Controller** : Contient les contrôleurs de l'application
    - **Models** : Contient les modèles de l'application
    - **Twig** : Contient les extension Twig de l'application
- **view** : Contient les fichiers .twig de l'application

