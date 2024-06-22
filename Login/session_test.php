<?php
session_start();
$_SESSION['test'] = 'Hello, world!';
echo $_SESSION['test'];
?>
