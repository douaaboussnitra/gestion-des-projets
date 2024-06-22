<?php
include('includes/config.php');


$query = "SELECT d.id_documentation, p.nom, d.proc_ins_local, d.proc_ins_production, d.code_source
          FROM Documentation d
          JOIN projets p ON d.id_projet = p.id_projet";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Liste de Documentation</title>
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
                    <h6 class="mb-4">Liste de Documentation</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Documentation</th>
                                    <th>Nom de Projet</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id_documentation'] . "</td>";
                                        echo "<td>" . $row['nom'] . "</td>";
                                        echo "<td><a href='show_documentation.php?id=" . $row['id_documentation'] . "' class='btn btn-primary'>Show</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No documentation found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="documentation-details" class="container-fluid pt-4 px-4" style="display: none;">
                <div class="bg-light rounded p-4">
                    <h6 class="mb-4">Documentation Details</h6>
                    <div class="form-group">
                        <label for="proc_ins_local">Installation Procedure (Local):</label>
                        <textarea id="proc_ins_local" class="form-control" rows="4" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="proc_ins_production">Installation Procedure (Production):</label>
                        <textarea id="proc_ins_production" class="form-control" rows="4" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="code_source">Code Source:</label>
                        <input type="text" id="code_source" class="form-control" readonly>
                    </div>
                    <button class="btn btn-secondary" onclick="hideDocumentationDetails()">Close</button>
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
        function showDocumentationDetails(id) {
            // Fetch documentation details using AJAX
            $.ajax({
                url: 'get_documentation_details.php',
                type: 'GET',
                data: {id: id},
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#proc_ins_local').val(data.proc_ins_local);
                    $('#proc_ins_production').val(data.proc_ins_production);
                    $('#code_source').val(data.code_source);
                    $('#documentation-details').show();
                }
            });
        }

        function hideDocumentationDetails() {
            $('#documentation-details').hide();
        }
    </script>
</body>
</html>
