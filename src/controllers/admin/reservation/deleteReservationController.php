<?php
session_start();
require_once "../../../includes/database.php";
require_once "../../../includes/function.php";


// Vérifiez si l'ID de la réservation est passé en paramètre
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Récupérer les informations de la réservation
    $query = $pdo->prepare("SELECT ID_Chambre FROM reservation WHERE ID_Reservation = :reservation_id");
    $query->execute([':reservation_id' => $reservation_id]);
    $reservation = $query->fetch();

    if ($reservation) {
        // Supprimer la réservation
        $deleteReservation = $pdo->prepare("DELETE FROM reservation WHERE ID_Reservation = :reservation_id");
        $deleteReservation->execute([':reservation_id' => $reservation_id]);

        $_SESSION['success'] = "La réservation a été supprimée ";
    } else {
        $_SESSION['error'][] = "La réservation n'a pas été trouvée.";
    }
} else {
    $_SESSION['error'][] = "ID de réservation manquant.";
}

// Rediriger vers la page des réservations
header('Location: ../../../views/admin/pages/reservation.php');
exit();
