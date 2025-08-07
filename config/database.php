<?php

// logique de connexion a la database

//fonction qui crée et renvoi une connexion à la db
function dbConnexion(){

    //information pour se connecter
    //l'endroit ou est ma database
    $host = "localhost";
    //le nom de la db
    $dbname = "users";
    //identifiant de connexion
    $username = "root";
    //mdp de connexion
    $password = "";
    //port
    $port = 3306;
    //encodage
    $charset = "utf8mb4";

    try {
        //DSN est le nom de la source de données contenant$
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;port=$port";
        $pdo = new PDO($dsn, $username, $password);
         //comment recuperer les exception (erreurs)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //comment me renvoyer les données
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        //var_dump($pdo);
        return $pdo;


    } catch (PDOException $e) {
        die("Erreur durant la co à la db: " . $e->getMessage());
    }

}

//var_dump(dbConnexion());