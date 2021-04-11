<?php
// fichier app/Config/config.local.php

// Nom de la base de données
define('APP_DB_NAME', 's3.devweb.blog-mmi.fr');

// Utilisateur de la base de données MySQL.
// reprendre les informations à partir d'alwaysdata.net
//   https://admin.alwaysdata.com/database/user/?type=mysql
define('APP_DB_USER', '??????');
// Mot de passe de la base de données MySQL.
define('APP_DB_PASSWORD', '??????');
// Adresse de l'hébergement MySQL.
// compléter ici les ??? par votre compte alwaysdata
define('APP_DB_HOST', 'mysql-???.alwaysdata.net');

// préfixe des tables
// pas utile maintenant donc on laisse vide
define('APP_TABLE_PREFIX', '');
