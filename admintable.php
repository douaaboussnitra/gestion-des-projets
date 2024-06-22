<?php

include('includes/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    include('admintable.php');
}


$query = "SELECT id_utilisateur, nom, prenom, email FROM utilisateurs WHERE role != 'admin'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gestion des projet</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
    <div class="container-xxl position-relative d-flex p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
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



        <div class="content" style="background: initial !important">
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                       
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                          
                            <hr class="dropdown-divider">

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
                    <div class="nav-item dropdown">
                      
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                           <!-- <a href="#" class="dropdown-item">
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
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">John Doe</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>-->
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

 <!-- Table Start -->
 <div class="container-xxl">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4"></h6>
            <button type="button" class="btn btn-primary"><a href="create_user.php" class="text-light">Ajouter utilisateur</a></button>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Editer</th>
                            <th scope="col">Supprimer</th>
                            <th scope="col">Share Access</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_utilisateur'] . "</td>";
                                echo "<td>" . $row['nom'] . "</td>";
                                echo "<td>" . $row['prenom'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td><a href='edit_user.php?id=" . $row['id_utilisateur'] . "' class='btn btn-primary'>Modifier</a></td>";
                                echo "<td>
                                        <form method='post' action='delete_user.php'>
                                            <input type='hidden' name='id_utilisateur' value='" . $row['id_utilisateur'] . "'>
                                            <button type='submit' class='btn btn-secondary'>Supprimer</button>
                                        </form>
                                      </td>";
                                echo "<td><button type='button' class='btn btn-primary share-access' data-bs-toggle='modal' data-bs-target='#shareAccessModal' data-user-id='" . $row['id_utilisateur'] . "'>Share Access</button></td>"; // New Column
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11'>Aucun utilisateur trouvé.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Table End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">ISIUM </a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://htmlcodex.com">ISIUM</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
      
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
   
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 

<script>
$(document).ready(function() {
    $(document).on('click', '.share-access', function() {
        var recipientEmail = $(this).closest('tr').find('td:nth-child(4)').text(); 
        $.ajax({
            url: 'phpmailer/share_access.php',
            type: 'POST',
            data: { recipientEmail: recipientEmail },
            success: function(response) {
                alert(response); 
            },
            error: function(xhr, status, error) {
                alert('Failed to share access: ' + error); 
            }
        });
    });

    $(document).on('click', '.share-access-btn', function() {
        var userEmail = $('#recipientEmail').val(); 
        
       
        $.ajax({
            url: 'send_email.php', 
            type: 'POST',
            data: { recipientEmail: userEmail }, 
            success: function(response) {
                $('#shareAccessModal').modal('hide');
                $('#successMessage').text(response).fadeIn(); 
                setTimeout(function() {
                    $('#successMessage').fadeOut();
                }, 3000); 
            },
            error: function(xhr, status, error) {
                $('#shareAccessModal').modal('hide'); 
                $('#errorMessage').text('Failed to share access: ' + error).fadeIn(); 
                setTimeout(function() {
                    $('#errorMessage').fadeOut();
                }, 3000); 
            }
        });
    });
});
</script>


    <script src="js/main.js"></script>
</body>

</html>