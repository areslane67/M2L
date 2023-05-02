<link rel="stylesheet" href="../css/style.css">
<?php if(isset($_POST['mail']) || isset($_POST['psw'])){
                $_email = $_POST["mail"];

                //on test les chaines de caractère//
                if(!$_POST['Civilite'] || !$_POST['Categorie'] || !$_POST['nom'] || !$_POST['prenom'] || !$_POST['mail'] || !$_POST['psw'] || !$_POST['pswC'] || !$_POST['tel'] || !$_POST['Birthdate'] || !$_POST['Ville'] || !$_POST['Pays'] || !$_POST['URL']){
                    echo "<p class=\"warning\">remplisser tout les champs</p>";
                    }
                    else if(!filter_var($_email, FILTER_VALIDATE_EMAIL)){ //attention à ma fonction
                        echo "<p class=\"warning\">Mail invalide</p>";
                    }
                    else if(is_numeric($_email)){
                            echo "<p class=\"warning\">Vous devez saisir des caractères</p>";
                    }
                    else if($_POST['psw'] != $_POST['pswC']){
                        echo "<p class=\"warning\">pd</p>";
                    }
                    else{

                    //password_hash($_POST['psw'],PASSWORD_DEFAULT);
                    
                    $req = $_bdd->prepare('INSERT INTO inscription (Civilite, Categorie, nom, prenom, mail, psw, pswC, tel, Birthdate, Ville, Pays, URL)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)');
                    $req->execute(array($_POST['Civilite'], $_POST['Categorie'], $_POST['nom'], $_POST['prenom'], $_POST['mail'], password_hash($_POST['psw'],PASSWORD_DEFAULT),password_hash($_POST['pswC'],PASSWORD_DEFAULT),$_POST['tel'],$_POST['Birthdate'],$_POST['Ville'],$_POST['Pays'],$_POST['URL']));
                    
                    echo header("Location: connexion.php");
                    exit;
                    
                }                
                
            }