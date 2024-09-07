<?php
session_start();
require_once "../../../includes/database.php";
require_once "../../../includes/function.php";

// Vérifiez si l'ID de la réservation est passé en paramètre
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Récupérer les informations de la réservation
    $query = $pdo->prepare("SELECT * FROM reservation WHERE ID_Reservation = :reservation_id");
    $query->execute([':reservation_id' => $reservation_id]);
    $reservation = $query->fetch();

    if ($reservation) {
        // Changer le statut de la réservation de "attente" à "terminé"
        $updateReservation = $pdo->prepare("UPDATE reservation SET status = 'terminer' WHERE ID_Reservation = :reservation_id");
        $updateReservation->execute([':reservation_id' => $reservation_id]);

        // Changer le statut de la chambre de "réservé" à "disponible"
        $chambre_id = $reservation['ID_Chambre'];
        $updateChambre = $pdo->prepare("UPDATE chambre SET status = 1 WHERE ID_Chambre = :chambre_id");
        $updateChambre->execute([':chambre_id' => $chambre_id]);

        // Insérer la réservation validée dans l'historique
        $insertHistorique = $pdo->prepare("INSERT INTO historique (ID_Reservation, ID_Chambre, date_validation, status, validate_by, nom, email, numero, prenom,ID_Residence,nbr_jours) VALUES (:id_reservation, :id_chambre, :date, :status, :validated_by,:nom, :email, :numero, :prenom,:residence,:jour)");
        $insertHistorique->execute([
            ':id_reservation' => $reservation_id,
            ':id_chambre' => $chambre_id,
            ':validated_by' => $_SESSION['admin_email'],
            ':status' => $reservation["status"],
            ':nom' => $reservation["nom"],
            ':prenom' => $reservation["prenom"],
            ':email' => $reservation["email"],
            ':numero' => $reservation["numero"],
            ':date' => date("Y-m-d H:i:s"),
            ':residence' => $reservation["ID_Residence"],
            ':jour' => $reservation["nbr_jours"]
        ]);

        $_SESSION['success'] = "Le statut de la réservation a été mis à jour et la chambre est maintenant disponible.";
    } else {
        $_SESSION['error'][] = "La réservation n'a pas été trouvée.";
    }
} else {
    $_SESSION['error'][] = "ID de réservation manquant.";
}

// Rediriger vers la page des réservations
header('Location: ../../../views/admin/pages/reservation.php');
exit();
