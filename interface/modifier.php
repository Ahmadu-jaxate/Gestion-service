<?php
include 'connexion.php'; // Connexion à la base de données

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "SELECT * FROM personnel WHERE numero = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $employe = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupération des services
    $sqlServices = "SELECT * FROM service";
    $stmtServices = $pdo->query($sqlServices);
    $services = $stmtServices->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <?php if (isset($employe) && $employe): ?>
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">✏️ Modifier l'employé</h4>
            </div>
            <div class="card-body">
                <form action="traitement_modifier.php" method="POST" class="row g-3">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($employe['numero']) ?>">

                    <div class="col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($employe['nom']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($employe['prenom']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($employe['email']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mobile</label>
                        <input type="text" name="num_mobile" class="form-control" value="<?= htmlspecialchars($employe['num_mobile']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date de recrutement</label>
                        <input type="date" name="date_recrutement" class="form-control" value="<?= htmlspecialchars($employe['date_recrutement']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Service</label>
                        <select name="numero_service" class="form-select">
                            <option value="">Aucun</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['numero_service'] ?>" <?= ($service['numero_service'] == $employe['numero_service']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($service['nom_service']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-success">💾 Enregistrer les modifications</button>
                        <a href="index.php" class="btn btn-secondary ms-2">↩️ Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger text-center">
            Employé non trouvé.
        </div>
        <div class="text-center">
            <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
