<?php

include('includes/config.php');

header("Location: category.php");
exit();
?>
 
 <!DOCTYPE html>
<html lang="en">

<head>
   
    <meta charset="utf-8">
    <!-- Titre de la page -->
    <title>GESTION DES PROJETS</title>
    <!-- Définition de la fenêtre d'affichage -->
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Mots-clés pour le SEO -->
    <meta content="" name="keywords">
    <!-- Description de la page pour le SEO -->
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
</head>

<body>
    <div class="container-xxl position-relative d-flex p-0">
        <!-- Début du spinner de chargement -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Fin du spinner de chargement -->

        <!-- Début de la barre latérale -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <!-- Logo de la marque -->
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                  <!--
                  <div class="d-flex align-items-center justify-content-center mb-3">  
                        <img src="img/isium_logo-removebg-preview.png" alt="Logo de l'entreprise" class="img-fluid mb-4" >
                    </div>
                  -->
                </a>
                <!-- Utilisateur connecté -->
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <img src="img/isium_logo-removebg-preview.png" alt="Logo de l'entreprise" class="img-fluid mb-4">
                        </div>                        
                    </div>
                </div>
                <!-- Navigation dans la barre latérale -->
                <div class="navbar-nav w-100">
                    <!--<a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>-->
                    <!--
                    <div class="nav-item dropdown">
                       <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="button.php" class="dropdown-item">Buttons</a>
                            <a href="typography.php" class="dropdown-item">Typography</a>
                            <a href="element.php" class="dropdown-item">Other Elements</a>
                        </div>
                    </div>
                    -->
                   <!-- <a href="create_project.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>createproject</a>-->
                    <!--<a href="widget.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
                    <a href="widget.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
                    <a href="widget.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>-->

                    <!--<a href="widget.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>-->
                    <!--<a href="form.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>-->
                    <a href="table.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
                    <!--<a href="chart.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>-->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="login/login.php" class="dropdown-item">login</a>
                            <a href="404.php" class="dropdown-item">404 Error</a>
                            <a href="blank.php" class="dropdown-item">Blank Page</a>
                            <a href="create_project.php" class="dropdown-item">create project</a>
                            <a href="add_documentation.php" class="dropdown-item">documentation</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Fin de la barre latérale -->

        <!-- Début du contenu principal -->
        <div class="content" style="background: initial !important">
            <!-- Début de la barre de navigation -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class=""></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <!-- Menu des messages -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <!-- Menu des notifications -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <!-- Menu de l'utilisateur -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">Jhon Doe</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Fin de la barre de navigation -->

            <!-- Début du contenu principal de la page -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">GESTION DES PROJETS</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">NOM</th>
                                        <th scope="col">DUREE</th>
                                        <th scope="col">EQUIPE</th>
                                        <th scope="col">DIRECTION</th>
                                        <th scope="col">DEBUT</th>
                                        <th scope="col">FIN</th>
                                        <th scope="col">ETAT</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Inclusion du fichier de connexion
                                        include 'connect.php';

                                        // Requête SQL pour récupérer les projets
                                        $sql = "SELECT * FROM projet";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            // Parcours des résultats
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                // Extraction des données
                                                $id = $row['id'];
                                                $nom = $row['nom'];
                                                $duree = $row['duree'];
                                                $equipe = $row['equipe'];
                                                $direction = $row['direction'];
                                                $debut = $row['debut'];
                                                $fin = $row['fin'];
                                                $etat = $row['etat'];
                                                // Affichage des données dans la table
                                                echo '<tr>';
                                                echo '<th scope="row">' . $id . '</th>';
                                                echo '<td>' . $nom . '</td>';
                                                echo '<td>' . $duree . '</td>';
                                                echo '<td>' . $equipe . '</td>';
                                                echo '<td>' . $direction . '</td>';
                                                echo '<td>' . $debut . '</td>';
                                                echo '<td>' . $fin . '</td>';
                                                echo '<td>' . $etat . '</td>';
                                                echo '<td>
                                                        <button class="btn btn-primary"><a href="update_project.php?updateid=' . $id . '" class="text-light">Update</a></button>
                                                        <button class="btn btn-danger"><a href="delete_project.php?deleteid=' . $id . '" class="text-light">Delete</a></button>
                                                      </td>';
                                                echo '</tr>';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin du contenu principal de la page -->

            <!-- Début du pied de page -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!-- Crédit obligatoire -->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                            <!-- Distribution autorisée uniquement avec ce lien -->
                            Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin du pied de page -->
        </div>
        <!-- Fin du contenu principal -->

        <!-- Début du bouton "Back to Top" -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        <!-- Fin du bouton "Back to Top" -->
    </div>

    <!-- Bibliothèques JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template JavaScript -->
    <script src="js/main.js"></script>
</body>

</html>
