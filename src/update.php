<?php 

// Connexion à la base de données
$connexion = mysqli_connect("localhost", "root", "", "mdl");

if(isset($_POST['submit'])) {
    $id = $user['id']; // récupérer l'ID de l'utilisateur à modifier à partir du formulaire
    $civilite = $_POST['Civilite'];
    $categorie = $_POST['Categorie'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['mail'];
    $tel = $_POST['tel'];
    $birthdate = $_POST['Birthdate'];
    $ville = $_POST['Ville'];
    $pays = $_POST['Pays'];
    $url = $_POST['URL'];

    // Valider les champs du formulaire
    if(empty($civilite) || empty($categorie) || empty($nom) || empty($prenom) || empty($email) || empty($tel) || empty($birthdate) || empty($ville) || empty($pays) || empty($url)) {
        echo "<p class='warning'>Veuillez remplir tous les champs.</p>";
    } else {
        $req = mysqli_prepare($connexion, "UPDATE inscription SET Civilite=?, Categorie=?, nom=?, prenom=?, mail=?, tel=?, Birthdate=?, Ville=?, Pays=?, URL=? WHERE id=?");
        mysqli_stmt_bind_param($req, 'ssssssssssi', $civilite, $categorie, $nom, $prenom, $email, $tel, $birthdate, $ville, $pays, $url, $id);
        mysqli_stmt_execute($req);

        if(mysqli_affected_rows($connexion) > 0) {
            echo header("Location: ../mdl2/liste.php");
        } else {
            echo "Erreur lors de la mise à jour des informations de l'utilisateur.";
        }

        mysqli_stmt_close($req);
    }
}
