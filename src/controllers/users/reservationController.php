<?php
session_start();

require_once '../../includes/database.php';
require_once '../../includes/function.php';

$currentDate = date('Y-m-d');

// Tableau pour stocker les erreurs de formulaire
$errors = [
    'nom' => '',
    'prenom' => '',
    'numero' => '',
    'debut' => '',
    'jours' => '',
    'email' => '',
];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $numero = $_POST['numero'];
    $jours = $_POST['jours'];
    $date_debut = $_POST['debut'];
    $id_chambre = $_POST["id_chambre"];
    $id_residence = $_POST["id_residence"];
    $email = $_POST["email"];

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = "Le nom utilisateur est requise.";
    }
    if (empty($email)) {
        $errors['email'] = "L'email utilisateur est requise.";
    }
    if (empty($prenom)) {
        $errors['prenom'] = "Le prenom utilisateur est requise.";
    }
    if (empty($numero)) {
        $errors['numero'] = "Le numero utilisateur est requise.";
    }
    if (empty($date_debut)) {
        $errors["debut"] = "Une date de début est requise.";
    }
    if (empty($jours)) {
        $errors["jours"] = "le nombre de jours est requise.";
    }
    if (!empty($jours) && $jours <= 0) {
        $errors["jours"] = "un nombre de jours valide est requise.";
    }

    // Vérifications supplémentaires si les dates ne sont pas vides
    if (!empty($debut)) {
        if (strtotime($debut) < strtotime($currentDate)) {
            $errors["debut"] = "La date de début ne peut pas être antérieure à la date actuelle.";
        }
    }

    if (empty(array_filter($errors))) {
        try {
            $query = "INSERT INTO reservation (nom, prenom, nbr_jours, numero, date_debut, ID_Chambre, ID_Residence,email) VALUES (:nom, :prenom, :jours, :numero, :date_debut, :chambre, :residence,:email)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':jours' => $jours,
                ':numero' => $numero,
                ':date_debut' => $date_debut,
                ':chambre' => $id_chambre,
                ':residence' => $id_residence,
                ':email' => $email,
            ]);
            if (envoyerEmailReservation($email, $nom, $prenom, $numero, $date_debut, $jours)) {
                $_SESSION["success"] = "Demande de réservation effectuée avec succès. Un de nos agents vous contactera très bientôt pour la confirmation.";
                header('Location: ../../views/users/chambre.php');
                exit();
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }


    $_SESSION['errors'] = $errors;
    $_SESSION['message'] = "Les donnees soumises contiennent des erreurs";
    header("Location: ../../views/users/chambre.php");
    exit();
}
