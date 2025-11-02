<?php
require_once 'config.php';

try {
    $db = getDB();
    
    // Vérifier la structure de la table
    $stmt = $db->query("SHOW CREATE TABLE messages");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Structure de la table :</h3>";
    echo "<pre>" . htmlspecialchars($result['Create Table']) . "</pre>";
    
    // Compter les messages
    $stmt = $db->query("SELECT COUNT(*) as total FROM messages");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Nombre de messages : " . $count['total'] . "</h3>";
    
    // Afficher les messages
    $stmt = $db->query("SELECT * FROM messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($messages) > 0) {
        echo "<h3>Messages dans la base :</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Mission</th><th>Location</th><th>Available Slot</th><th>Message Date</th><th>Created At</th></tr>";
        foreach ($messages as $message) {
            echo "<tr>";
            echo "<td>" . $message['id'] . "</td>";
            echo "<td>" . htmlspecialchars($message['mission']) . "</td>";
            echo "<td>" . htmlspecialchars($message['location']) . "</td>";
            echo "<td>" . $message['available_slot'] . "</td>";
            echo "<td>" . $message['message_date'] . "</td>";
            echo "<td>" . $message['created_at'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun message dans la base de données.</p>";
    }
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>