# Projet PHP 
## MyComunnityLib

## Description
Ce petit projet est un petit blog sur modèle d'un réseau social sur l'informatique et le développement informatique en générale.

## Fonctionnalitées
* Inscription
* Profile
    * Affichage des Publication personnelle
* Ajout de publication 
* Ajout de commentaire
* Interface de Modération
* Affichage de toute les publications pour tous les utilisateurs

## TEMPLATE
### file.ini

Intialisation de la la base de donnée

```php
HOST = "localhost"
USER_NAME = "username"
PASSWORD = "password"
DB_NAME_CITY = "france"
DB_NAME = "dbname"
```

## Détails

### Interfaces

Les interfaces des utilisateurs connecté on une side barre avec leur photo de profile leur nom et la possibiliter d'ajouter une publication.

#### Index
Disponnible pour tous les utilisateurs c'est une interface avec une barre de navigation avec la possibilité de se connecter ou de s'inscrire et une side barre avec les liens pour afficher les publications par catégories.
#### Connection
Une interface qui permet de se connecter.
 
#### Register
Une interface qui permet de s'inscrire sur deux formulaire. J'ai mis en place une sorte de pagination sur le premier on va récupérer le nom et prénom et sur le deuxième une bio et une possibilité de s'inscrire a une newsletter.
#### Article
Permet de récupéréer les articles par catégories.
#### Modo
Une interface qui permet aux utilisateurs qui on le role de modo de selectionner les publication a supprimer.
#### Logout
Une interface qui permet de se déconnecter.

### Page de process

#### Connection_process
Je vérifie si la superglobale $_POST existe avec isset et je stock les valeurs de `$_POST['email']` et `$_POST['pass']` dans des variables.
Dans un try/catch je créer une instance de [Email](#email) Et vérifie si elle est présente dans ma BDD avec isEmailDb.
Je créer une instance de [Password](#pass).
Je vérifie que l'email et les pass soit ok avec isConfirmedConnection et je créer l'instance de [User](#user). 
Je catch toutes les Exeption de Email et Password ce qui me permet d'afficher les bon message au bon endroit et de rediriger les utilisateurs a la page connection sinon je les redirige sur leur profile.

#### Register_process
Comme pour la connexion, après avoir vérifier la soumission du premier formulaire, je créer des instances de Email et Password et de User. Si ok j'insert dans la BDD les info du premier formulaire. 
Je vérifie si l'utilisateur a mis télécharger une poto de profile et j'ai du utiliser ` $_FILES['fileName']['error'] === 0 ` pour verifier que $_FILES n'est pas vide et j'insert dans ma table étrangère `users_has_files` l'ID de l'utilisateur et le dernier ID du fichier inserer dans la BDD.
Je vérifie la deuxième soumission et met a jour les infos de l'utilisateur.


#### Register_publication
Je vérifie que un seul type de publication soit envoyer soit un lien soit une fichier télécharger.
Si c'est un fichier est télécharger : ( j'ai commencer a utilisé la déstructuration des array car j'avais un peu de mal au début.) Dans un try/catch je créer une instance de [File](#file) et je l'insert dans la BDD et j'initialise ma variable $media avec le chemin du dossier upload avec le nom du fichier.
Si un lien ma variable $media sera avec le chemin de l'API <a href="https://pagepeeker.com/">Page Peeker</a> pour obtenir des miniatures des url.
Je créer l'instance <a name="publication">Publication</a>, je l'insert dans la BDD et je remplie ma table étrangère categories avec joinCategoryPublication.
#### Register_comment_process
Pour chaque soumission du formulaire de commantaire je récupere l'ID de l'article avec explode.
Dans un try/catch j'instencie [Comment](#comment), je l'insert dans la BDD et redirige l'utilisateur sur la page ou il a mis le commantaire avec `$_SERVER['HTTP_REFERER']`.
#### approvalPublication
Pour gérer l'aprobation de publication via l'interface modo.
Je récupère toute les publication qui son en attente de publication et pour chaque checkbox qui existe donc checked, je delete la publication a la soumission sinon je update la propripriéte approval_status de ma table publication à 1.
### Classes

#### [Email](#email)
#### [Password](#pass)
#### [User](#user)

#### [File](#file)
#### [Comment](#comment)

### Layout
* Header
* Side-bar-profile
* Side-bar-catégory
* Footer
### Assets
* Templates de publications
* Feuille de style
### Function
* Request générale
### init
Initialisation de l'instance de PDO
### JS
Mon script js qui gére surtout la pop up d'ajout de publication
