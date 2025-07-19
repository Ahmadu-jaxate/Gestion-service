// connexion a la base de données
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

try {
    // Requête avec jointure entre Personnel et Service
   

    $sql = "
        SELECT 
            s.nom_service,
            p.nom,
            p.prenom,
            p.email,
            p.num_mobile,
            p.date_recrutement
        FROM personnel p
        LEFT JOIN service s ON p.numero_service = s.numero_service
        ORDER BY s.nom_service ASC, p.nom ASC
    ";

    // execution de la requet

    $stmt = $pdo->query($sql);
    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Affichage des employés regroupés par service

    if (count($employes) === 0) {
        echo "Aucun employé trouvé.";
    } else {
        $service_courant = null;

        foreach ($employes as $emp) {
            $nom_service = $emp['nom_service'] ?? "Non attribué";

            // Si on change de service, on ferme l'ancien tableau et on commence un nouveau
            if ($nom_service !== $service_courant) {
                if ($service_courant !== null) {
                    echo "</tbody></table><br>";
                }

                $service_courant = $nom_service;

                // Titre du service
                echo "<h2>Service : " . htmlspecialchars($service_courant) . "</h2>";

                // Début du tableau
                echo "<table border='1' cellpadding='8' cellspacing='0'>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Date de recrutement</th>
                                <th>Service</th>
                            </tr>
                        </thead>
                        <tbody>";
            }

            // on affiche la ligne employé
            echo "<tr>
                    <td>" . htmlspecialchars($emp['nom']) . "</td>
                    <td>" . htmlspecialchars($emp['prenom']) . "</td>
                    <td>" . htmlspecialchars($emp['email']) . "</td>
                    <td>" . htmlspecialchars($emp['num_mobile']) . "</td>
                    <td>" . htmlspecialchars($emp['date_recrutement']) . "</td>
                    <td>" . htmlspecialchars($nom_service) . "</td>
                </tr>";
        }

        // Fermer le dernier tableau html
        echo "</tbody></table>";
    }

} catch (PDOException $e) {
    echo "Erreur lors de l'affichage : " . $e->getMessage();
}





try {
    // Requête pour compter les employés sans service (numero_service NULL)
    $sql = "SELECT COUNT(*) AS total_non_affectes FROM Personnel WHERE numero_service IS NULL";
    
    $stmt = $pdo->query($sql);
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

    $total = $resultat['total_non_affectes'];

    echo "<p>📋 Nombre d’employés non affectés à un service : <strong>$total</strong></p>";

} catch (PDOException $e) {
    echo "<p> Erreur : " . $e->getMessage() . "</p>";
}
?>
