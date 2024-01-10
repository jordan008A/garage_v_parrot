# ECF STUDI - Garage V.Parrot

## Lien vers le site déployé
https://garage-vincent-parrot-studi-d66e05141e08.herokuapp.com/
## Lien Trello
https://trello.com/b/bu46I5jQ/garage-vparrot

## Pour se connecter en tant qu'admin
- Email => vincent@parrot.fr
- Mot de passe => studi2023

## Prérequis avant installation
- Installation de XAMPP et démarrage des modules Apache & MySQL.
- Installation de PHP.
- Installation de Symfony CLI.
- Installation de Composer qui est un gestionnaire de dépendances pour PHP.
- Mise en place d'un gestionnaire de base de données comme PhpMyAdmin.
- Mise en place du service Cloud Amazon S3.
- Avoir accès à une passerelle SMTP vers une boîte mail (Pour la réinitialisation des mots de passes).

## Pour éxécuter le site en local
- Clonage du Répertoire GitHub :
  ```
  git clone https://github.com/jordan008A/garage_v_parrot.git 
  ```
- Accès au Répertoire du Projet :
  ```
  cd garage_v_parrot
  ```
- Renommez le fichier .env.example en .env

- Editez le fichier .env pour y ajouter les valeurs spécifiques à votre environnement

- Copiez le dossier public/assets/img sur votre bucket Amazon S3

- Modifier l'adresse from() dans src/Service/MailerService.php :
  ```
  ->from('VotreAdresseMail')
  ```
- Installation des dépendances :
  ```
  composer install
   ```
- Création de la Base de Données :
  ```
  php bin/console doctrine:database:create
  ```
- Création d'une migration :
  ```
  php bin/console make:migration
  ```
- Application de la migration : 
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
  :information_source:
  > Laissez-vous guider par les différentes questions.

- Démarrage du Serveur Symfony :
  ```
  symfony server:start
  ``` 

## Technologies utilisées
- languages => PHP, Javascript et CSS
- Framework => Symfony
- ORM => doctrine
- Moteur de template HTML => Twig
- Style => Boostrap
- Gestionnaires de dépendance => composer
- Système de gestion de base de données => Mysql
- Serveur web => Apache2
- Service Cloud => Amazon S3