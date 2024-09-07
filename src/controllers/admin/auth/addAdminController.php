<?php
session_start();
require_once '../../../includes/database.php';
require_once '../../../includes/function.php';

// Tableau pour stocker les erreurs de formulaire
$errors = [
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'password' => '',
];


// Traitement du formulaire d'ajout de livre
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = "Le nom de l'administrateur est requise.";
    }
    if (empty($prenom)) {
        $errors['prenom'] = "Le prenoms de l'administrateur est requise.";
    }
    if (empty($email)) {
        $errors['email'] = "L'email est requis.";
    }
    if (empty($password)) {
        $errors['password'] = "La password est requise.";
    }
   
  

    if (empty(array_filter($errors))) {

            $stmt = $pdo->prepare("INSERT INTO admin (nom, prenom, identifiant, password ) VALUES (:nom, :prenom, :email, :password )");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT) ,
                
            ]);

            $_SESSION["success"] = "Admin ajouté avec succès!";
            header('Location: ../../../../admin.php');
            exit();
       
    }

    // Stocker les erreurs en session si présentes
    $_SESSION['errors'] = $errors;
    header('Location: ../../../views/admin/forms/formAdd/addAdmin.php');
}
