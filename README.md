# ECF STUDI - Garage V.Parrot

## Lien vers le site déployé

## Lien Trello
https://trello.com/b/bu46I5jQ/garage-vparrot

## Pour se connecter en tant qu'admin
- Email => vincent@parrot.fr
- Mot de passe => studi2023

## Prérequis avant installation
- Installation de XAMPP et démarrage des modules Apache & MySQL.
- Installation de PHP.
- Installation de Composer qui est un gestionnaire de dépendances pour PHP.
- Mise en place d'un gestionnaire de base de données comme PhpMyAdmin.

## Pour éxécuter le site en local
- Clonage du Répertoire GitHub :
  ```
  git clone https://github.com/jordan008A/garage_v_parrot.git cd garage_v_parrot
  ```
  - Accès au Répertoire du Projet :
  ```
  cd garage_v_parrot
  ```
- Modifiez le fichier .env ou .env.local avec vos informations de base de données dans DATABASE_URL.
- Installation des dépendances
  ```
  composer install
   ```
- Création de la Base de Données :
  ```
  php bin/console doctrine:database:create
  ```
- Application des Migrations : 
  ```
  php bin/console doctrine:migrations:migrate
  ```
- Chargement des Données (Fixtures) :
  ```
  php bin/console doctrine:fixtures:load
  ``` 
  - Utilisez la commande personnalisée pour créer un administrateur :
  ```
  php bin/console app:create-admin
  ``` 
  :information_source: :information_source: :information_source:
> Laissez-vous guider par les différentes questions.
    - Démarrage du Serveur Symfony :
  ```
  symfony server:start
  ``` 

## Technologies utilisées
- languages => PHP, Javascript et CSS
- Framework => Symfony
- ORM => doctrine
- moteur de template HTML => Twig
- Style => Boostrap
- gestionnaires de dépendance => composer
- Système de gestion de base de données => Mysql
- server web => Apache2