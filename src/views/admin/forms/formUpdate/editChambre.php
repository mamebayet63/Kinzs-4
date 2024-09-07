<?php
session_start();
require_once "../../../../includes/database.php";
require_once "../../../../includes/function.php";


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../../auth/connexion.php');
    exit();
}

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$chambreId = $_GET["id"] ?? null;
if (!$chambreId) {
    header('Location: ../../pages/chambre.php');
    exit();
}


$chambre = getChambreWithId($pdo, $chambreId);
if (!$chambre) {
    header('Location: ../../pages/chambre.php');
    exit();
}

$status = getStatus($pdo);
$residences = getResidence($pdo);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Modifier - Chambres</title>
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
                    <a href="../../pages/chambre.php" class="text-decoration-none text-black d-flex gap-1 align-items-center fs-5">
                        <i class="ri-arrow-left-s-line"></i>
                        <span>Retour</span>
                    </a>
                    <p class="m-0 fw-bold position-relative d-none d-sm-block">
                        Modification chambre
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                            <?= $chambre["nom"] ?>
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
                <form action="../../../../controllers/admin/chambre/editChambreController.php" method="post" enctype="multipart/form-data">
                    <div class="col-12">
                        <input type="hidden" value="<?= $chambreId ?>" name="id">
                        <div class="row d-flex justify-content-between">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="nom" class="border-bottom fw-bold">Nom chambre</label>
                                <input type="text" value="<?= $chambre["nom"] ?>" name="nom" class="form-control mt-3 p-3 shadow-sm" placeholder="nom de la chambre" />
                                <?php if (!empty($errors['nom'])) : ?>
                                    <li class="text-danger"><?= $errors['nom'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="nom" class="border-bottom fw-bold">Prix</label>
                                <input type="text" value="<?= $chambre["prix"] ?>" name="prix" class="form-control p-3 shadow-sm mt-3" placeholder="prix de la chambre(FCFA)" />
                                <?php if (!empty($errors['prix'])) : ?>
                                    <li class="text-danger"><?= $errors['prix'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 form-group mt-4">
                                <label for="television" class="border-bottom fw-bold">Television</label>
                                <div class="d-flex gap-2 mt-3">
                                    <label for="oui">Oui</label>
                                    <input type="radio" <?php if ($chambre["television"] == "oui") {
                                                            echo "checked";
                                                        } ?> name="tele" value="oui" class="" />
                                </div>
                                <div class="d-flex gap-2">
                                    <label for="non">Non</label>
                                    <input type="radio" <?php if ($chambre["television"] == "non") {
                                                            echo "checked";
                                                        } ?> name="tele" value="non" class="" />
                                </div>
                                <?php if (!empty($errors['tele'])) : ?>
                                    <li class=" text-danger"><?= $errors['tele'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6 form-group mt-4">
                                <label for="dimension" class="border-bottom fw-bold">Dimension</label>
                                <input type="text" value="<?= $chambre["dimension"] ?>" name="dimension" class="form-control p-3 shadow-sm mt-3" placeholder="dimension de la chambre(m)" />
                                <?php if (!empty($errors['dimension'])) : ?>
                                    <li class="text-danger"><?= $errors['dimension'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between mt-3">
                            <div class="col-12 col-sm-6 form-group mt-4">
                                <label for="residence" class="border-bottom fw-bold">Entrez la residence</label>
                                <select name="residence" id="" class="form-control mt-3 p-3">
                                    <option value="">Sélectionnez une Residence</option>
                                    <?php foreach ($residences as $residence) : ?>
                                        <?php if ($residence["ID_Residence"] == $chambre["ID_Residence"]): ?>
                                            <option selected value="<?= htmlspecialchars($residence['ID_Residence']) ?>"><?= htmlspecialchars($residence['nom']) ?></option>
                                        <?php else: ?>
                                            <option value="<?= htmlspecialchars($residence['ID_Residence']) ?>"><?= htmlspecialchars($residence['nom']) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (!empty($errors['residence'])) : ?>
                                    <li class="text-danger"><?= $errors['residence'] ?></li>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6 form-group mt-4">
                                <label for="television" class="border-bottom fw-bold">Ventiller / Climatiser</label>
                                <div class="d-flex gap-2 mt-3">
                                    <label for="oui">Ventiller</label>
                                    <input type="radio" <?php if ($chambre["comodite"] == "ventiller") {
                                                            echo "checked";
                                                        } ?> name="commo" value="ventiller" class="" />
                                </div>
                                <div class="d-flex gap-2">
                                    <label for="non">Climatiser</label>
                                    <input type="radio" <?php if ($chambre["comodite"] == "climatiser") {
                                                            echo "checked";
                                                        } ?> name="commo" value="climatiser" class="" />
                                </div>
                                <?php if (!empty($errors['tele'])) : ?>
                                    <li class=" text-danger"><?= $errors['tele'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between mt-3">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="residence" class="border-bottom fw-bold">Entrez la status</label>
                                <select name="status" id="" class="form-control mt-3 p-3 shadow-sm">
                                    <option value="">Sélectionnez un status</option>
                                    <?php foreach ($status as $statu) : ?>
                                        <?php if ($statu["id_status"] == $chambre["status"]): ?>
                                            <option selected value="<?= htmlspecialchars($statu['id_status']) ?>"><?= htmlspecialchars($statu['libelle']) ?></option>
                                        <?php else : ?>
                                            <option value="<?= htmlspecialchars($statu['id_status']) ?>"><?= htmlspecialchars($statu['libelle']) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select> <?php if (!empty($errors['status'])) : ?>
                                    <li class="text-danger"><?= $errors['status'] ?></li>
                                <?php endif; ?>
                            </div>
                            
                        
                            <div class="col-12 col-sm-6 form-group">
                                <label for="description" class="border-bottom fw-bold">Description </label>
                                <textarea name="description" placeholder="Description du chambre" class="form-control mt-3 shadow-sm" id="" rows="5"><?= $chambre["description"] ?>
                                </textarea>
                                <?php if (!empty($errors['description'])) : ?>
                                    <li class="text-danger"><?= $errors['description'] ?></li>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between mt-3">
                            <div class="col-12 col-sm-6">
                                <button type="submit" class="btn btn-primary w-100">Publier</button>
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