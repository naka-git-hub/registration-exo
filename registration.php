<?php

    require_once 'config/database.php';

    $errors = [];

    //condition qui contient  la logique de traitement du formulaire quand on reçoit une request POST
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        
        //récupération des données du formulaire
        $userName = $_POST["name"] ?? '';
        $email = $_POST["email"] ?? '';
        $password1 = $_POST["password1"] ?? '';
        $password2 = $_POST["password2"] ?? '';

        var_dump($userName, $email, $password1, $password2);

        $userName = htmlspecialchars(trim($userName));
        $email = htmlspecialchars(trim($email));
        $password1 = trim($password1);
        $password2 = trim($password2);

        //validation des données

        //valide username
        //valide que le champ soit remplis
        if(empty($userName)){
            $errors[] = "nom obligatoire !";
        } elseif (strlen($userName) < 3) {
            $errors[] = "mini 3 carac";
        //valide avec la fonction strlen si la string est de moins de 55 carac
        } elseif (strlen($userName) > 55) {
            $errors[] = "max 55 carac";
        } 

        //validation email
        if (empty($email)){
            $errors[] = "email obligatoire !";
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "votre adresse ne correspond pas au format mail classique";
        }

        //validation password
        if(empty($password1)) {
            $errors[] = "Mot de passe obligatoire ";
        } elseif (strlen($password1) < 3) {
            $errors[] = "password trop juste.";
            // normalement ici on met un pattern pour le mdp
        } elseif ($password1 !== $password2) {
            $errors[] = "mots de passe doivent être identiques.";
        }

        //SELECT * FROM users WHERE email = 'jean@gmail.com';

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <section>
        <h1>Registration</h1>
            <form action="#" method="POST">
                
                <?php
                    foreach($errors as $error){
                        echo "<div>" . $error . "</div>";
                    }
                ?>

                <div>
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" placeholder="Nom" required/>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required/>
                </div>
                <div>
                    <label for="password1">Mot de passe</label>
                    <input type="password" id="password1" name="password1" placeholder="Mot de passe" required/>
                </div>
                <div>
                    <label for="password2">Confirmer le mot de passe</label>
                    <input type="password" id="password2" name="password2" placeholder="Confirmer le mot de passe" required/>
                </div>
                <div>
                    <input type="submit" value="Valider" />
                </div>
            </form>
        </section>
    </main>
</body>
</html>