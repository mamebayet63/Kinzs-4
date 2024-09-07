<?php
session_start();
require_once '../../../includes/database.php';
require_once '../../../includes/function.php';


// Tableau pour stocker les erreurs de formulaire
$errors = [
    'nom' => '',
    'prix' => '',
    'tele' => '',
    'armoir' => '',
    'frigo' => '',
    'cuisine' => '',
    'dimension' => '',
    'residence' => '',
    'commo' => '',
    'status' => '',
    'description' => '',
    'toilette' => '',
];


// Traitement du formulaire d'ajout de livre
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prix = trim($_POST['prix']);
    $tele = trim($_POST['tele']);
    $frigo = trim($_POST['frigo']);
    $armoir = trim($_POST['armoir']);
    $cuisine = trim($_POST['cuisine']);
    $toilette = trim($_POST['toilette']);
    $dimension = trim($_POST['dimension']);
    $residence = trim($_POST['residence']);
    $commo = trim($_POST['commo']);
    $status = trim($_POST['status']);
    $description = trim($_POST['description']);

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = "Le nom de la chambre est requise.";
    }
    if (empty($prix)) {
        $errors['prix'] = "Le prix est requis.";
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
    if (empty($tele)) {
        $errors['tele'] = "La television est requise.";
    }
    if (empty($toilette)) {
        $errors['toilette'] = "La toilette est requise.";
    }
    if (empty($armoir)) {
        $errors['armoir'] = "L'armoir est requise est requise.";
    }
    if (empty($cuisine)) {
        $errors['cuisine'] = "La cuisine est requise.";
    }
    if (empty($frigo)) {
        $errors['frigo'] = "Le frigo est requise.";
    }
    if (empty($status)) {
        $errors['status'] = "Le statut est requis.";
    }
    if (empty($description)) {
        $errors['description'] = "La description est requise.";
    }
    

    if (empty(array_filter($errors))) {
        // Gérer le téléchargement de la photo de couverture
       

        // Vérifier si le fichier est une image réelle
            // Insérer le livre dans la base de données
            $stmt = $pdo->prepare("INSERT INTO chambre (nom, description, prix, status, television, comodite, dimension,ID_Residence,armoir,frigo,cuisine,toilette) VALUES (:nom, :description, :prix, :status, :television, :comodite, :dimension,:ID_Residence,:armoir,:friogo,:cuisine,:toilette)");
            $stmt->execute([
                ':nom' => $nom,
                ':description' => $description,
                ':prix' => $prix,
                ':status' => $status,
                ':television' => $tele,
                ':comodite' => $commo,
                ':dimension' => $dimension,
                ':ID_Residence' => $residence,
                ':armoir' => $armoir,
                ':friogo' => $frigo,
                ':cuisine' => $cuisine,
                ':toilette' => $toilette,
            ]);
            $id = $pdo->lastInsertId();

            $_SESSION["success"] = "Chambre ajouté avec succès!";
            header('Location: ../../../views/admin/forms/formAdd/addImageChambre.php?id=' . $id);
            exit();
        } 
    

    // Stocker les erreurs en session si présentes
    $_SESSION['errors'] = $errors;
    header('Location: ../../../views/admin/forms/formAdd/addChambre.php');
}
