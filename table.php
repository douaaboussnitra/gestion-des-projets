<?php

include('includes/config.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gestion des projets</title>
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
    <style>
        .icon-container {
    display: flex; 
}

.icon {
    width: 24px; 
    height: 24px;
}

.icon-link,
.icon-button {
    margin-right: 5px; 
}

.icon-button {
    border: none;
    background: none;
    padding: 0;
    cursor: pointer;
}

    </style>
</head>

<body>
    <div class="container-xxl position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

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


        <!-- Content Start -->
        <div class="content" style="background: initial !important">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                
                <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
                </a>

                <form class="d-none d-md-flex ms-4 search-form">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>

            </nav>

          
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4"></h6>
                    <button type="button" class="btn btn-outline-secondary m-2"><a href="create_project.php" class="text-dark">Ajouter Projet</a></button>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom Projet</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Plateforme</th>
                                    <th scope="col">Technologies</th>
                                    <th scope="col">Développeur</th>
                                    <th scope="col">Hébergement</th>
                                    <th scope="col">Documentation</th>
                                    <th scope="col">Actions</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                              $query = "
                              SELECT p.*, c.id_documentation, GROUP_CONCAT(d.nom SEPARATOR ', ')  AS developpeurs 
                              FROM Projets p 
                              LEFT JOIN Projets_developpeurs pd ON p.id_projet = pd.id_projet
                              LEFT JOIN developpeurs d ON pd.id_developpeur = d.id_developpeur
                              LEFT JOIN documentation c ON c.id_projet  = p.id_projet 
                              GROUP BY p.id_projet";
                                
                                $result = mysqli_query($conn, $query);

                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<th scope='row'>" . htmlspecialchars($row['id_projet'] ?? '') . "</th>";
                                            echo "<td>" . htmlspecialchars($row['nom'] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row['description'] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row['plateforme'] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row['technologies'] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row['developpeurs'] ?? '') . "</td>";
                                            if (!empty($row['id_hebergement'])) {
                                                echo "<td><a href='show_hebergement.php?id=" . htmlspecialchars($row['id_hebergement']) . "' class='btn btn-outline-primary m-2'>Hébergement</a></td>";
                                            } else {
                                                echo "<td><button class='btn btn-outline-primary m-2 btn-hebergement' data-project-id='" . htmlspecialchars($row['id_projet']) . "'>Hébergement</button></td>";
                                            }
                                            
                                            if (!empty($row['id_documentation'])) {
                                                echo "<td><a href='show_documentation.php?id=" . htmlspecialchars($row['id_documentation']) . "' class='btn btn-outline-secondary m-2'>Documentation</a></td>";
                                            } else {
                                                echo "<td><button class='btn btn-outline-secondary m-2 btn-documentation' data-project-id='" . htmlspecialchars($row['id_projet']) . "'>Documentation</button></td>";
                                            }
                                            echo "<td>
                                            <div class='icon-container'>
                                            <a href='show_project.php?id=" . $row['id_projet'] . "' class='icon-link'><img src='img/loupe1.png' alt='show' class='icon'></a>

                                                <a href='update_project.php?id=" . htmlspecialchars($row['id_projet']) . "' class='icon-link'><img src='img/edit.png' alt='Modifier' class='icon'></a>
                                                <form method='post' action='delete_project.php'>
                                                    <input type='hidden' name='id_projet' value='" . htmlspecialchars($row['id_projet'] ?? '') . "'>
                                                    <button type='submit' class='icon-button'><img src='img/delete.png' alt='Supprimer' class='icon'></button>
                                                </form>

                                            </div>
                                        </td>";
                                        


                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='10'>No projects found.</td></tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>Error: " . mysqli_error($conn) . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           

            
            <div class="modal fade" id="addDocumentationModal" tabindex="-1" aria-labelledby="addDocumentationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentationModalLabel">Ajouter Documentation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="add_documentation.php" id="addDocumentationForm">
                    <input type="hidden" id="id_projet_modal" name="id_projet">
                    <div class="form-group">
                        <label for="proc_ins_local_modal">Procédure Installation Local</label>
                        <textarea id="proc_ins_local_modal" name="proc_ins_local" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="proc_ins_production_modal">Procédure Installation Production</label>
                        <textarea id="proc_ins_production_modal" name="proc_ins_production" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="code_source_modal">Code Source</label>
                        <input type="text" id="code_source_modal" name="code_source" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-secondary">Documentation</button>
                </form>
            </div>
        </div>
    </div>
</div>


            <div class="modal fade" id="addHebergementModal" tabindex="-1" aria-labelledby="addHebergementModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addHebergementModalLabel">Ajouter Hébergement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addHebergementForm" action="add_hebergement.php" method="POST">
                                <input type="hidden" name="id_projet" id="hebergementProjectId">
                                <div class="mb-3">
                                    <label for="hebergementNom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="hebergementNom" name="nom" required>
                                </div>
                                <div class="mb-3">
                                    <label for="hebergementaccès" class="form-label">Accès</label>
                                    <textarea class="form-control" id="hebergementaccès" name="accès" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-secondary">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content End -->
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

    <!-- Custom JavaScript for handling the modals -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle the click event for adding documentation
            document.querySelectorAll('.btn-documentation').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            var projectId = item.dataset.projectId;
            document.getElementById('id_projet_modal').value = projectId; // Set project ID value in the form
            var myModal = new bootstrap.Modal(document.getElementById('addDocumentationModal'), {
                keyboard: false
            });
            myModal.show();
        });
    });

            // Handle the click event for adding hebergement
            document.querySelectorAll('.btn-hebergement').forEach(function(button) {
                button.addEventListener('click', function() {
                    const projectId = this.getAttribute('data-project-id');
                    document.getElementById('hebergementProjectId').value = projectId;
                    const hebergementModal = new bootstrap.Modal(document.getElementById('addHebergementModal'));
                    hebergementModal.show();
                });
            });
        });
    </script>
</body>
</html>
