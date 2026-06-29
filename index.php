<?php

/*
|--------------------------------------------------------------------------
| Point d'entrée racine (production / hébergement mutualisé)
|--------------------------------------------------------------------------
|
| Sur certains hébergements, le domaine pointe directement sur la racine
| du projet (là où se trouve le fichier .env) plutôt que sur /public.
| Ce fichier délègue alors au véritable contrôleur frontal de Laravel
| situé dans public/index.php. Comme l'inclusion conserve le __DIR__ du
| fichier inclus, tous les chemins (vendor, bootstrap, storage, public)
| restent correctement résolus.
|
*/

require __DIR__.'/public/index.php';
