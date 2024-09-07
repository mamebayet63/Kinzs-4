<?php
session_start();
require_once '../../../includes/database.php';

// Tableau pour stocker les erreurs de formulaire
$errors = [
    'nom' => '',
    'adresse' => '',
    'wifi' => '',
    'nombre' => '',
    'couverture' => '',
    'description' => '',
];

// Traitement du formulaire d'édition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $adresse = trim($_POST['adresse']);
    $wifi = trim($_POST['wifi']);
    $nombre = trim($_POST['nombre']);
    $description = trim($_POST['description']);
    $photo_couverture = $_FILES['couverture'];
    $residenceId = trim($_POST["id"]);

    // Taille maximale du fichier (5 Mo)
    $maxFileSize = 5 * 1024 * 1024;

    // Types de fichiers autorisés
    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = "Le nom de la residence est requise.";
    }
    if (empty($adresse)) {
        $errors['adresse'] = "L'adresse est requis.";
    }
    if (empty($wifi)) {
        $errors['wifi'] = "La wifi est requise.";
    }
    if (empty($nombre)) {
        $errors['nombre'] = "Le nombre de chambre est requis.";
    }
    if (empty($description)) {
        $errors['description'] = "La description est requise.";
    }

    // Traitement de la photo de couverture (si modifiée)
    if (!empty($photo_couverture['name'])) {
        // Vérifier la taille du fichier
        if ($photo_couverture['size'] > $maxFileSize) {
            $errors['photo_couverture'] = "La taille de la photo de couverture ne doit pas dépasser 5 Mo.";
        }

        // Vérifier le type de fichier
        if (!in_array($photo_couverture['type'], $allowedFileTypes)) {
            $errors['photo_couverture'] = "La photo de couverture doit être au format JPG, JPEG ou PNG.";
        }

        // Gérer le téléchargement de la photo de couverture
        $target_dir = "../../../uploads/imgResidence/";
        $target_file = $target_dir . basename($photo_couverture["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!move_uploaded_file($photo_couverture["tmp_name"], $target_file)) {
            $errors['photo_couverture'] = "Erreur lors du téléchargement de la photo de couverture.";
        }
    }

    if (empty(array_filter($errors))) {
        // Mise à jour du livre dans la base de données
        $stmt = $pdo->prepare("UPDATE residence SET nom = :nom, adresse = :adresse, wifi = :wifi, description = :description, nbr_chambre = :nombre" . (!empty($photo_couverture['name']) ? ", couverture = :photo_couverture" : "") . " WHERE ID_Residence = :id");
        $params = [
            ':nom' => $nom,
            ':description' => $description,
            ':wifi' => $wifi,
            ':adresse' => $adresse,
            ':nombre' => $nombre,
            ':id' => $residenceId
        ];

        if (!empty($photo_couverture['name'])) {
            $params[':photo_couverture'] = basename($photo_couverture["name"]);
        }

        $stmt->execute($params);

        $_SESSION["success"] = "residence mis à jour avec succès!";
        header('Location: ../../../views/admin/pages/residence.php');
        exit();
    }

    // Stocker les erreurs en session si présentes
    $_SESSION['errors'] = $errors;
    header('Location: ../../../views/admin/forms/formUpdate/editResidence.php?id=' . $residenceId);
}
