<?php
include('includes/config.php');

$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$projects_result = null;
$developers_result = null;
$documentation_result = null;
$hebergements_result = null;

if ($project_id > 0) {
    $projects_sql = "SELECT p.id_projet, p.nom, p.description, p.plateforme, p.technologies, h.nom AS hebergement_nom, h.accès AS hebergement_accès 
                     FROM projets p 
                     LEFT JOIN hebergement h ON p.id_hebergement = h.id_hebergement 
                     WHERE p.id_projet = ?";
    $stmt = $conn->prepare($projects_sql);
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $projects_result = $stmt->get_result();

    if ($projects_result === false) {
        die("Error executing projects SQL: " . $conn->error);
    }

    $developers_sql = "SELECT d.nom , d.role FROM projets_developpeurs pd LEFT JOIN developpeurs d on d.id_developpeur = pd.id_developpeur where pd.id_projet = ?";
    $stmt2 = $conn->prepare($developers_sql);
    $stmt2->bind_param("i", $project_id);
    $stmt2->execute();
    $developers_result = $stmt2->get_result();

    if ($developers_result === false) {
        die("Error executing developers SQL: " . $conn->error);
    }

    $documentation_sql = "SELECT * FROM documentation WHERE id_projet = ?";
    $stmt3 = $conn->prepare($documentation_sql);
    $stmt3->bind_param("i", $project_id);
    $stmt3->execute();
    $documentation_result = $stmt3->get_result();

    if ($documentation_result === false) {
        die("Error executing documentation SQL: " . $conn->error);
    }

    $hebergements_sql = "SELECT * FROM hebergement WHERE id_hebergement IN (SELECT id_hebergement FROM projets WHERE id_projet = ?)";
    $stmt4 = $conn->prepare($hebergements_sql);
    $stmt4->bind_param("i", $project_id);
    $stmt4->execute();
    $hebergements_result = $stmt4->get_result();

    if ($hebergements_result === false) {
        die("Error executing hebergements SQL: " . $conn->error);
    }
}

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
                <a href="table_user.php" class="nav-item nav-link "><i class="fa fa-project-diagram me-2"></i>Projets</a>
            <?php endif; ?>
            <a href="table_documentation.php" class="nav-item nav-link"><i class="fa fa-book me-2"></i>Documentations</a>
            <a href="table_hebergement.php" class="nav-item nav-link"><i class="fa fa-server me-2"></i>Hébergements</a>
            <a href="profile.php" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Profil</a>
            <a href="#" id="logout-button" class="nav-item nav-link"><i class="fa fa-sign-out-alt me-2"></i>Déconnexion</a>
        </div>
    </nav>
</div>

        <!-- Content Start  -->
        <div class="content" style="background: initial !important">
            <!-- Navbar Start -->
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
                        <!-- <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                           <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>-->
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <!--<a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>-->
                            <hr class="dropdown-divider">
                           <!-- <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>-->
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
                       <!-- <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>-->
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


            <!-- Table Start 
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Basic Table</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>jhon@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>mark@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>jacob@email.com</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Accented Table</h6>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>jhon@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>mark@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>jacob@email.com</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Hoverable Table</h6>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>jhon@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>mark@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>jacob@email.com</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Bordered Table</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>jhon@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>mark@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>jacob@email.com</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                -->
                <div class="col-12">
   
   
 
 
 
                <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4"></h6>
      




        <div style="justify-content: center;
        align-items: center;
        display: flex;
        flex-direction: column;
        background: white;
        margin: 20px;
        padding: 40px 10px;
        border-radius: 20px;
        box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
    ">
            
            <?php if ($projects_result->num_rows > 0): ?>
                <?php while($project = $projects_result->fetch_assoc()): ?>
                    <header>
                        <h1 class="mb-4 text-uppercase" style="color:#8abc40"><?php echo htmlspecialchars($project['nom']); ?></h1>
                    </header>
            <section id="projects">
                        <div class="project-card" style="width: 60vw; ">
                           
                            <div class="form-group row" style="margin:10px 0">
                                <label class="col-sm-3 col-form-label" style="color:#8abc40" >Description</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($project['description']); ?>">
                                </div>
                            </div>
                            <div class="form-group row" style="margin:10px 0">
                                <label class="col-sm-3 col-form-label" style="color:#8abc40" >Plateforme</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($project['plateforme']); ?>">
                                </div>
                            </div>
                            <div class="form-group row" style="margin:10px 0">
                                <label class="col-sm-3 col-form-label" style="color:#8abc40" >Technologies</label>
                                <div class="col-sm-9">
                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($project['technologies']); ?>">
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No projects found.</p>
                <?php endif; ?>
            
            <section id="project-developers">
    
                <?php if ($developers_result->num_rows > 0): ?>
                    <?php while($developer = $developers_result->fetch_assoc()): ?>
                        <div class="project-card mt-4" style="width: 60vw; ">
                        <div class="form-group row" style="margin:10px 0">
                                <label class="col-sm-3 col-form-label" style="color:#8abc40">Developers</label>
                                <div class="col-sm-4">
                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($developer['nom']); ?>">
                                </div>
                                <label class="col-sm-1 col-form-label">Role </label>
                                <div class="col-sm-4">
                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($developer['role']); ?>">
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No project developers found.</p>
                <?php endif; ?>
            </section>
            <section id="project-documentation">
    
            <?php if ($documentation_result->num_rows > 0): ?>
                <?php while($doc=$documentation_result->fetch_assoc()): ?>
                        <div class="project-card mt-4" style="width: 60vw; ">
                        <div class="form-group row" style="margin:10px 0">
                                <label class="col-sm-3 col-form-label" style="color:#8abc40">Documentation</label>
                                <div class="col-sm-9 row mx-0" >
                                        <label class="col-sm-6 col-form-label p-0 mt-1"> Procédure Installation Locale </label>
                                        <div class="col-sm-6 mt-1 px-0">
                                            <textarea type="text" disabled class="form-control"><?php echo htmlspecialchars($doc['proc_ins_local']); ?></textarea>
                                        </div>
                                        <label class="col-sm-6 col-form-label p-0 mt-1"> Procédure Installation Production </label>
                                        <div class="col-sm-6 mt-1 px-0">
                                        <textarea type="text" disabled class="form-control"><?php echo htmlspecialchars($doc['proc_ins_production']); ?></textarea>
                                        </div>
                                        <label class="col-sm-6 col-form-label p-0 mt-1"> Code Source </label>
                                        <div class="col-sm-6 mt-1 px-0">

                                            <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($doc['code_source']); ?>">
                                        </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Aucune documentation trouvée pour ce projet.</p>
                <?php endif; ?>
            </section>
            <section id="project-hebergement">
    
            <section id="project-hebergement">
    <?php if ($hebergements_result->num_rows > 0): ?>
        <?php while($hebergement = $hebergements_result->fetch_assoc()): ?>
            <div class="project-card mt-4" style="width: 60vw;">
                <div class="form-group row" style="margin:10px 0">
                    <label class="col-sm-3 col-form-label" style="color:#8abc40">Hébergement</label>
                    <div class="col-sm-9 row mx-0" >
                        <label class="col-sm-6 col-form-label p-0 mt-1">Nom d'hébergement</label>
                        <div class="col-sm-6 mt-1 px-0">
                            <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($hebergement['nom']); ?>">
                        </div>
                        <label class="col-sm-6 col-form-label p-0 mt-1">Accès</label>
                        <div class="col-sm-6 mt-1 px-0">
                            <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($hebergement['accès']); ?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Aucune hebergement trouvée pour ce projet.</p>
    <?php endif; ?>
</section>
            
        </div>
        <div class="mt-3" style="display: flex; justify-content: center;">
                                <a href="table_user.php" class="btn btn-primary">Retour</a>
                            </div>
    </div>
</div>
            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">ISIUM </a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">ISIUM</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
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
