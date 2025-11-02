<?php
require_once 'config.php';

$db = getDB();

// Vider les tables
$db->exec("TRUNCATE TABLE disponibilites_pays");

// Ajouter des disponibilités de test basées sur vos données Telegram
$disponibilites = [
    ['VFS', 'Austria', '2025-11-02', '2025-11-12'],
    ['VFS', 'France', '2025-11-05', '2025-11-15'],
    ['TLS', 'Germany', '2025-11-10', '2025-11-20'],
    // Ajoutez d'autres pays selon vos données
];

$stmt = $db->prepare("
    INSERT INTO disponibilites_pays (type_centre, pays, date_debut, date_fin) 
    VALUES (?, ?, ?, ?)
");

foreach ($disponibilites as $dispo) {
    $stmt->execute($dispo);
}

echo "Disponibilités initialisées avec succès!";
?>