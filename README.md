# My Deezer api

## Présentation
Ce projet permet de se connecter à l'api Deezer et de créer en local sa propre base de donnée. Ceci permettant de gérer ses propres playlists ainsi que son référentiel de chansons en fonction de ses propres besoins.
 
 La base de code a été conçue pour être facile à prendre en main en évitant tout usage d'abstraction inutiles ou design patterns "pour le style" .
 
 La couche d'accès aux données se base sur PDO. Il est théoriquement possible d'installer l'application en utilisant un autre driver que Mysql. (Semble bien fonctionner avec SQLite) 


## Installation
Executer le fichier SQL source/Application/provision/mysql.all.sql.
L'application n'a pas besoin configuration de virtual host 

## Configuration
Editer le fichier source/Application/Configuration/Datasource.php

## Provision
Si vous souhaitez compléter la base de donnée, éditer le fichier source/Application/bin/populate-database.php puis l'éxécuter.

## Test
Se placer dans le dossier source/Application/www

Pour le player : /index.php

Pour l'API : /api.php


## Demo
API http://dzr.jlb.ninja/api.php

Client http://dzr.jlb.ninja/


## Considérations techniques

Le code n'utilise pas les spécificités de PHP7 afin de le rendre portable sur un maximum de versions de PHP.

La classe Application gère l'injection de dépendances ainsi que le routing. Elle n'a pas été découpée en sous classes car hors contexte dans le cadre de ce projet.

La couche de gestion des requêtes et réponses HTTP est minimaliste. Il serait aisé de changer les classes utilisées par un vendor plus solide.

La couche controleurs ne fait quasiment rien et le routeur aurait pu attaquer directement la couche modèle. Le choix de cette couche intermédiaire a été fait pour faciliter la compréhension de l'architecture en restant dans un modèle "standard"

La configuration se fait par classe PHP afin de pouvoir la débugguer facilement sans couche intermédiaire ainsi que pouvoir gérer potentiellement de l'héritage "natif" de configurations.

Le client JS a été codé rapidement et aurait besoin de consolidation.
