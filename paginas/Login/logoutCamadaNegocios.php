<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['loginCodigo']);
header("Location: ./login.php");
?>