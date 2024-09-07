<?php
session_start();
require_once "../../../../includes/database.php";
require_once "../../../../includes/function.php";


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../auth/connexion.php');
    exit();
}

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$residenceId = $_GET['id'] ?? null;
if (!$residenceId) {
    header('Location: ../pages/residence.php');
    exit();
}

$residence = getResidenceWithId($pdo, $residenceId);


if (!$residence) {
    header('Location: ../pages/residence.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Modification - Residences</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="../../../../../public/css/addChambre.css">
    <link href="
    https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.min.css
    " rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="position-relative">
    <header class="shadow-sm bg-white" style="position: fixed;top:0;width:100%">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center p-2">
                    <a href="../pages/residence.php" class="text-decoration-none text-black d-flex gap-1 align-items-center fs-5">
                        <i class="ri-arrow-left-s-line"></i>
                        <span>Retour</span>
                    </a>
                    <p class="m-0 fw-bold position-relative d-none d-sm-block">
                        Ajouter une nouvelle Residences
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                            nouveau
                        </span>
                    </p>
                    <img src="../../../../../public/images/logo.svg" alt="logo" style="height: 50px;">
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container py-4" style="margin-top: 100px;">
            <div class="row">
                <form action="../../../../controllers/admin/residence/editResidenceController.php" method="post" enctype="multipart/form-data">
                    <div class="col-12">
                        <input type="hidden" value="<?= $residenceId ?>" name="id">
                        <div class="row d-flex justify-content-between">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="nom" class="border-bottom fw-bold">Nom Residences</label>
                                <input type="text" value="<?= $residence["nom"] ?>" name="nom" class="form-control mt-3 p-3 shadow-sm" placeholder="nom de la residence" />
                                <?php if (!empty($errors['nom'])) : ?>
                                    <li class="text-danger"><?= $errors['nom'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="nom" class="border-bottom fw-bold">Adresse</label>
                                <input type="text" value="<?= $residence["adresse"] ?>" name="adresse" class="form-control p-3 shadow-sm mt-3" placeholder="adresse de la residence" />
                                <?php if (!empty($errors['adresse'])) : ?>
                                    <li class="text-danger"><?= $errors['adresse'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 form-group mt-4">
                                <label for="television" class="border-bottom fw-bold">Wifi</label>
                                <div class="d-flex gap-2 mt-3">
                                    <label for="oui">Oui</label>
                                    <input type="radio" <?php if ($residence["wifi"] == "oui") {
                                                            echo "checked";
                                                        } ?> name="wifi" value="oui" class="" />
                                </div>
                                <div class="d-flex gap-2">
                                    <label for="non">Non</label>
                                    <input type="radio" <?php if ($residence["wifi"] == "non") {
                                                            echo "checked";
                                                        } ?> name="wifi" value="non" class="" />
                                </div>
                                <?php if (!empty($errors['wifi'])) : ?>
                                    <li class=" text-danger"><?= $errors['wifi'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6 form-group mt-4">
                                <label for="dimension" class="border-bottom fw-bold">Nombre de chambre</label>
                                <input type="text" value="<?= $residence["nbr_chambre"] ?>" name="nombre" class="form-control p-3 shadow-sm mt-3" placeholder="nombre de chmabre" />
                                <?php if (!empty($errors['nombre'])) : ?>
                                    <li class="text-danger"><?= $errors['nombre'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="image" class="border-bottom fw-bold">Image du residence</label>
                                <input type="file" name="couverture" class="form-control p-3 mt-3 shadow-sm" />
                                <?php if (!empty($residence['couverture'])) : ?>
                                    <img src="../../../../uploads/imgResidence/<?= htmlspecialchars($residence['couverture']) ?>" alt="Cover Image" class="img-thumbnail mt-2" width="100">
                                <?php endif; ?>
                                <?php if (!empty($errors['photo_couverture'])) : ?>
                                    <div class="text-danger"><?= $errors['photo_couverture'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between mt-3">
                            <div class="col-12 form-group">
                                <label for="description" class="border-bottom fw-bold">Description </label>
                                <textarea name="description" class="form-control mt-3 shadow-sm" rows="5"><?= $residence["description"] ?></textarea>
                                <?php if (!empty($errors['description'])) : ?>
                                    <li class="text-danger"><?= $errors['description'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between mt-3">
                            <div class="col-12 col-sm-6">
                                <button type="submit" class="btn btn-primary w-100">Modifier</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php if (!empty($error)) : ?>
        <?= notification("ri-alert-fill", "danger", $error); ?>
    <?php endif; ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>