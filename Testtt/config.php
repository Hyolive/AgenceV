<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'telegram_bot');
define('DB_USER', 'root');
define('DB_PASS', '');

// Connexion à la base de données
function getDB() {
    static $db = null;
    
    if ($db === null) {
        try {
            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
    
    return $db;
}

// Créer la table si elle n'existe pas
function createTableIfNotExists() {
    $db = getDB();
    $sql = "
        CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            mission VARCHAR(100) NOT NULL,
            location VARCHAR(100) NOT NULL,
            available_slot DATE NOT NULL,
            message_date DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_message (mission, location, available_slot, message_date)
        )
    ";
    $db->exec($sql);
}

// Appeler la fonction pour créer la table
createTableIfNotExists();
?>