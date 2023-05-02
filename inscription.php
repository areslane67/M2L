<?php
    session_start();
    include_once("./src/data.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <a href="./inscription.php"><img class="yes" src="./asset/1904668-connection-document-file-media-network-share-social_122517.png" alt="img">Internet</a>
        </div>
        <div>
            <a href="./connexion.php" class="right"><img class="yes" src="./asset/door_direction_arrow_out_log_exit_icon_232679.png" alt="">Connection</a>
        </div>   
    </header>
    <main>
        <h1>Cree monprofil</h1>
        <form method="post"> 
            <label>Civilite*
                <select name="Civilite" id="Civilite">
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </label>
            <label>Categorie*
                <select name="Categorie" id="Categorie">
                    <option value="Client">Client</option>
                    <option value="admin">admin</option>
                </select>
            </label>
            <label>Nom*
                <input type="text" name="nom" aria-labelledby="Nom"  id="Nom" placeholder="text" aria-required="true">
            </label>
            <label>Prénom*
                <input type="text" name="prenom" aria-labelledby="Prénom"  id="Prénom" placeholder="text" aria-required="true">
            </label>
            <label>Mail ou login*
                <input type="email" name="mail" aria-labelledby="email"  id="email" placeholder="Mail Utilisateur" aria-required="true" autofocus>
            </label>
            <label>Mot de passe*
                <input type="password" name="psw" aria-labelledby="password" id="password" placeholder="Mot de passe" aria-required="true">
            </label>
            <label>Mot de passe confirme*
                <input type="password" name="pswC" aria-labelledby="password" id="password" placeholder="Mot de passe" aria-required="true">
            </label>
            <label for="Birthdate">Tel
                <input type="tel" id="tel" name="tel" placeholder="Enter Your tel" required>
            </label>
            <label for="Birthdate">Birthdate
                <input type="date" id="Birthdate" name="Birthdate" placeholder="Enter Your Birthdate" required>
            </label>
            <label>Ville*
            <input type="Ville" id="Ville" name="Ville" placeholder="Ville" required>
            </label>
            <label>Pays*
            <input type="Pays" id="Pays" name="Pays" placeholder="Pays" required>
            </label>
            <label for="URL">URL de la photo
                <input type="url" id="URL" name="URL" placeholder="URL" required>
            </label>
            <input type="submit" aria-label="Envoyer" value="CONNECTION A VOTRE COMPTE" id="ex">
        </form>
        <?php
                     //inclusion
                    include_once "./src/inscription.php";
                 ?>
    </main>
    <footer>

    </footer>
</body>
</html>