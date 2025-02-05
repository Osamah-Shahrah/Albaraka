<?php
session_start();
unset($_SESSION['id_user']);
unset($_SESSION['logged_in_user']);
session_unset();
session_destroy();

header('Location:../index.php');
exit;
?>