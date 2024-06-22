<?php
session_start();
include('../includes/config.php');

$email = "";
$password = "";
$errors = array();

$typeDefault = isset($_GET['id']) ? $_GET['id'] : 'project';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if (empty($email)) array_push($errors, "Email is required");
    if (empty($password)) array_push($errors, "Password is required");

    if (count($errors) == 0) {
        $query = "SELECT * FROM utilisateurs WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if ($password == $user['MotDePasse']) {  
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id_utilisateur'];

                switch ($type) {
                    case 'project':
                        if ($user['role'] == 'admin') {
                            header('Location: ../table.php');
                        } else {
                            header('Location: ../table_user.php');
                        }
                        break;
                    case 'documentation':
                        header('Location: ../table_documentation.php');
                        break;
                    case 'description':
                        header('Location: ../description/scholar-1.0.0/index.php');
                        break;
                    case 'hebergements':
                        header('Location: ../table_hebergement.php');
                        break;
                    default:
                        header('Location: ../category.php');
                        break;
                }
                exit;
            } else {
                array_push($errors, "Wrong email/password combination");
            }
        } else {
            array_push($errors, "Wrong email/password combination");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V4</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

</head>
<body>
<div class="limiter">
    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
            <form class="login100-form validate-form" method="post" action="login.php">
                <span class="login100-form-title p-b-49">Connexion</span>

                <?php if (count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <div class="wrap-input100 validate-input m-b-23" data-validate="L'email est requis">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="text" name="email" placeholder="Entrez votre email" value="<?php echo htmlspecialchars($email); ?>">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Le mot de passe est requis">
                    <span class="label-input100">Mot de passe</span>
                    <input class="input100" type="password" name="pass" placeholder="Entrez votre mot de passe">
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                </div>

                <div class="text-right p-t-8 p-b-31">
                    <a href="#">Mot de passe oublié ?</a>
                </div>
                <input type="hidden" name="type" value="<?php echo htmlspecialchars($typeDefault); ?>">

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" type="submit">Connexion</button>
                    </div>
                </div>

                <div class="txt1 text-center p-t-54 p-b-20">
                    <span>Ou connectez-vous avec</span>
                </div>
                <div class="flex-c-m">
                    <a href="#" class="login100-social-item bg1"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="login100-social-item bg2"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="login100-social-item bg3"><i class="fa fa-google"></i></a>
                </div>
                <div class="flex-col-c p-t-155">
                    <span class="txt1 p-b-17">Ou inscrivez-vous avec</span>
                    <a href="#" class="txt2">Inscription</a>
                </div>
            </form>
        </div>
    </div>
</div>
	

	<div id="dropDownSelect1"></div>
	

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

	<script src="vendor/animsition/js/animsition.min.js"></script>

	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="vendor/select2/select2.min.js"></script>

	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>

	<script src="vendor/countdowntime/countdowntime.js"></script>

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
	<script src="js/main.js"></script>

</body>
</html>