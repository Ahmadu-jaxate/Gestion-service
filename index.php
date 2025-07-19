<?php
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

echo " Connexion réussie à la base de données GestionService.";

// Données à insérer (exemple)
$nom = "DIOP";
$prenom = "Mourtada";
$adresse = "123 Rue des Services";
$email = "mourtada.diop@example.com";
$num_mobile = "771234567";
$date_recrutement = "2025-06-30";
$numero_service = null; // Assure-toi que ce service existe déjà dans la table Service

try {
    // Requête SQL d’insertion
    $sql = "INSERT INTO Personnel (nom, prenom, adresse, email, num_mobile, date_recrutement, numero_service)
            VALUES (:nom, :prenom, :adresse, :email, :num_mobile, :date_recrutement, :numero_service)";
    
    $stmt = $pdo->prepare($sql);
    
    // Liaison des paramètres
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':num_mobile', $num_mobile);
    $stmt->bindParam(':date_recrutement', $date_recrutement);
    $stmt->bindParam(':numero_service', $numero_service);

    // Exécution
    $stmt->execute();

    echo " Employé ajouté avec succès.";
} catch (PDOException $e) {
    echo " Erreur lors de l'insertion : " . $e->getMessage();
}

?>
