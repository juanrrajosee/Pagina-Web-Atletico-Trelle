<?php
session_start();
$_SESSION['invitado'] = true;
// por si tenía algo de antes
unset($_SESSION['descuento']);
header('Location: inicio.php');
exit;
