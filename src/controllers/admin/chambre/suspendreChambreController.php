<?php
session_start();

require_once '../../../includes/database.php';

// Mise à jour du statut de toutes les chambres
$query = "UPDATE chambre SET status = 2 WHERE status = 1";
$stmt = $pdo->prepare($query);

if ($stmt->execute()) {
    $_SESSION["success"] = "Toutes les chambres ont été suspendues avec succès.";
} else {
    $_SESSION["error"] = "Une erreur est survenue lors de la suspension des chambres.";
}

header('Location: ../../../views/admin/pages/chambre.php'); // Redirection vers la page des chambres
exit();
