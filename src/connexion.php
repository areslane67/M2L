<?php

if(isset($_POST["mail"]) || isset($_POST["psw"])){
    try {
        $reponse = $_bdd->query("SELECT mail, nom, prenom, psw, Ville, Pays, tel, Birthdate, URL FROM inscription WHERE mail = '{$_POST['mail']}' limit 1");
        $DATA  = $reponse->fetch();
        $login = $_POST["mail"];
        $mdp = $_POST["psw"];
        if(!$login || !$mdp){
            echo "<p class=\"warning\">Vous avez oublié votre mail ou password?</p>";
        } else if(isset($DATA['psw'])) {
            if(password_verify($_POST["psw"],$DATA['psw'])) {
                // Le mot de passe est correct
                session_start();

                $_SESSION['mail'] = $DATA['mail'];
                $_SESSION['URL'] = $DATA['URL'];
                $_SESSION['nom'] = $DATA['nom'];
                $_SESSION['prenom'] = $DATA['prenom'];
                $_SESSION['Ville'] = $DATA['Ville'];
                $_SESSION['Pays'] = $DATA['Pays'];
                $_SESSION['tel'] = $DATA['tel'];
                $_SESSION['Birthdate'] = $DATA['Birthdate'];

                $date = $DATA['Birthdate']; // récupérer la date stockée dans la base de données
                $date_format = date('F jS', strtotime($date)); // formater la date en "F-jS"

                $_SESSION['mois'] = $date_format;
                
                $_SESSION['aj'] = date('Y-m-d');
                $birthdate = new DateTime($_SESSION['Birthdate']);
                $today = new DateTime($_SESSION['aj']);
                $age = $birthdate->diff($today);

                $_SESSION['age'] = $age->y;

                header("Location: connected.php");
                exit;
            } else {
                // Le mot de passe est incorrect
                echo "<p class=\"warning\">Erreur login ou mot de passe?</p>";
            }
        } else {
            // La valeur 'psw' n'existe pas dans le tableau $DATA
            echo "<p class=\"warning\">Erreur login ou mot de passe?</p>";
        }
    } catch (Exception $e) {
        //throw $th;
    }
}

    

?>
















