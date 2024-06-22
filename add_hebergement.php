<?php
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_projet = mysqli_real_escape_string($conn, $_POST["id_projet"]);
    $nom = mysqli_real_escape_string($conn, $_POST["nom"]);
    $accès = mysqli_real_escape_string($conn, $_POST["accès"]);

    $query = "INSERT INTO hebergement (nom, accès) VALUES ('$nom', '$accès')";
    if (mysqli_query($conn, $query)) {

        $id_hebergement = mysqli_insert_id($conn);

        $update_query = "UPDATE projets SET id_hebergement = '$id_hebergement' WHERE id_projet = '$id_projet'";
        if (mysqli_query($conn, $update_query)) {
            header('location:table.php');
        } else {
            echo "Error updating project: " . mysqli_error($conn);
        }
    } else {
        echo "Error adding hébergement: " . mysqli_error($conn);
    }
}
?>
