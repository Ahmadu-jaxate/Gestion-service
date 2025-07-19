<?php
include 'connexion.php'; // Connexion à la base de données

$message = "";

// Traitement de l'ajout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $num_mobile = $_POST['num_mobile'] ?? '';
    $date_recrutement = $_POST['date_recrutement'] ?? '';
    $numero_service = $_POST['numero_service'] ?? '';
    $adresse = $_POST['adresse'] ?? '';

    if (!empty($nom) && !empty($prenom) && !empty($email)) {
        $stmt = $pdo->prepare("INSERT INTO personnel (nom, prenom, email, num_mobile, date_recrutement, numero_service, adresse) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $nom);
        $stmt->bindParam(2, $prenom);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $num_mobile);
        $stmt->bindParam(5, $date_recrutement);
        $stmt->bindParam(6, $numero_service);
        $stmt->bindParam(7, $adresse);

        if ($stmt->execute()) {
            // Mise à jour du nombre d'employés si un service est sélectionné
            if (!empty($numero_service)) {
                $updateStmt = $pdo->prepare("UPDATE service SET nombre_employe = nombre_employe + 1 WHERE numero_service = ?");
                $updateStmt->bindParam(1, $numero_service);
                $updateStmt->execute();
            }

            header("Location: index.php");
            exit;
        } else {
            $message = "Erreur lors de l'ajout.";
        }
    } else {
        $message = "Veuillez remplir les champs obligatoires.";
    }
}

// Récupération des services
$services = [];
$sqlServices = "SELECT * FROM service";
$stmtServices = $pdo->query($sqlServices);
$services = $stmtServices->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">➕ Ajouter un employé</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($message)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="post" action="" class="row g-3">
                <div class="col-md-6">
                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nom" id="nom" required>
                </div>

                <div class="col-md-6">
                    <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="prenom" id="prenom" required>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>

                <div class="col-md-6">
                    <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="adresse" id="adresse" required>
                </div>

                <div class="col-md-6">
                    <label for="num_mobile" class="form-label">Numéro de mobile</label>
                    <input type="text" class="form-control" name="num_mobile" id="num_mobile">
                </div>

                <div class="col-md-6">
                    <label for="date_recrutement" class="form-label">Date de recrutement</label>
                    <input type="date" class="form-control" name="date_recrutement" id="date_recrutement">
                </div>

                <div class="col-md-6">
                    <label for="numero_service" class="form-label">Service</label>
                    <select name="numero_service" id="numero_service" class="form-select">
                        <option value="">Aucun</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= $service['numero_service'] ?>"><?= htmlspecialchars($service['nom_service']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <a href="index.php" class="btn btn-secondary ms-2">↩️ Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
