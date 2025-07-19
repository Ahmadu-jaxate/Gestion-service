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
    echo "❌ Échec de la connexion : " . $e->getMessage();
    exit;
}

echo "✅ Connexion réussie à la base de données GestionService.";
