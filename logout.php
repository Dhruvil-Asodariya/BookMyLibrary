<?php
session_start();

unset($_SESSION['user']);
unset($_SESSION['admin']);

session_destroy();

setcookie("success", "Logged out successfully", time() + 2);

header("Location: login.php");
exit();
?>