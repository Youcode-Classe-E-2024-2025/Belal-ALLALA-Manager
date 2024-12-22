<?php

$dsn = 'mysql:host=localhost;dbname=packages_web';
$user = 'root';
$pass = '';
$sql_file_path = __DIR__ . '/../sql/data.sql'; // Chemin absolu vers le fichier SQL


try {
    $pdo = new PDO($dsn, $user, $pass); 
} catch (PDOException $e) {
    echo "Connexion à la base de données échouée : " . $e->getMessage() . "\n";

    try {
        $pdo_create = new PDO('mysql:host=localhost', $user, $pass);  // Nouvelle connexion sans nom de DB


        $sql = file_get_contents($sql_file_path);

         if ($sql === false) {
                die("Erreur: Impossible de lire le fichier SQL: " . $sql_file_path);
         }


        $result = $pdo_create->exec($sql);

         if ($result === false) {
            die ("Erreur lors de l'exécution du script SQL : ".implode(":",$pdo_create->errorInfo()));
         }


        echo "Base de données 'packages_web' créée avec succès.\n";

        // Reconnexion à la base de données nouvellement créée
        $pdo = new PDO($dsn, $user, $pass);
        echo "Connexion à la base de données 'packages_web' réussie.\n";


    } catch (PDOException $ex) {
        die("Erreur lors de la création de la base de données : " . $ex->getMessage());
    }
}

?>