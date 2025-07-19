<?php

include 'connexion.php'; // Inclure le fichier de connexion

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire en POST
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    // $numero_service = (isset($_POST['numero_service']) && $_POST['numero_service'] != 0) ? $_POST['numero_service'] : null;


    if(isset($_POST['numero_service']) && !empty($_POST['numero_service']) && $_POST['numero_service'] != 0) {
        $numero_service = $_POST['numero_service'];
    } else {
        $numero_service = null; // Si le service n'est pas sélectionné, on le met à null
    }
    

    $num_mobile = isset($_POST['num_mobile']) ? $_POST['num_mobile'] : null;
    $date_recrutement = isset($_POST['date_recrutement']) ? $_POST['date_recrutement'] : null;


    if ($id && $nom && $prenom && $email) {

        // Récupérer l'ancien numero_service de l'employé
        $sql_old_service = "SELECT numero_service FROM personnel WHERE numero = ?";
        $stmt_old_service = $pdo->prepare($sql_old_service);
        $stmt_old_service->execute([$id]);
        $ancien_service = $stmt_old_service->fetchColumn();

        // Vérifier si le service a changé
        if ($ancien_service != $numero_service) {
            // Décrémenter le nombre d'employés de l'ancien service (si non null)
            if ($ancien_service) {
            $sql_decrement = "UPDATE service SET nombre_employe = nombre_employe - 1 WHERE numero_service = ?";
            $stmt_decrement = $pdo->prepare($sql_decrement);
            $stmt_decrement->execute([$ancien_service]);
            }
            // Incrémenter le nombre d'employés du nouveau service (si non null)
            if ($numero_service) {
            $sql_increment = "UPDATE service SET nombre_employe = nombre_employe + 1 WHERE numero_service = ?";
            $stmt_increment = $pdo->prepare($sql_increment);
            $stmt_increment->execute([$numero_service]);
            }
        }

        // Préparer la requête de mise à jour
        $sql = "UPDATE personnel SET nom = ?, prenom = ?, email = ?, num_mobile = ?, date_recrutement = ?, numero_service = ? WHERE numero = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $num_mobile, $date_recrutement, $numero_service, $id]);

        echo "Employé modifié avec succès.";


        header("Location: index.php");
        exit;
    } else {
        echo "Tous les champs sont requis.";
    }
    // Ajoutez d'autres champs selon votre formulaire
}
