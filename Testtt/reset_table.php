<?php
require_once 'config.php';

try {
    $db = getDB();
    
    // Supprimer la table existante
    $db->exec("DROP TABLE IF EXISTS messages");
    
    // Recréer la table avec la nouvelle structure
    $sql = "
        CREATE TABLE messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            mission VARCHAR(100) NOT NULL,
            location VARCHAR(100) NOT NULL,
            available_slot DATE NOT NULL,
            message_date DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_message (mission, location, available_slot)
        )
    ";
    $db->exec($sql);
    
    echo "Table réinitialisée avec succès ! La clé unique est maintenant sur (mission, location, available_slot)";
    
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>