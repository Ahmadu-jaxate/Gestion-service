<?php
include 'connexion.php'; // Connexion à la base de données

$id = $_GET['id'] ?? null;
$message = '';

if ($id) {
    try {
        // Vérifier si l'employé existe et récupérer son service
        $stmt = $pdo->prepare("SELECT numero_service FROM personnel WHERE numero = ?");
        $stmt->execute([$id]);
        $numero_service = $stmt->fetchColumn();

        if ($numero_service) {
            // Décrémenter le nombre d'employés du service
            $stmt = $pdo->prepare("UPDATE service SET nombre_employe = nombre_employe - 1 WHERE numero_service = ?");
            $stmt->execute([$numero_service]);
        }

        // Supprimer l'employé
        $stmt = $pdo->prepare("DELETE FROM personnel WHERE numero = ?");
        $stmt->execute([$id]);

        // Redirection après succès
        header("Location: index.php?message=suppression_ok");
        exit;

    } catch (PDOException $e) {
        $message = "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    $message = "Identifiant d'employé manquant.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression d'employé</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="alert alert-danger text-center">
        <?= htmlspecialchars($message) ?>
    </div>
    <div class="text-center">
        <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</div>

</body>
</html>
