<?php
session_start();
session_unset();
session_destroy();
$_SESSION["success"] = "Vous avez été déconnecté avec succès.";
header("Location: ../../../views/admin/auth/connexion.php");
exit();
