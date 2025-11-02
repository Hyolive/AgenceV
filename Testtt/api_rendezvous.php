<?php
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        $db = getDB();
        
        switch($input['action']) {
            case 'prendre_rendezvous':
                // Validation des données
                if (!isset($input['nom']) || !isset($input['prenom']) || !isset($input['numero_passeport']) || 
                    !isset($input['type_centre']) || !isset($input['pays']) || !isset($input['date_expiration']) || 
                    !isset($input['date_delivrance']) || !isset($input['lieu_naissance'])) {
                    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
                    exit;
                }
                
                // Validation du numéro de passeport (max 9 caractères)
                if (strlen($input['numero_passeport']) > 9) {
                    echo json_encode(['success' => false, 'message' => 'Numéro de passeport trop long (max 9 caractères)']);
                    exit;
                }
                
                // Vérifier si le passeport existe déjà
                $checkStmt = $db->prepare("SELECT id FROM clients WHERE numero_passeport = ?");
                $checkStmt->execute([$input['numero_passeport']]);
                if ($checkStmt->fetch()) {
                    echo json_encode(['success' => false, 'message' => 'Ce numéro de passeport est déjà enregistré']);
                    exit;
                }
                
                // Trouver une date disponible aléatoire
                $dateRendezVous = trouverDateDisponible($db, $input['type_centre'], $input['pays']);
                
                if (!$dateRendezVous) {
                    echo json_encode(['success' => false, 'message' => 'Aucune date disponible pour ce pays']);
                    exit;
                }
                
                // Insérer le client
                $stmt = $db->prepare("
                    INSERT INTO clients (nom, prenom, numero_passeport, type_centre, pays, date_expiration_passeport, date_delivrance_passeport, lieu_naissance, date_rendez_vous) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                
                $success = $stmt->execute([
                    $input['nom'],
                    $input['prenom'],
                    $input['numero_passeport'],
                    $input['type_centre'],
                    $input['pays'],
                    $input['date_expiration'],
                    $input['date_delivrance'],
                    $input['lieu_naissance'],
                    $dateRendezVous
                ]);
                
                if ($success) {
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Rendez-vous confirmé pour le ' . date('d/m/Y', strtotime($dateRendezVous)),
                        'date_rendez_vous' => $dateRendezVous
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement']);
                }
                break;
                
            case 'get_calendrier':
                $type_centre = $input['type_centre'] ?? 'VFS';
                $pays = $input['pays'] ?? '';
                
                $calendrier = getCalendrier($db, $type_centre, $pays);
                echo json_encode(['success' => true, 'calendrier' => $calendrier]);
                break;
                
            case 'get_pays_disponibles':
                $type_centre = $input['type_centre'] ?? 'VFS';
                $pays = getPaysDisponibles($db, $type_centre);
                echo json_encode(['success' => true, 'pays' => $pays]);
                break;
        }
    }
}

function trouverDateDisponible($db, $type_centre, $pays) {
    // Récupérer la date de début depuis la table messages
    $stmt = $db->prepare("
        SELECT available_slot as date_debut
        FROM messages 
        WHERE type = ? AND mission = ? 
        ORDER BY created_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$type_centre, $pays]);
    $result = $stmt->fetch();
    
    if (!$result || !$result['date_debut']) {
        return null;
    }
    
    $date_debut = new DateTime($result['date_debut']);
    $date_fin = clone $date_debut;
    $date_fin->modify('+10 days');
    
    $dates_disponibles = [];
    
    // Générer toutes les dates entre début et fin
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($date_debut, $interval, $date_fin);
    
    foreach ($period as $dt) {
        $date_str = $dt->format('Y-m-d');
        
        // Compter les rendez-vous déjà pris pour cette date
        $countStmt = $db->prepare("
            SELECT COUNT(*) as count 
            FROM clients 
            WHERE type_centre = ? AND pays = ? AND date_rendez_vous = ?
        ");
        $countStmt->execute([$type_centre, $pays, $date_str]);
        $count = $countStmt->fetch()['count'];
        
        // Maximum 2 rendez-vous par jour
        if ($count < 2) {
            $dates_disponibles[] = $date_str;
        }
    }
    
    if (empty($dates_disponibles)) {
        return null;
    }
    
    // Choisir une date aléatoire
    return $dates_disponibles[array_rand($dates_disponibles)];
}

function getCalendrier($db, $type_centre, $pays) {
    $calendrier = [];
    
    if (!$pays) {
        return $calendrier;
    }
    
    // Récupérer la date de début depuis la table messages
    $stmt = $db->prepare("
        SELECT available_slot as date_debut
        FROM messages 
        WHERE type = ? AND mission = ? 
        ORDER BY created_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$type_centre, $pays]);
    $result = $stmt->fetch();
    
    if (!$result || !$result['date_debut']) {
        return $calendrier;
    }
    
    $date_debut = new DateTime($result['date_debut']);
    $date_fin = clone $date_debut;
    $date_fin->modify('+10 days');
    
    // Générer le calendrier
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($date_debut, $interval, $date_fin);
    
    foreach ($period as $dt) {
        $date_str = $dt->format('Y-m-d');
        $date_formatted = $dt->format('d/m/Y');
        
        // Compter les rendez-vous déjà pris
        $countStmt = $db->prepare("
            SELECT COUNT(*) as count 
            FROM clients 
            WHERE type_centre = ? AND pays = ? AND date_rendez_vous = ?
        ");
        $countStmt->execute([$type_centre, $pays, $date_str]);
        $count = $countStmt->fetch()['count'];
        
        $calendrier[] = [
            'date' => $date_str,
            'date_affichage' => $date_formatted,
            'disponible' => $count < 2,
            'complet' => $count >= 2,
            'clients_inscrits' => $count
        ];
    }
    
    return $calendrier;
}

function getPaysDisponibles($db, $type_centre) {
    $stmt = $db->prepare("
        SELECT DISTINCT mission as pays 
        FROM messages 
        WHERE type = ? AND mission IS NOT NULL AND mission != ''
        ORDER BY mission
    ");
    $stmt->execute([$type_centre]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>