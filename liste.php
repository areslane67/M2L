<?php
    session_start();
    include_once("./src/data.inc.php");
    include_once("./src/session.php");
    
    if (!isset($_SESSION['nom']) || !isset($_SESSION['URL'])) {
        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        header("Location: connexion.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/list.css">
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

        <?php
            // Loop through the results and display each user's name
            foreach ($result as $user) {
                    
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
            }

        ?>
    </main>
    <script defer src="./js/app.js"></script>
</body>
</html>
