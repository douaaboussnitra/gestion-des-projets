<?php

$db_host = 'localhost';  
$db_user = 'root'; 
$db_password = ''; 
$db_name = 'gestion_app'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}


function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
?>
