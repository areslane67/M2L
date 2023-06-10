<?php
session_start();
include_once("./src/data.inc.php");
include_once("./src/session.php");

if (!isset($_SESSION['nom']) || !isset($_SESSION['URL'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Récupérer la requête de recherche depuis les paramètres GET
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Récupérer la catégorie choisie depuis les paramètres GET
$categorieFilter = isset($_GET['categorie']) ? $_GET['categorie'] : '';

// Effectuer une requête pour récupérer tous les utilisateurs
$stmt = $_bdd->prepare("SELECT * FROM inscription");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fonction de comparaison pour le tri par ordre alphabétique croissant
function compareAsc($a, $b) {
    return strcasecmp($a['nom'], $b['nom']);
}

// Fonction de comparaison pour le tri par ordre alphabétique décroissant
function compareDesc($a, $b) {
    return strcasecmp($b['nom'], $a['nom']);
}

// Vérifier si l'option de tri par ordre alphabétique a été sélectionnée
if (isset($_GET['sort'])) {
    $sortOption = $_GET['sort'];
    if ($sortOption === 'asc') {
        usort($result, 'compareAsc'); // Tri par ordre alphabétique croissant
    } elseif ($sortOption === 'desc') {
        usort($result, 'compareDesc'); // Tri par ordre alphabétique décroissant
    }
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
        <?php echo '<img data-uid="' . $_SESSION['id'] . '" src="' . $_SESSION['URL'] . '" class="top">'?>
        <a href="./src/deconnexion.php" class="right"><img class="yes" src="./asset/door_direction_arrow_out_log_exit_icon_232679.png" alt="">Déconnexion</a>
        </div>   
    </header>
    <main>
        <div class="vip">
            <!-- Formulaire de recherche -->
            <form method="GET" action="" class="oo" id="searchForm">
                <input type="text" name="search" placeholder="Recherche" value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit" id="searchButton">Rechercher</button>
            </form>

            <!-- Formulaire de filtre par catégorie -->
            <form method="GET" action="" class="filterForm">
                <select name="categorie" onchange="this.form.submit()">
                    <option value="">Tous</option>
                    <option value="Client" <?php if ($categorieFilter === 'Client') echo 'selected'; ?>>Clients</option>
                    <option value="admin" <?php if ($categorieFilter === 'admin') echo 'selected'; ?>>Administrateurs</option>
                </select>
            </form>

            <!-- Formulaire de tri par ordre alphabétique -->
            <form method="GET" action="" class="sortForm">
                <select name="sort" onchange="this.form.submit()">
                    <option value="">Trier par</option>
                    <option value="asc">Ordre alphabétique croissant</option>
                    <option value="desc">Ordre alphabétique décroissant</option>
                </select>
            </form>
        </div>

        <?php
        // Loop through the results and display each user's name
        foreach ($result as $user) {
            // Vérifier si l'utilisateur correspond à la recherche et à la catégorie choisie (si spécifiée)
            if ((stripos($user['nom'], $searchQuery) !== false || stripos($user['prenom'], $searchQuery) !== false) &&
                ($categorieFilter === '' || $user['Categorie'] === $categorieFilter)) {
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
                <section>
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
        }
        ?>
    </main>
    <script src="js/app.js"></script>
        <script>
            var searchTimer; // Déclaration de la variable searchTimer
            
        var searchInput = document.querySelector('input[name="search"]');
        searchInput.addEventListener('input', async function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                document.getElementById('searchForm').submit();
            }, 1000);
        });
    </script>
</body>
</html>
