<?php
session_start();
require_once '../../../includes/database.php';

// Tableau pour stocker les erreurs de formulaire
$errors = [
    'nom' => '',
    'prix' => '',
    'tele' => '',
    'dimension' => '',
    'residence' => '',
    'commo' => '',
    'status' => '',
    'photo_couverture' => '',
    'description' => '',
];

// Traitement du formulaire d'édition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prix = trim($_POST['prix']);
    $tele = trim($_POST['tele']);
    $dimension = trim($_POST['dimension']);
    $residence = trim($_POST['residence']);
    $commo = trim($_POST['commo']);
    $status = trim($_POST['status']);
    $description = trim($_POST['description']);
    $photo_couverture = $_FILES['couverture'];
    $id = trim($_POST["id"]);

    // Taille maximale du fichier (5 Mo)
    $maxFileSize = 5 * 1024 * 1024;

    // Types de fichiers autorisés
    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = "Le nom de la chambre est requise.";
    }
    if (empty($residence)) {
        $errors['residence'] = "Le residence est requis.";
    }
    if (empty($commo)) {
        $errors['commo'] = "Le comodite est requis.";
    }
    if (empty($dimension)) {
        $errors['dimension'] = "Le dimension est requis.";
    }
    if (empty($prix)) {
        $errors['prix'] = "Le prix est requis.";
    }
    if (empty($tele)) {
        $errors['tele'] = "La television est requise.";
    }
    if (empty($status)) {
        $errors['status'] = "Le statut est requis.";
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
        $target_dir = "../../../uploads/imgChambre/";
        $target_file = $target_dir . basename($photo_couverture["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!move_uploaded_file($photo_couverture["tmp_name"], $target_file)) {
            $errors['photo_couverture'] = "Erreur lors du téléchargement de la photo de couverture.";
        }
    }

    if (empty(array_filter($errors))) {
        // Mise à jour du livre dans la base de données
        // Préparation de la requête SQL avec une condition pour inclure la photo de couverture si elle est fournie
        $sql = "UPDATE chambre SET nom = :nom, description = :description, prix = :prix, status = :status, television = :television, comodite = :comodite, dimension = :dimension, ID_Residence = :residence";

        if (!empty($photo_couverture['name'])) {
            $sql .= ", image = :photo_couverture";
        }
        $sql .= " WHERE ID_Chambre = :id";
        $stmt = $pdo->prepare($sql);
        // Mise à jour du tableau des paramètres
        $params = [
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':status' => $status,
            ':television' => $tele,
            ':comodite' => $commo,
            ':dimension' => $dimension,
            ':residence' => $residence,
            ':id' => $id  // Corrigé pour correspondre à la requête SQL
        ];

        if (!empty($photo_couverture['name'])) {
            $params[':photo_couverture'] = basename($photo_couverture["name"]);
        }

        // Exécution de la requête
        $stmt->execute($params);


        $_SESSION["success"] = "chambre mis à jour avec succès!";
        header('Location: ../../../views/admin/pages/chambre.php');
        exit();
    }

    // Stocker les erreurs en session si présentes
    $_SESSION['errors'] = $errors;
    header('Location: ../../../views/admin/forms/editChambre.php?id=' . $id);
}
