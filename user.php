<?php
    session_start();
    include_once("./src/data.inc.php");
    include_once("./src/session.php");



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/user.css">
    <link rel="stylesheet" href="./css/modal.css">
    <title>Document</title>
</head>
<body>
<header>
        <div>
            <a href="./connected.php"><img class="yes" src="./asset/1904668-connection-document-file-media-network-share-social_122517.png" alt="img">Internet</a>
        </div>
        <div>
        <a href="./liste.php" class="Liste" id="Liste"><img class="yes" src="./asset/list-symbol-of-three-items-with-dots_icon-icons.com_72994.png" alt="img">Liste</a>
        <a href="./connected.php"><?php echo '<img src="' . $_SESSION['URL'] . '" class="top">'?></a>
        <a href="./src/deconnexion.php" class="right"><img class="yes" src="./asset/door_direction_arrow_out_log_exit_icon_232679.png" alt="">Déconnexion</a>
        </div>   
    </header>
  <main>
    <div class="parent-modale hidden" role="dialog">
        <p>etes vous sure de vouloir suprimer cette utilisateur</p>
            <button aria-label="closed">
                <span class="material-icons">clear</span>
            </button>
            <form method="POST" action="">
                <input type="submit" name="delete" value="Delete" class="byebye">
            </form>
    </div>
  <?php
            // Loop through the results and display each user's name
            $user_id = $_GET['id']; // Set the value of the user ID you want to retrieve
            $user = $_bdd->prepare("SELECT * FROM inscription WHERE id = ?");
            $user->execute([$user_id]);
            $user = $user->fetch();
            include_once("./src/update.php");

                    $date = $user['Birthdate'];
                    $date_format = date('F jS', strtotime($date));
                    $user['mois'] = $date_format;
                    $user['aj'] = date('Y-m-d');
                    $birthdate = new DateTime($user['Birthdate']);
                    $today = new DateTime($user['aj']);
                    $age = $birthdate->diff($today);
                    $user['age'] = $age->y;

                    $color = '';

                    if ($user['Categorie'] == 'Client') {
                        $color = 'vert'; // assign green color to clients
                      } elseif ($user['Categorie'] == 'admin') {
                        $color = 'rouge'; // assign red color to administrators
                      }

                      if (isset($_POST['delete'])) {
                        $sql = "DELETE FROM inscription WHERE id=:id";
                        $stmt = $_bdd->prepare($sql);
                        $stmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
                        if ($stmt->execute()) {
                            header("Location: liste.php");
                            exit;
                        } else {
                            echo "Erreur lors de la suppression des données utilisateur.";
                        }
                    }

                echo "
                <section data-uid=" . $user['id'] . ">
                <div class=\"left\">
                <img src=\"" . $user['URL'] . "\" class=\"zeb\">
                </div>

                <div>
                <ul class=\"right\" >

                <li> <p class=\"nom\">" . $user['nom'] . " " . $user['prenom'] . "</p><p class=\"age\">(" . $user['age'] . " ans) </p> </li>
                <li> <p class=\"pays\">". $user['Ville'] .",". $user['Pays']."</p> </li>
                <li> <img src=\"./asset/message_mail_email_envelope_icon_220571.png\" class=\"mail\"> <p>".$user['mail']."</p> </li>
                <li> <img src=\"./asset/phone-handset_icon-icons.com_48252.png\" class=\"phone\"> <p>".$user['tel']."</p> </li>
                <li> <img src=\"./asset/birthdaycakewithcandles_79795.png\" class=\"an\"> <p>".$user['mois']."</p> </li>
                
                </ul>
                <p class=\"$color\" id=\"zeb\">". $user['Categorie'] ."</p>
                </div>
                </section>

                
                ";
            
            ?>
            <div class="ez">
        <h1>Modifier profil de l'utilisateur</h1>
        <form method="POST" action="">
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
    <input type="submit" name="submit" value="Modifier les informations" id="ex">
    
</form>
<button class="btn_delet">delete</button>
<form method="POST" action="">
  <input type="submit" name="delete" value="Delete" class="byebye">
</form>



                    </div>
<script src="./js/modal.js"></script>
</body>
</html>