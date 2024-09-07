<?php
session_start();
require_once '../../../includes/database.php';

$residenceId = $_GET['id'] ?? null;

if ($residenceId) {
    $stmt = $pdo->prepare("SELECT couverture FROM residence WHERE ID_Residence = :id");
    $stmt->execute([':id' => $residenceId]);
    $residence = $stmt->fetch();

    if ($residence) {
        $target_dir = "../../../uploads/imgResidence/";
        $photo_couverture = $residence['image'];
        if ($photo_couverture) {
            unlink($target_dir . $photo_couverture);
        }
        $stmt = $pdo->prepare("DELETE FROM residence WHERE ID_Residence = :id");
        $stmt->execute([':id' => $residenceId]);

        $_SESSION["success"] = "Residence supprimé avec succès!";
    } else {
        $_SESSION["error"] = "residence non trouvé.";
    }
} else {
    $_SESSION["error"] = "ID du residence manquant.";
}

header('Location: ../../../views/admin/pages/residence.php');
exit();
