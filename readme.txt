Pour Windows, pour activer mysql :
- pour voir les infos et localiser le fichier de configuration php.ini (located configuration file)
    -> phpinfo();
    -> die();
- dans le fichier php.ini, enlever le ; devant extension=pdo_mysql

Pour voir les détails de variables :
- composer require symfony/var-dumper
    -> permet d'avoir accès à la méthode dd(), ex dd($pages);

Pour voir les infos sur notre configuration php :
    - phpinfo();
    - die();
    Loaded configuration file : fichier de configuration chargé
        -> display_errors = On (pour afficher les erreurs)


Pour uploader plusieurs images :
L'idée, c'est de créer une table en base de données qui s'appellerait "images",
et dans laquelle tu viens enregistrer tous les noms des images.
Ensuite, tu as une autre table "association_images_produits" dans laquelle tu viens mettre
tes couples product_id / image_id. Et du coup, lorsque tu dois récupérer les images de ton produit,
tu le fais depuis cette table...