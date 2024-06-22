<?php
include('includes/config.php');

$query = "SELECT Projets.Nom AS NomProjet, GROUP_CONCAT(developpeurs.Nom SEPARATOR ', ') AS developpeurs
          FROM Projets
          LEFT JOIN Projets_Developpeurs ON Projets.ID_Projet = Projets_Developpeurs.ID_Projet
          LEFT JOIN developpeurs ON Projets_Developpeurs.ID_Développeur = developpeurs.ID_Développeur
          GROUP BY Projets.ID_Projet";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associations Projet-Développeur</title>

</head>
<body>
    <div class="container">
        <h1>Associations Projet-Développeur</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom du Projet</th>
                    <th scope="col">developpeurs</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['NomProjet'] . "</td>";
                    echo "<td>" . $row['developpeurs'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
