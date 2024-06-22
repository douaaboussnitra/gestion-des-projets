<?php
include('includes/config.php');
session_start();
session_destroy();
header('Location: category.php');
exit;
?>