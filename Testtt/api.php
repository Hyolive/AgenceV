<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$host = 'localhost';
$dbname = 'telegram_bot';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['mission']) && isset($input['location']) && isset($input['available_slot'])) {
        $mission = trim($input['mission']);
        $location = trim($input['location']);
        $available_slot = $input['available_slot'];
        $message_date = isset($input['message_date']) ? $input['message_date'] : date('Y-m-d H:i:s');
        
        // Convertir la date DD-MM-YYYY en YYYY-MM-DD pour MySQL
        $slot_date = DateTime::createFromFormat('d-m-Y', $available_slot);
        if ($slot_date) {
            $available_slot_mysql = $slot_date->format('Y-m-d');
        } else {
            $available_slot_mysql = date('Y-m-d');
        }
        
        try {
            // Vérifier si le message existe déjà
            $checkStmt = $pdo->prepare("
                SELECT id FROM messages 
                WHERE mission = ? AND location = ? AND available_slot = ? AND message_date = ?
            ");
            $checkStmt->execute([$mission, $location, $available_slot_mysql, $message_date]);
            
            if ($checkStmt->fetch()) {
                echo json_encode(['status' => 'exists', 'message' => 'Message déjà existant']);
            } else {
                // Insérer le nouveau message
                $insertStmt = $pdo->prepare("
                    INSERT INTO messages (mission, location, available_slot, message_date) 
                    VALUES (?, ?, ?, ?)
                ");
                $insertStmt->execute([$mission, $location, $available_slot_mysql, $message_date]);
                
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Message sauvegardé',
                    'id' => $pdo->lastInsertId()
                ]);
            }
        } catch(PDOException $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Données manquantes']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer tous les messages
    try {
        $stmt = $pdo->query("
            SELECT mission, location, available_slot, message_date, created_at 
            FROM messages 
            ORDER BY created_at DESC
        ");
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['messages' => $messages]);
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>