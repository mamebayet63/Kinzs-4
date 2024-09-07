<?php
session_start();
require_once '../../../includes/database.php';

$ChambreId = $_GET['id'] ?? null;

if ($ChambreId) {
    $stmt = $pdo->prepare("SELECT image FROM chambre WHERE ID_Chambre = :id");
    $stmt->execute([':id' => $ChambreId]);
    $chambre = $stmt->fetch();

    if ($chambre) {
        $target_dir = "../../../uploads/imgChambre/";
        $photo_couverture = $chambre['image'];
        if ($photo_couverture) {
            unlink($target_dir . $photo_couverture);
        }
        $stmt = $pdo->prepare("DELETE FROM chambre WHERE ID_Chambre = :id");
        $stmt->execute([':id' => $ChambreId]);

        $_SESSION["success"] = "Chambre supprimé avec succès!";
    } else {
        $_SESSION["error"] = "chambre non trouvé.";
    }
} else {
    $_SESSION["error"] = "ID du chambre manquant.";
}

header('Location: ../../../views/admin/pages/chambre.php');
exit();
