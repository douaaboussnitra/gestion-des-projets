<?php
include('includes/config.php');


$query = "SELECT h.id_hebergement, h.nom, p.nom AS projet_nom 
          FROM hebergement h
          JOIN projets p ON h.id_hebergement = p.id_hebergement";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Liste d'Hébergement</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('logout-button').addEventListener('click', function(event) {
                event.preventDefault();

                fetch('logout.php', {
                    method: 'POST',
                    credentials: 'include'
                }).then(response => {
                    if (response.ok) {
                        
                        window.location.href = 'category.php'; 
                    } else {
                        alert('Failed to log out');
                    }
                }).catch(error => {
                    console.error('Error logging out:', error);
                });
            });
        });
    </script>
</head>
<body>
<div class="sidebar pe-4 pb-3">
    <nav class="navbar d-flex flex-column align-items-center">
        <a href="index.php" class="navbar-brand mx-4 mb-3"></a>
        <div class="d-flex align-items-center justify-content-center mb-2" style="width: 100%;">
            <img src="img/isium_logo-removebg-preview.png" alt="Logo de l'entreprise" class="img-fluid" style="max-width: 60%;">
        </div>
        <div class="navbar-nav w-100">
            <a href="category.php" class="nav-item nav-link"><i class="fa fa-home me-2"></i>Accueil</a>
           
            <?php if (isAdmin()) : ?>
                <a href="table.php" class="nav-item nav-link"><i class="fa fa-project-diagram me-2"></i>Projets</a>
                <a href="admintable.php" class="nav-item nav-link"><i class="fa fa-users-cog me-2"></i>Utilisateurs</a>
            <?php else : ?>
                <a href="table_user.php" class="nav-item nav-link "><i class="fa fa-project-diagram me-2"></i>Projets</a>
            <?php endif; ?>
            <a href="table_documentation.php" class="nav-item nav-link"><i class="fa fa-book me-2"></i>Documentations</a>
            <a href="table_hebergement.php" class="nav-item nav-link"><i class="fa fa-server me-2"></i>Hébergements</a>
            <a href="profile.php" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Profil</a>
            <a href="#" id="logout-button" class="nav-item nav-link"><i class="fa fa-sign-out-alt me-2"></i>Déconnexion</a>
        </div>
    </nav>
</div>

        

        <div class="content" style="background: initial !important">
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
            </nav>

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded p-4">
                    <h6 class="mb-4">Liste d'Hébergement</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Hébergement</th>
                                    <th>Nom de Projet</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id_hebergement'] . "</td>";
                                        echo "<td>" . $row['projet_nom'] . "</td>";
                                        echo "<td><a href='show_hebergement.php?id=" . $row['id_hebergement'] . "' class='btn btn-primary'>Show</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No hébergement found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="hebergement-details" class="container-fluid pt-4 px-4" style="display: none;">
                <div class="bg-light rounded p-4">
                    <h6 class="mb-4">Hébergement Details</h6>
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="accès">Accès:</label>
                        <textarea id="accès" class="form-control" rows="4" readonly></textarea>
                    </div>
                    <button class="btn btn-secondary" onclick="hideHebergementDetails()">Close</button>
                </div>
            </div>
        </div>

        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        function showHebergementDetails(id) {
            
            $.ajax({
                url: 'get_hebergement_details.php',
                type: 'GET',
                data: {id: id},
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#nom').val(data.nom);
                    $('#accès').val(data.accès);
                    $('#hebergement-details').show();
                }
            });
        }

        function hideHebergementDetails() {
            $('#hebergement-details').hide();
        }
    </script>
</body>
</html>
