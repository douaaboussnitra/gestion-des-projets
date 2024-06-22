<?php
include('includes/config.php');


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: 404.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST["nom"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $plateforme = mysqli_real_escape_string($conn, $_POST["plateforme"]);
    $technologies = mysqli_real_escape_string($conn, $_POST["technologies"]);
    
    $query = "INSERT INTO Projets (nom, Description, Plateforme, Technologies) 
              VALUES ('$nom', '$description', '$plateforme', '$technologies')";
    $result = mysqli_query($conn, $query);
    
    $last_project_id = mysqli_insert_id($conn);
    
    if ($result) {
        if (isset($_POST['developpeurs']) && !empty($_POST['developpeurs'])) {
            foreach ($_POST['developpeurs'] as $developer_id) {
                $developer_id = mysqli_real_escape_string($conn, $developer_id);
                $query = "INSERT INTO Projets_developpeurs (ID_Projet, id_developpeur) 
                          VALUES ('$last_project_id', '$developer_id')";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Erreur lors de l'ajout des développeurs au projet : " . mysqli_error($conn);
                    $rollback_query = "DELETE FROM Projets WHERE ID_Projet='$last_project_id'";
                    mysqli_query($conn, $rollback_query);
                    exit();
                }
            }
        }
        header('location:table.php');
    } else {
        echo "Erreur lors de l'ajout du projet : " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gestion de Projets</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
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
    <div class="container-xxl position-relative  d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        
<!-- Sidebar Start -->
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
                <a href="table_user.php" class="nav-item nav-link active"><i class="fa fa-project-diagram me-2"></i>Projets</a>
            <?php endif; ?>
            <a href="table_documentation.php" class="nav-item nav-link"><i class="fa fa-book me-2"></i>Documentations</a>
            <a href="table_hebergement.php" class="nav-item nav-link"><i class="fa fa-server me-2"></i>Hébergements</a>
            <a href="profile.php" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Profil</a>
            <a href="#" id="logout-button" class="nav-item nav-link"><i class="fa fa-sign-out-alt me-2"></i>Déconnexion</a>
        </div>
    </nav>
</div>
<!-- Sidebar End -->




        <!-- Content Start -->
        <div class="content" style="background: initial !important">
            <!-- Navbar Start -->
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
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                </div>
            </nav>
            <!-- Navbar End -->


            <div class="col-sm-12 col-xl-6">
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Ajouter un projet</h6>
        <form method="post" action="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="nom" id="nom" placeholder="nom du projet" required>
                <label for="nom">nom du projet</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" name="description" id="description" placeholder="Description du projet" style="height: 150px;" required></textarea>
                <label for="description">Description du projet</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="plateforme" id="plateforme" placeholder="Plateforme" required>
                <label for="plateforme">Plateforme</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="technologies" id="technologies" placeholder="Technologies utilisées" required>
                <label for="technologies">Technologies utilisées</label>
            </div>
            <div class="form-group">
                <label for="developpeurs">Développeurs</label>
                <select class="form-select mb-3" name="developpeurs[]" id="developpeurs" multiple required>
                    <?php
                    $query = "SELECT * FROM developpeurs";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id_developpeur'] . "'>" . $row['nom'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter Projet</button>
        </form>
    </div>
</div>

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">ISIUM</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>