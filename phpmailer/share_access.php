<?php
require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../includes/config.php');

$mail = new PHPMailer(true);

try {
    $recipientEmail = $_POST['recipientEmail'];

    $query = "SELECT email, MotDePasse FROM utilisateurs WHERE email = '$recipientEmail'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $userData = mysqli_fetch_assoc($result);
        $userEmail = $userData['email'];
        $userPassword = $userData['MotDePasse'];

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'aminaamjoune123@gmail.com'; 
        $mail->Password   = 'vyscmegkrqnadulg'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('aminaamjoune123@gmail.com', 'Amina');
        $mail->addAddress($recipientEmail);
        $mail->isHTML(true);
        $mail->Subject = 'Bienvenue sur notre plateforme web ! Nous avons le plaisir de vous fournir les informations d identification necessaires pour acceder à notre application en ligne.';
        $mail->Body    = 'Cher utilisateur,<br><br>
                          Nous vous adressons nos salutations les plus cordiales et vous transmettons vos données de connexion pour notre application web :<br>
                          Adresse e-mail : ' . $userEmail . '<br>
                          Mot de passe : ' . $userPassword . '<br><br>
                          Vous pouvez accéder à votre compte en utilisant le lien suivant :  <a href="http://localhost/APP_STAGE4/login/login.php">cliquer ici pour se connecter</a>.<br><br>
                          Nous restons à votre disposition pour toute assistance supplémentaire.';

        $mail->send();
        echo 'Email has been sent successfully!';
    } else {
        echo 'User not found with the provided email address.';
    }
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
