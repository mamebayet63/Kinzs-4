<?php
session_start();
require_once '../../../includes/database.php'; // Connexion à la base de données
require_once '../../../includes/function.php'; // Inclure vos fonctions de validation/utilitaires

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_chambre = $_POST['id'];
    $errors = []; // Tableau pour stocker les messages d'erreur

    // Vérifiez si des fichiers ont été uploadés
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $images = $_FILES['images'];
        $upload_directory = '../../../uploads/imgChambre/splide/'; // Remplacez par le chemin correct de votre dossier d'upload

        // Parcourir chaque fichier uploadé
        for ($i = 0; $i < count($images['name']); $i++) {
            $image_name = $images['name'][$i];
            $image_tmp_name = $images['tmp_name'][$i];
            $image_size = $images['size'][$i];
            $image_error = $images['error'][$i];

            if ($image_error === 0 && $image_size > 0) {
                // Générer un nom de fichier unique
                $unique_image_name = uniqid('image_', true) . '.' . pathinfo($image_name, PATHINFO_EXTENSION);

                // Déplacer l'image vers le répertoire de téléchargement
                $destination = $upload_directory . '/' . $unique_image_name;
                if (move_uploaded_file($image_tmp_name, $destination)) {
                    // Enregistrer le chemin de l'image dans la base de données
                    $stmt = $pdo->prepare("INSERT INTO gallerie_chambre (ID_Chambre, url) VALUES (:id_chambre, :url_image)");
                    $stmt->execute([
                        ':id_chambre' => $id_chambre,
                        ':url_image' => $unique_image_name,
                    ]);
                } else {
                    $errors[] = "Erreur lors du déplacement du fichier: $image_name.";
                }
            } else {
                $errors[] = "Erreur lors du téléchargement de l'image: $image_name.";
            }
        }

        if (empty($errors)) {
            $_SESSION['success'] = "Images téléchargées avec succès.";
            header("Location: ../../../views/admin/pages/chambre.php"); // Rediriger vers la page chambre en cas de succès
            exit();
        }
    } else {
        $errors[] = "Veuillez sélectionner au moins une image.";
    }

    // Stocker les erreurs dans la session et rediriger vers le formulaire d'upload
    $_SESSION['errors'] = $errors;
    header("Location: ../../../views/admin/forms/formAdd/addImageChambre.php"); // Rediriger vers le formulaire d'upload en cas d'erreur
    exit();
}
