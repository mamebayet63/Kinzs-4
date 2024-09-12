<?php

// Inclure PHPMailer
require_once __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function notification($icon, $type, $message)
{
    echo "
    <div class='col-10 col-md-5 p-3 d-flex gap-3 align-items-center shadow-sm bg-white z-3 position-absolute top-0 start-50 translate-middle-x notif'>
        <i class='$icon text-$type fs-4'></i>
        <p class='m-0'>$message</p>
        <div class='position-absolute top-0 end-0 p-1'>
            <i class='ri-close-circle-fill text-$type fs-4 close'></i>
        </div>
    </div>
    ";
}

function authentificationAdmin($email, $password)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE identifiant = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            return ['authenticated' => true, 'admin' => $user];
        } else {
            return ['authenticated' => false, 'admin' => $user];
        }
    } else {
        return ['authenticated' => false, 'admin' => null];
    }
}

function getStatus($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM status");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchParamsToGetResidences($pdo, $filters)
{
    $searchTerm = $filters['search'] ?? '';

    $query = "SELECT * FROM residence WHERE 1";
    $params = [];

    if (!empty($searchTerm)) {
        $query .= " AND nom LIKE :searchTerm";
        $params[':searchTerm'] = '%' . $searchTerm . '%';
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchParamsToGetReservations($pdo, $filters)
{
    // Récupérer le terme de recherche s'il existe
    $searchTerm = $filters['search'] ?? '';

    // Requête avec jointure pour récupérer le nom de la chambre
    $query = "SELECT reservation.*, chambre.nom AS chambre_nom 
              FROM reservation
              JOIN chambre ON reservation.ID_Chambre = chambre.ID_Chambre
              WHERE 1";

    // Tableau pour stocker les paramètres
    $params = [];

    // Si un terme de recherche est présent, on ajoute une condition
    if (!empty($searchTerm)) {
        $query .= " AND email LIKE :searchTerm";
        $params[':searchTerm'] = '%' . $searchTerm . '%';
    }

    // Préparation et exécution de la requête
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    // Renvoyer les résultats
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getResidenceWithId($pdo, $residenceId)
{
    $stmt = $pdo->prepare("SELECT * FROM residence WHERE ID_Residence = :id");
    $stmt->execute([':id' => $residenceId]);
    return $stmt->fetch();
}

function getResidence($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM residence");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReservation($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM reservation");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getChambres($pdo, $residence_id = null)
{
    if ($residence_id) {
        $stmt = $pdo->prepare("SELECT * FROM chambre WHERE ID_Residence = :residence_id");
        $stmt->execute([':residence_id' => $residence_id]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM chambre");
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getChambreWithId($pdo, $chambreId)
{
    $stmt = $pdo->prepare("SELECT * FROM chambre WHERE ID_Chambre = :id");
    $stmt->execute([':id' => $chambreId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getThreeFirstchambres($pdo)
{
    $stmt = $pdo->query("SELECT * FROM chambre ORDER BY ID_Chambre LIMIT 6");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNombreReservations($pdo)
{
    $query = $pdo->prepare("SELECT COUNT(*) as total FROM reservation");
    $query->execute();
    $result = $query->fetch();
    return $result['total'];
}

function getChambresByResidence($pdo, $residenceId, $excludeChambreId)
{
    $stmt = $pdo->prepare("SELECT * FROM chambre WHERE ID_Residence = :residenceId AND ID_Chambre != :excludeChambreId");
    $stmt->execute(['residenceId' => $residenceId, 'excludeChambreId' => $excludeChambreId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function envoyerEmailReservation($userMail, $nom, $prenom, $numero, $dateDebut, $nombreJours)
{
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Serveur SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'mamebayet63@gmail.com'; // Votre adresse email
        $mail->Password = 'qdctcqulbuezxfnt'; // Mot de passe d'application ou mot de passe de compte Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        // Configuration de l'email
        $mail->setFrom($userMail, 'Kinz Residences');
        
        // Ajouter deux destinataires
        $mail->addAddress('mamebayet63@gmail.com'); // Premier destinataire (administrateur)
        $mail->addAddress('kinzsas@gmail.com'); // Deuxième destinataire
    
        $mail->Subject = 'Nouvelle réservation';
    
        // Construire le corps du message avec les détails de la réservation
        $mail->Body = "Vous avez une nouvelle réservation : \n\n" .
            "Nom : $nom\n" .
            "Prénom : $prenom\n" .
            "Numéro : $numero\n" .
            "Date de début : $dateDebut\n" .
            "Nombre de jours : $nombreJours\n";
    
        // Envoi de l'email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "La réservation a été effectuée mais l'envoi de l'email a échoué. Erreur: {$e->getMessage()}";
    }
    
}

function getImageGallerieWithId($pdo, $id = null)
{
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM gallerie_chambre WHERE ID_Chambre = :residence_id");
        $stmt->execute([':residence_id' => $id]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM gallerie_chambre");
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getHistoriques($pdo, $start_date = null, $end_date = null, $admin_email = null)
{

    // Requête de base pour récupérer les historiques
    $query = "SELECT * FROM historique WHERE 1=1";

    // Tableau pour stocker les paramètres
    $params = [];

    // Ajout du filtre par plage de dates si les dates sont fournies
    if (!empty($start_date) && !empty($end_date)) {
        $query .= " AND date_validation BETWEEN :start_date AND :end_date";
        $params[':start_date'] = $start_date;
        $params[':end_date'] = $end_date;
    }

    // Ajout du filtre par administrateur si l'email est fourni
    if (!empty($admin_email)) {
        $query .= " AND validate_by = :admin_email";
        $params[':admin_email'] = $admin_email;
    }

    // Préparation et exécution de la requête
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    // Retourner les résultats
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function dumpDie($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}
