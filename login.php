<?php

    //Form en HTML
    // mail et mb_preferred_mime_name
    // Si on reçoit du post : 
    // 1 traite les données
    // 2 on vérifie si l'adresse existe
    // 3 gestion des errors
    // 4 Si elle existe on vérifie si le mdp est le bon
    // 5 on s'arrête pour l'instant

    require_once 'config/database.php';

    $errors = [];

    //condition qui contient  la logique de traitement du formulaire quand on reçoit une request POST
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        
        //récupération des données du formulaire
        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        var_dump($email, $password);

        $email = htmlspecialchars(trim($email));
        $password = trim($password);

        //validation des données

        //validation email
        if (empty($email)){
            $errors[] = "email obligatoire !";
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "votre adresse ne correspond pas au format mail classique";
        }

        //validation password
        if(empty($password)) {
            $errors[] = "Mot de passe obligatoire ";
        } elseif (strlen($password) < 3) {
            $errors[] = "password trop juste.";
            // normalement ici on met un pattern pour le mdp
        }

        if(empty($errors)) {
            
             //logique de traitement en db
            $pdo = dbConnexion();

            //verifier si l'adresse mail est utilisé ou non
            $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");

            //la methode execute de mon objet pdo execute la request préparée
            $checkEmail->execute([$email]);

            //une condition pour vérfier i je recupere quelque chose
            if ($checkEmail->rowCount() === 0) {
                $errors[] = "email n'existe pas";
            } else {
                
                //Nous utilisons une requête SELECT afin d'avoir le mot de passe correspondant à l'email existant
                $checkPassword = $pdo->prepare("SELECT password FROM users WHERE email = ?");
                
                //Nous exécutons la requête SELECT
                $checkPassword->execute([$email]);

                //La méthode fetch retourne les lignes dans un tableau indexé par le nom des colonnes
                $result = $checkPassword->fetch(PDO::FETCH_ASSOC);

                //var_dump($result['password']);
                //une condition pour vérifier si le mot de passe est bon
                if(password_verify($password, $result['password'])) {
                    $message = "super mega cool votre email existe et le mot de passe est bon";    
                } else {
                    $errors[] = "le mot de passe n'est pas bon";
                }

            }

            //var_dump('hello');
            //var_dump($test);
            // try {
                
            // } catch () {
                
            // }
        }
        

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
    <main>
        <section>
        <h1>Login</h1>
            <form action="#" method="POST">
                
                <?php
                    foreach($errors as $error){
                        echo "<div>" . $error . "</div>";
                    }

                    if(!empty($message)) {
                    echo $message;
                }
                ?>

                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required/>
                </div>
                <div>
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Mot de passe" required/>
                </div>
                <div>
                    <input type="submit" value="Valider" />
                </div>
            </form>
        </section>
    </main>

</body>
</html>


