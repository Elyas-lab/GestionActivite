# Système de Gestion des Activités avec Symfony

## Description

Ce projet est une application web développée avec Symfony, un framework PHP, conçue pour la gestion des activités, des projets, des tâches et des utilisateurs. Elle offre une plateforme efficace pour suivre et gérer les différentes tâches et projets au sein d'une organisation.

## Objectif

Les objectifs principaux de ce projet sont :

- Faciliter la gestion efficace des activités et des projets.
- Simplifier le suivi des tâches et la collaboration entre les équipes.
- Fournir une plateforme conviviale pour gérer les ressources et les flux de travail.


## Principales Technologies

- **Langages** : PHP (version minimum 8.1)
- **Frameworks/Bibliothèques** : Symfony 6.4
- **Base de données** : Doctrine ORM pour les interactions avec la base de données (support pour Oracle et autres SGBD)
- **Frontend** : Twig pour le rendu des templates
- **Outils** : Composer pour la gestion des dépendances
- **Serveur Web** : Apache (via WAMP Server) ou autre serveur compatible


## Organisation du Code

Le projet est structuré comme suit :

### Répertoires

- **`assets`** : Contient les fichiers JavaScript, les styles CSS et les contrôleurs Stimulus pour la gestion du frontend.
- **`bin`** : Contient les fichiers exécutables comme `console` et `phpunit`.
- **`config`** : Fichiers de configuration pour les bundles, les packages, les routes, les services, etc.
- **`migrations`** : Fichiers de migration pour la gestion du schéma de base de données.
- **`public`** : Point d'entrée web (`index.php`) et ressources statiques.
- **`src`** : Code source PHP organisé en contrôleurs, entités, écouteurs d'événements, exceptions, formulaires, référentiels, sécurité, services, traits, et types.
- **`templates`** : Templates Twig pour le rendu des vues.
- **`tests`** : Fichiers de tests unitaires et fonctionnels.


### Autres fichiers

- `.env` : Configuration des environnements.
- `.gitignore` : Exclusions pour le suivi Git.
- `composer.json` : Définition des dépendances.


## Dépendances

Les principales dépendances définies dans `composer.json` incluent Doctrine ORM, composants Symfony, Twig, PHPStan, et d'autres bibliothèques fournissant des fonctionnalités supplémentaires.

## Configuration et Déploiement

### Prérequis Généraux

- PHP >= 8.1
- Composer
- CLI Symfony (optionnel pour le développement)
- Serveur Web (Apache, Nginx, etc.)
- Base de données (MySQL, PostgreSQL, Oracle, etc.)


### Installation

1. Clonez le dépôt :

```shellscript
git clone <url-du-dépôt>
cd <répertoire-du-projet>
```


2. Installez les dépendances :

```shellscript
composer install
```


3. Configurez votre environnement dans le fichier `.env`.
4. Créez la base de données et exécutez les migrations :

```shellscript
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```




### Configuration avec Apache et Virtual Hosts sur WAMP

1. Ouvrez le fichier de configuration des Virtual Hosts d'Apache :

```plaintext
C:\wamp64\bin\apache\apache2.x.x\conf\extra\httpd-vhosts.conf
```


2. Ajoutez un bloc `<VirtualHost>` pour votre projet :

```plaintext
<VirtualHost *:80>
    ServerName GestionActivite
    DocumentRoot "C:/wamp64/www/GestionActivite/public/"
    
    <Directory "C:/wamp64/www/GestionActivite/public/">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```


3. Modifiez le fichier hosts de Windows :

1. Ouvrez `C:\Windows\System32\drivers\etc\hosts` en tant qu'administrateur.
2. Ajoutez la ligne suivante :

```plaintext
127.0.0.1 GestionActivite
```





4. Redémarrez les services Apache de WAMP.
5. Accédez à votre projet via `http://GestionActivite` dans votre navigateur.


## Configuration Oracle

### Prérequis pour Oracle

- Oracle Database (version 12c ou supérieure recommandée)
- Extension PHP OCI8
- Package Doctrine DBAL Oracle


### Installation des Prérequis Oracle

1. Installez l'extension OCI8 pour PHP :

```shellscript
# Pour Windows (via PECL)
pecl install oci8

# Pour Linux
sudo pecl install oci8
```


2. Activez l'extension dans votre `php.ini` :

```ini
extension=oci8
```




### Configuration de la Connexion Doctrine pour Oracle

Modifiez votre fichier `.env` pour configurer la connexion Oracle :

```plaintext
DATABASE_URL="oracle://utilisateur:mot_de_passe@(DESCRIPTION=(HOST=adresse_serveur)(PORT=1521)(SERVICE_NAME=nom_service))"
```

Dans votre `config/packages/doctrine.yaml`, ajoutez la configuration spécifique :

```yaml
doctrine:
    dbal:
        url: '%env(resolve:DATABASE_URL)%'
        server_version: '11g'
        types:
            oracle_date: App\Type\OracleDateType
        mapping_types:
            datetime: oracle_date
        profiling_collect_backtrace: '%kernel.debug%'
        use_savepoints: true
```

### Considérations Spécifiques à Oracle

- Utilisez des séquences pour les identifiants auto-incrémentés
- Gérez les limitations des noms de colonnes (max 30 caractères)
- Soyez attentif aux différences de syntaxe SQL entre Oracle et d'autres bases


### Migration de Schéma pour Oracle

Lors de la création de migrations pour Oracle, utilisez :

```shellscript
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

### Optimisation des Performances avec Oracle

- Utilisez des index stratégiquement
- Configurez les pools de connexions
- Utilisez les requêtes préparées Doctrine


## Conclusion

Ce projet basé sur Symfony propose une solution évolutive et efficace pour la gestion des activités. Il exploite les fonctionnalités robustes de Symfony pour offrir une plateforme complète de gestion des flux de travail et des ressources organisationnelles. La flexibilité de configuration permet son déploiement sur divers environnements, y compris des configurations avancées avec des bases de données Oracle, offrant ainsi une solution adaptable aux besoins spécifiques de différentes organisations.