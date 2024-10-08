<?php
session_start();
require_once '../../../../includes/database.php';

// Vérifiez si la clé 'errors' existe dans la session avant de l'utiliser
$errors = isset($_SESSION["errors"]) ? $_SESSION["errors"] : [];
unset($_SESSION["errors"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ajouter Administrateur</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="../../../../../public/css/auth.css">
    <link rel="stylesheet" href="../../../../../public/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="d-flex justify-content-center">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="col-12 col-sm-10 col-lg-6">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-center">
                    <img src="../../../../../public/images/logo.svg" alt="logo" class="logo" style="height: 120px;" />
                </div>
                <div class="mt-4">
                    <p class="m-0 text-center">Entrez les informations de l'administrateur</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="../../../../controllers/admin/auth/addAdminController.php" class="bg-white p-3 shadow rounded mt-3" method="post">
                        <div class="row">
                            <div class="col-12">
                                <input type="email" name="email" class="form-control p-3" placeholder="Email administrateur" />
                                <?php if (!empty($errors["email"])) : ?>
                                    <li class="text-danger"><?= $errors['email'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="nom" name="nom" class="form-control p-3" placeholder="Nom administrateur" />
                                <?php if (!empty($errors["nom"])) : ?>
                                    <li class="text-danger"><?= $errors['nom'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="prenom" name="prenom" class="form-control p-3" placeholder="Prénom administrateur" />
                                <?php if (!empty($errors["prenom"])) : ?>
                                    <li class="text-danger"><?= $errors['prenom'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <input type="password" name="password" class="form-control p-3" placeholder="Mot de passe" />
                                <?php if (!empty($errors["password"])) : ?>
                                    <li class="text-danger"><?= $errors['password'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button class="btn monBag2 text-white w-100">
                                    Créer Admin
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
