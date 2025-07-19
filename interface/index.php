<?php
include 'connexion.php';

// Gestion de la recherche
$search = '';

// Vérifier si une recherche est demandée
if (isset($_GET['recherche']) && !empty(trim($_GET['recherche']))) {
    $search = trim($_GET['recherche']);
    // Préparer la requête pour rechercher par nom ou prénom
    $sql = "
        SELECT p.*, s.nom_service 
        FROM personnel p
        LEFT JOIN service s ON p.numero_service = s.numero_service
        WHERE p.nom LIKE :search OR p.prenom LIKE :search
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
    $result = $stmt;
} else {
    
    // Si pas de recherche, récupérer tous les employés
    $sql = "
        SELECT p.*, s.nom_service 
        FROM personnel p
        LEFT JOIN service s ON p.numero_service = s.numero_service
    ";
    $result = $pdo->query($sql);
}

// Récupérer les employés sans service
$sqlNonAffectes = "
    SELECT p.* 
    FROM personnel p
    WHERE p.numero_service IS NULL
";
$stmtNonAffectes = $pdo->query($sqlNonAffectes);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des employés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

    <h1 class="text-center mb-4">📋 Interface de gestion des employés</h1>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="add.php" class="btn btn-success">➕ Ajouter un employé</a>
        <form method="get" class="d-flex" role="search">
            <input class="form-control me-2" type="text" name="recherche" placeholder="Rechercher nom ou prénom" value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </form>
    </div>

    <?php if ($result->rowCount() > 0): ?>
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">👨‍💼 Liste des employés</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date recrutement</th>
                            <th>Service</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $row['numero'] ?></td>
                                <td><?= htmlspecialchars($row['nom']) ?></td>
                                <td><?= htmlspecialchars($row['prenom']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['num_mobile']) ?></td>
                                <td><?= $row['date_recrutement'] ?></td>
                                <td><?= $row['nom_service'] ?? '' ?></td>
                                <td>
                                    <a href="modifier.php?id=<?= $row['numero'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <a href="supprimer.php?id=<?= $row['numero'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">Aucun employé trouvé.</div>
    <?php endif; ?>

    <!-- Section employés sans service -->
    <div class="card shadow mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">🚫 Employés sans service</h5>
        </div>
        <div class="card-body">
            <p><strong>Nombre :</strong> <?= $stmtNonAffectes->rowCount() ?></p>

            <?php if ($stmtNonAffectes->rowCount() > 0): ?>
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date recrutement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmtNonAffectes->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?= $row['numero'] ?></td>
                                <td><?= htmlspecialchars($row['nom']) ?></td>
                                <td><?= htmlspecialchars($row['prenom']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['num_mobile']) ?></td>
                                <td><?= $row['date_recrutement'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">Aucun employé sans service.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Inclusion des stats -->
    <?php include 'stats.php'; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
