<?php
// Supposons que $pdo est déjà défini et connecté à la base GestionService

function supprimerEmploye($id, $pdo) {
        try {
        // Démarrer une transaction
        $pdo->beginTransaction();

        // Récupérer le numero_service de l'employé avant suppression
        $sqlService = "SELECT numero_service FROM Personnel WHERE numero = :id";
        $stmtService = $pdo->prepare($sqlService);
        $stmtService->execute([':id' => $id]);
        $employe = $stmtService->fetch(PDO::FETCH_ASSOC);

        if (!$employe) {
            echo " Employé non trouvé.";
            return;
        }

        $numero_service = $employe['numero_service'];

        // Supprimer l'employé
        $sqlDelete = "DELETE FROM Personnel WHERE numero = :id";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->execute([':id' => $id]);

        // Si l'employé avait un service, décrémenter le nombre d'employés
        if (!empty($numero_service)) {
            $sqlUpdate = "UPDATE Service SET nombre_employe = nombre_employe - 1 WHERE numero_service = :num_serv";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([':num_serv' => $numero_service]);
        }

        // Valider la transaction
        $pdo->commit();

        echo " Employé supprimé avec succès. Nombre d'employés du service mis à jour.";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo " Erreur lors de la suppression : " . $e->getMessage();
    }
}




$host = '127.0.0.1';
$dbname = 'GestionService';
$user = 'root';
$password = ''; // Remplace par "MOT_DE_PASSE" si tu en as un
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);

    // Activer le mode d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo " Échec de la connexion : " . $e->getMessage();
    exit;
}
// Exemple d'utilisation : supprimer l'employé avec l'ID 3
supprimerEmploye(4, $pdo);
?>
