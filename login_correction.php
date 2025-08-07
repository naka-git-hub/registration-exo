<?php
    require_once "config/database.php";

    $errors = [];
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim(htmlspecialchars($_POST["email"]) ?? '');
        $password = $_POST["password"] ?? '';
        
        if(empty($password)) {
            $errors[] = "le mdp est obligatoire";
        }

        if(empty($email)) {
            $errors[] = "l'email est obligatoire";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "votre adresse ne correspond au format mail classique";
        }

        if (empty($errors)) {
            //appel de la fonction de connexion a la db
            $pdo = dbConnexion();
            //prépare une requete sql (email dynamique)
            $sql = "SELECT * FROM users WHERE email = ?";
            //stock ma request préparée 
            $requestDb = $pdo->prepare($sql);
            //"execute la request en lui passant en parametre l'element dynamique
            $requestDb->execute([$email]);
            //recupération des données
            $user = $requestDb->fetch();
            
            if ($user) {
                //verification
                if (password_verify($password, $user["password"])) {
                    var_dump('coucou le password ok');
                }
                
            }
    
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
    <h1>Se connecter a notre merveilleux site</h1>
    <form action="" method="POST">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Entrez votre email">
        </div>
        <div>
            <label for="password">password</label>
            <input type="password" name="password" id="password" required placeholder="entrer votre mdp">
        </div>
        <div>
            <input type="submit" value="Se connecter">
        </div>
    </form>
</body>
</html>