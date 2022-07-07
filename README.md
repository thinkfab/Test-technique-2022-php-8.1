# Test technique Thinkfab

## Avant propos
### Bonjour!
Ce que tu t'apprêtes à réaliser est un test technique, il n'y a pas de mauvaises réponses, nous souhaitons comprendre
comment tu travailles et quelle est ta réflexion d'un point de vue implémentation de feature.

Le code produit dans ce repository n'est pas parfait, loin de là.
Nous ferons une réunion afin d'échanger sur le code réalisé. Si tu n'arrives pas au bout de l'exercice, ce n'est pas grave.
Par contre, je te demanderai de poser des questions lors de l'entretien que nous aurons concernant ce que tu n'as pas compris.

**<span style="color: red;">Pour réaliser ce test technique, tu dois au préalable avoir installé Docker et Docker-compose sur ta machine.</span>**

**<span style="color: cyan;">Si tu utilises Windows ou mac il faudra php:8.1 - Yarn - Mysql - Composer - Symfony cli d'installé sur ta machine</span>**

----

## Installation
### Docker :
Pour installer le projet, tu dois exécuter la commande `make install` à la racine du dossier. Tu auras le temps de faire couler un café ! *(Nous aimons bien le café)*

### Windows/MAC
Il faudra que tu lances les commandes suivantes pour faire tourner le projet sur ton poste:
```shell
php -d memory_limit=4G bin/composer install     // installation des bundles externes
bin/console d:d:create                          // creation de la bdd
bin/console d:m:migrate                         // execution des migrations
bin/console d:f:l --append                      // execution des fixtures
yarn install                                    // installation des dependance yarn
yarn encore dev                                 // build des fichiers 
symfony server:start                            // lancement du server symfony
```
Si tu rencontres un souci au moment de l'installation, consulte [les erreurs communes](#erreurs-communes-lors-de-linstallation) fais moi en pars tout de suite, soit par mail ps@thinkfab.fr, soit via [linkedin](https://www.linkedin.com/in/paul-strentz/) *(je suis plus reactif sur LinkedIn)*

Pour réaliser ce test tu devras créer une nouvelle branche en partant de main. La branche devra se nommer en suivant ce pattern:
NOM_Prénom. 

Tu devras réaliser un commit par objectif en suivant ce pattern exemple: "feature: decription de la feature -- Objectif 1"

Tu devras pusher ton travail et m'en informer, soit par mail ps@thinkfab.fr, soit via [linkedin](https://www.linkedin.com/in/paul-strentz/)

## Comment fonctionne le projet
Ce projet utilise EasyAdmin 4 la route d'accès au login de connexion est [http://localhost:8088/login/login-admin-interface](http://localhost:8088/login/login-admin-interface)

### Pour se connecter:
- <u>Mail</u> : test@technique.com
- <u>Password</u> : p@ssword

Pour le reste de l'application, son fonctionnement est relativement simple à comprendre.
Tu n'auras pas besoin de te connecter en tant qu'admin pour la réalisation de ce test technique.
Hormis pour te générer de nouvelles données.

Pour commencer le test, une fois l'installation finalisée, je t'invite à te rendre sur l'url suivante [http://localhost:8088/read-me/consignes](http://localhost:8088/read-me/consignes)

### Erreurs communes lors de l'installation
><span style="background-color:#f55f69; color:black;">Could not create database test-technique for connection named default</span></br>
 <span style="background-color:#f55f69; color:black;">An exception occurred while executing a query: SQLSTATE[HY000]: General error: 1007 Can't create database 'test-technique'; database exists</span>

il faudra lancer alors la commande `make db-drop` puis de relancer la commande `make install`
