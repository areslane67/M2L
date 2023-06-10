<?php
session_start();
// Vérifier si l'utilisateur est connecté

if (!isset($_SESSION['nom']) || !isset($_SESSION['URL'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}
include_once("./src/connexion.php");
// Inclure les fichiers nécessaires
include_once("./src/data.inc.php");

$user_id = $_SESSION['id'];
$user_query = $_bdd->prepare("SELECT * FROM inscription WHERE id = ?");
$user_query->execute([$user_id]);

$user = $user_query->fetch(PDO::FETCH_ASSOC);

$color = '';
if ($user['Categorie'] == 'Client') {
    $color = 'vert'; // assign green color to clients
} elseif ($user['Categorie'] == 'admin') {
    $color = 'rouge'; // assign red color to administrators
}

// Effectuer une requête pour récupérer tous les utilisateurs
$stmt = $_bdd->prepare("SELECT * FROM inscription ORDER BY RAND() LIMIT 1");
$stmt->execute();
$user_random = $stmt->fetch(PDO::FETCH_ASSOC);


        $date = $user['Birthdate'];
        $date_format = date('F jS', strtotime($date));
        $user_random['mois'] = $date_format;
        $user_random['aj'] = date('Y-m-d');
        $birthdate = new DateTime($user_random['Birthdate']);
        $today = new DateTime();
        $age = $birthdate->diff($today)->y;
        $user_random['age'] = $age;

        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/home.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <a href="./connected.php"><img class="yes" src="./asset/1904668-connection-document-file-media-network-share-social_122517.png" alt="img">Internet</a>
        </div>
        <div>
            <a href="./liste.php" class="Liste"><img class="yes" src="./asset/list-symbol-of-three-items-with-dots_icon-icons.com_72994.png" alt="img">Liste</a>
            <?php echo '<img data-uid="' . $_SESSION['id'] . '" src="' . $_SESSION['URL'] . '" class="top">'?>
            <a href="./src/deconnexion.php" class="right"><img class="yes" src="./asset/door_direction_arrow_out_log_exit_icon_232679.png" alt="">Déconnexion</a>        
        </div>   
    </header>
    <main>
        <h1>Bienvenue sur l'intranet</h1>
        <p>La plate-forme de l'entreprise qui vous permet de retrouver tout vos colaborateurs</p>
        <section>
    <div class="left">
        <?php echo '<img src="' . $user_random['URL'] . '" class="zeb">'; ?>
    </div>
    <ul class="right">
    <li><?php echo "<p class=\"nom\">" . $user_random['nom'] . " " . $user_random['prenom'] . "</p><p class=\"age\">(" . $user_random['age'] . " ans)</p>"; ?></li>
        <li><?php echo "<p class=\"pays\">" . $user_random['Ville'] . "," . $user_random['Pays'] . "</p>"; ?></li>
        <li><?php echo '<img src="./asset/message_mail_email_envelope_icon_220571.png" class="mail"> <p>' . $user_random['mail'] . '</p>'; ?></li>
        <li><?php echo '<img src="./asset/phone-handset_icon-icons.com_48252.png" class="phone"> <p>' . $user_random['tel'] . '</p>'; ?></li>
        <li><?php echo '<img src="./asset/birthdaycakewithcandles_79795.png" class="an"> <p>Anniversaire : ' . $user_random['mois'] . '</p>'; ?></li>
    </ul>
    <?php echo '<p class="' . $color . '" id="zeb">' . $user_random['Categorie'] . '</p>'; ?>
    </section>

    <a href="" class="refresh">Dire Bonjour à quelqu'un d'autre</a>

    </main>

    <script src="js/app.js"></script>

</body>
</html>