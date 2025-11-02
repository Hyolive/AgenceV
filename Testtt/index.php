<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telegram Monitor - VFS & TLS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* [GARDEZ TOUT LE CSS BEAU QUE VOUS AVEZ DÉJÀ] */
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --warning: #f72585;
            --info: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --vfs: #4361ee;
            --tls: #f72585;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--dark);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            color: var(--primary);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .header p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            margin: 0;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.3);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .filter-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid var(--primary);
            background: transparent;
            color: var(--primary);
            border-radius: 25px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-btn.active {
            background: var(--primary);
            color: white;
        }

        .filter-btn:hover:not(.active) {
            background: rgba(67, 97, 238, 0.1);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: var(--box-shadow);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        th {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .type-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-vfs-badge {
            background: rgba(67, 97, 238, 0.1);
            color: var(--vfs);
            border: 1px solid var(--vfs);
        }

        .type-tls-badge {
            background: rgba(247, 37, 133, 0.1);
            color: var(--tls);
            border: 1px solid var(--tls);
        }

        .message-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 1rem;
            overflow: hidden;
            border-left: 4px solid var(--primary);
            transition: var(--transition);
        }

        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .message-card.new {
            border-left-color: var(--success);
        }

        .message-card.exists {
            border-left-color: var(--warning);
        }

        .message-header {
            padding: 1rem;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .message-body {
            padding: 1rem;
        }

        .extracted-data {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .data-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .data-label {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.9rem;
        }

        .data-value {
            font-weight: 500;
            color: var(--dark);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-new {
            background: rgba(76, 201, 240, 0.1);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .status-exists {
            background: rgba(247, 37, 133, 0.1);
            color: var(--warning);
            border: 1px solid var(--warning);
        }

        .loading {
            text-align: center;
            padding: 2rem;
            color: var(--primary);
        }

        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .controls {
                grid-template-columns: 1fr;
            }
            
            .data-grid {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 0.9rem;
            }
            
            th, td {
                padding: 0.75rem 0.5rem;
            }
            
            .message-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }

        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-active {
            background: var(--success);
        }

        .status-inactive {
            background: var(--warning);
        }

        .history-controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fab fa-telegram"></i>
                Telegram Monitor
            </h1>
            <p>Surveillance automatique des canaux VFS et TLS</p>
        </div>

        <!-- Controls Card -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-cogs"></i> Contrôles</h2>
            </div>
            <div class="card-body">
                <div class="controls">
                    <button class="btn btn-primary" onclick="startAutoFetch()">
                        <i class="fas fa-play"></i> Démarrer
                    </button>
                    <button class="btn btn-warning" onclick="stopAutoFetch()">
                        <i class="fas fa-stop"></i> Arrêter
                    </button>
                    <button class="btn btn-success" onclick="fetchNow()">
                        <i class="fas fa-sync"></i> Actualiser
                    </button>
                    <button class="btn btn-outline" onclick="loadFromDatabase()">
                        <i class="fas fa-database"></i> Charger depuis MySQL
                    </button>
                    <button class="btn btn-outline" onclick="exportData()">
                        <i class="fas fa-download"></i> Exporter
                    </button>
                </div>
                
                <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <div>
                        <label style="font-weight: 600; margin-right: 0.5rem;">Intervalle:</label>
                        <input type="number" id="interval" value="5" min="1" style="
                            padding: 8px 12px;
                            border: 2px solid #e9ecef;
                            border-radius: 8px;
                            width: 80px;
                            font-weight: 500;
                        "> minutes
                    </div>
                    <div id="status" style="
                        background: #f8f9fa;
                        padding: 8px 16px;
                        border-radius: 20px;
                        font-weight: 500;
                        color: var(--primary);
                        display: flex;
                        align-items: center;
                    ">
                        <span class="status-indicator status-inactive"></span>
                        Prêt à surveiller
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-filter"></i> Filtres</h2>
            </div>
            <div class="card-body">
                <div class="filter-buttons">
                    <button class="filter-btn active" onclick="filterMessages('all')" id="btn-all">
                        <i class="fas fa-layer-group"></i> Tous
                    </button>
                    <button class="filter-btn" onclick="filterMessages('VFS')" id="btn-vfs">
                        <i class="fas fa-passport"></i> VFS
                    </button>
                    <button class="filter-btn" onclick="filterMessages('TLS')" id="btn-tls">
                        <i class="fas fa-file-contract"></i> TLS
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-chart-bar"></i> Statistiques</h2>
            </div>
            <div class="card-body">
                <div class="stats" id="stats">
                    <div class="stat-card">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Messages chargés</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Nouveaux messages</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Total en base</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Card -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-comments"></i> Messages en temps réel</h2>
            </div>
            <div class="card-body">
                <div id="messages">
                    <div class="empty-state">
                        <i class="fas fa-comments"></i>
                        <h3>Aucun message chargé</h3>
                        <p>Les messages apparaîtront ici une fois la surveillance activée</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Summary -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-database"></i> Base de données</h2>
            </div>
            <div class="card-body">
                <div id="summary">
                    <?php
                    require_once 'config.php';
                    try {
                        $db = getDB();
                        $stmt = $db->query("
                            SELECT type, mission, location, available_slot, message_date, created_at 
                            FROM messages 
                            ORDER BY created_at DESC
                        ");
                        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (count($messages) > 0) {
                            echo '<table>';
                            echo '<thead><tr><th>Type</th><th>Mission</th><th>Location</th><th>Date de rendez-vous</th><th>Date du message</th><th>Sauvegardé le</th></tr></thead>';
                            echo '<tbody>';
                            foreach ($messages as $data) {
                                $typeClass = 'type-' . strtolower($data['type']) . '-badge';
                                echo '<tr>';
                                echo '<td><span class="type-badge ' . $typeClass . '">' . htmlspecialchars($data['type']) . '</span></td>';
                                echo '<td><strong>' . htmlspecialchars($data['mission']) . '</strong></td>';
                                echo '<td>' . htmlspecialchars($data['location']) . '</td>';
                                echo '<td>' . date('d/m/Y', strtotime($data['available_slot'])) . '</td>';
                                echo '<td>' . date('d/m/Y H:i', strtotime($data['message_date'])) . '</td>';
                                echo '<td>' . date('d/m/Y H:i', strtotime($data['created_at'])) . '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody></table>';
                        } else {
                            echo '<div class="empty-state">
                                <i class="fas fa-database"></i>
                                <h3>Aucune donnée</h3>
                                <p>La base de données est vide pour le moment</p>
                            </div>';
                        }
                    } catch(PDOException $e) {
                        echo '<div class="empty-state" style="color: var(--warning);">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3>Erreur de base de données</h3>
                            <p>' . htmlspecialchars($e->getMessage()) . '</p>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        const CHANNEL = 'VFSNotificationALG';
        const API_URL = 'api.php';
        let fetchInterval = null;
        let lastMessages = [];
        let allExtractedData = [];

        function updateStatus(message, isActive = false) {
            const statusElement = document.getElementById('status');
            const indicator = statusElement.querySelector('.status-indicator');
            
            indicator.className = 'status-indicator ' + (isActive ? 'status-active' : 'status-inactive');
            statusElement.innerHTML = `<span class="status-indicator ${isActive ? 'status-active' : 'status-inactive'}"></span>${message}`;
        }

        async function saveToDatabase(data) {
            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                return result;
            } catch (error) {
                console.error('Erreur sauvegarde:', error);
                return { error: error.message };
            }
        }

        async function loadFromDatabase(filter = 'all') {
            try {
                const url = filter !== 'all' ? `${API_URL}?type=${filter}` : API_URL;
                const response = await fetch(url);
                const result = await response.json();
                
                if (result.messages) {
                    displayDatabaseMessages(result.messages, filter);
                }
            } catch (error) {
                console.error('Erreur chargement BD:', error);
            }
        }

        function displayDatabaseMessages(messages, filter) {
            const summaryDiv = document.getElementById('summary');
            
            if (messages.length > 0) {
                let summaryHTML = `
                    <h3 style="margin-bottom: 1rem; color: var(--primary);">💾 Données depuis MySQL (${messages.length} messages${filter !== 'all' ? ' - ' + filter : ''})</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Mission</th>
                                <th>Location</th>
                                <th>Date de rendez-vous</th>
                                <th>Date du message</th>
                                <th>Sauvegardé le</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                messages.forEach(data => {
                    const typeClass = 'type-' + data.type.toLowerCase() + '-badge';
                    summaryHTML += `
                        <tr>
                            <td><span class="type-badge ${typeClass}">${data.type}</span></td>
                            <td><strong>${data.mission}</strong></td>
                            <td>${data.location}</td>
                            <td>${new Date(data.available_slot).toLocaleDateString('fr-FR')}</td>
                            <td>${new Date(data.message_date).toLocaleString('fr-FR')}</td>
                            <td>${new Date(data.created_at).toLocaleString('fr-FR')}</td>
                        </tr>
                    `;
                });

                summaryHTML += `
                        </tbody>
                    </table>
                `;

                summaryDiv.innerHTML = summaryHTML;
            } else {
                summaryDiv.innerHTML = `<p>Aucune donnée ${filter !== 'all' ? 'pour ' + filter : ''} dans la base de données.</p>`;
            }
        }

        function filterMessages(type) {
            currentFilter = type;
            
            document.querySelectorAll('.filter-buttons button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById(`btn-${type}`).classList.add('active');
            
            loadFromDatabase(type);
        }

    async function fetchTelegramMessages() {
    updateStatus('Récupération en cours...', true);
    
    try {
        // Utiliser notre proxy PHP
        const telegramUrl = `https://t.me/s/${CHANNEL}`;
        const proxyUrl = `proxy.php?url=${encodeURIComponent(telegramUrl)}`;
        
        console.log('Tentative de récupération via proxy PHP...');
        
        const response = await fetch(proxyUrl);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const html = await response.text();
        console.log('HTML reçu via proxy:', html.length, 'caractères');
        
        // Vérifier si le HTML contient des messages
        if (html.includes('tgme_widget_message') || html.includes('message')) {
            console.log('✅ HTML contient des messages');
            return parseMessagesFromHTML(html);
        } else {
            console.log('❌ HTML ne contient pas de messages');
            console.log('Aperçu HTML:', html.substring(0, 500));
            return [];
        }
        
    } catch (error) {
        console.error('Erreur fetch:', error);
        
        // Méthode de secours : données de test
        console.log('Utilisation des données de test...');
        return getTestMessages();
    }
}

// Fonction de données de test
function getTestMessages() {
    const testMessages = [
        {
            id: 'test_1',
            text: `🚨 VFS ALERT: Austria 🚨

➖➖➖➖➖➖➖➖➖➖➖

🎯 Mission: Austria

📍 Location: Algiers

📋 Visa Type: Business, Family Visit and other

🗓️ AVAILABLE SLOTS FOUND:

• 02-11-2025

Checked at: 31/10/2025 at 11h02m50s UTC`,
            date: new Date().toISOString(),
            views: '150',
            type: 'VFS'
        },
        {
            id: 'test_2', 
            text: `🚨 VFS ALERT: France 🚨

➖➖➖➖➖➖➖➖➖➖➖

🎯 Mission: France

📍 Location: Oran

📋 Visa Type: Tourist

🗓️ AVAILABLE SLOTS FOUND:

• 05-11-2025
• 06-11-2025

Checked at: 01/11/2025 at 09h15m30s UTC`,
            date: new Date(Date.now() - 86400000).toISOString(),
            views: '200',
            type: 'VFS'
        }
    ];
    
    console.log('Données de test chargées:', testMessages.length, 'messages');
    return testMessages;
}
        function parseMessagesFromHTML(html) {
            console.log('Parsing HTML...');
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Sélecteurs plus simples
            const messageElements = doc.querySelectorAll('.tgme_widget_message');
            console.log('Éléments trouvés:', messageElements.length);
            
            const messages = [];
            
            messageElements.forEach((element, index) => {
                try {
                    const textElement = element.querySelector('.tgme_widget_message_text');
                    const dateElement = element.querySelector('.tgme_widget_message_date time');
                    
                    if (textElement) {
                        const text = textElement.textContent.trim();
                        console.log(`Message ${index + 1}:`, text.substring(0, 100) + '...');
                        
                        const message = {
                            id: element.getAttribute('data-post') || `msg_${Date.now()}_${index}`,
                            text: text,
                            html: textElement.innerHTML,
                            date: dateElement ? dateElement.getAttribute('datetime') : new Date().toISOString(),
                            views: '0',
                            timestamp: new Date().getTime()
                        };
                        messages.push(message);
                    }
                } catch (e) {
                    console.warn('Erreur parsing message:', e);
                }
            });
            
            console.log('Messages parsés:', messages.length);
            return messages.reverse();
        }

        function extractInformation(text) {
            const data = {
                type: 'VFS',
                mission: '',
                location: '',
                available_slot: '',
                message_date: new Date().toISOString(),
                rawText: text
            };

            // Détection du type
            if (text.includes('TLS') || text.includes('tls') || text.includes('Tls')) {
                data.type = 'TLS';
            }

            // Extraction mission - plus flexible
            const missionMatch = text.match(/Mission\s*:\s*([^\n\r]+)/i) || 
                               text.match(/🎯\s*([^\n\r]+)/i);
            if (missionMatch) {
                data.mission = missionMatch[1].trim().split(/\s+/)[0];
            }

            // Extraction location - plus flexible
            const locationMatch = text.match(/Location\s*:\s*([^\n\r]+)/i) || 
                                text.match(/📍\s*([^\n\r]+)/i);
            if (locationMatch) {
                data.location = locationMatch[1].trim().split(/\s+/)[0];
            }

            // Extraction date
            const dateMatches = text.match(/\d{2}-\d{2}-\d{4}/g);
            if (dateMatches) {
                data.available_slot = dateMatches[0];
            }

            console.log('Données extraites:', data);
            return data;
        }

        async function displayMessages(messages) {
            const container = document.getElementById('messages');
            const newMessages = messages.filter(msg => 
                !lastMessages.some(lastMsg => lastMsg.id === msg.id)
            );

            console.log('Nouveaux messages à afficher:', newMessages.length);

            if (newMessages.length > 0 && container.querySelector('.empty-state')) {
                container.innerHTML = '';
            }

            let savedCount = 0;

            for (const message of newMessages) {
                const extractedData = extractInformation(message.text);
                
                if (extractedData.mission && extractedData.location && extractedData.available_slot) {
                    // Sauvegarder dans MySQL
                    const saveResult = await saveToDatabase({
                        ...extractedData,
                        message_date: message.date
                    });

                    if (saveResult.status === 'success') {
                        savedCount++;
                    }

                    const dataWithMetadata = {
                        ...extractedData,
                        messageId: message.id,
                        messageDate: message.date,
                        views: message.views
                    };
                    
                    // Éviter les doublons
                    const existingIndex = allExtractedData.findIndex(data => 
                        data.messageId === dataWithMetadata.messageId
                    );
                    
                    if (existingIndex === -1) {
                        allExtractedData.push(dataWithMetadata);
                    }

                    // Créer la carte message
                    const messageCard = document.createElement('div');
                    messageCard.className = `message-card ${saveResult.status === 'success' ? 'new' : 'exists'}`;
                    
                    const statusClass = saveResult.status === 'success' ? 'status-new' : 'status-exists';
                    const statusText = saveResult.status === 'success' ? 'NOUVEAU' : 'DÉJÀ EXISTANT';

                    messageCard.innerHTML = `
                        <div class="message-header">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span class="type-badge type-${extractedData.type.toLowerCase()}-badge">
                                    ${extractedData.type}
                                </span>
                                <span class="status-badge ${statusClass}">
                                    ${statusText}
                                </span>
                            </div>
                            <div style="color: #6c757d; font-size: 0.9rem;">
                                <i class="far fa-clock"></i> ${new Date(message.date).toLocaleString('fr-FR')}
                                ${message.views ? ` • <i class="far fa-eye"></i> ${message.views}` : ''}
                            </div>
                        </div>
                        <div class="message-body">
                            <div class="extracted-data">
                                <div class="data-grid">
                                    <div class="data-item">
                                        <span class="data-label"><i class="fas fa-flag"></i> Mission</span>
                                        <span class="data-value">${extractedData.mission}</span>
                                    </div>
                                    <div class="data-item">
                                        <span class="data-label"><i class="fas fa-map-marker-alt"></i> Location</span>
                                        <span class="data-value">${extractedData.location}</span>
                                    </div>
                                    <div class="data-item">
                                        <span class="data-label"><i class="far fa-calendar-alt"></i> Date de rendez-vous</span>
                                        <span class="data-value">${extractedData.available_slot}</span>
                                    </div>
                                </div>
                            </div>
                            <div style="
                                background: #f8f9fa;
                                padding: 1rem;
                                border-radius: 8px;
                                font-family: monospace;
                                font-size: 0.9rem;
                                white-space: pre-wrap;
                                border-left: 3px solid var(--primary);
                            ">
                                ${message.text}
                            </div>
                        </div>
                    `;
                    
                    container.insertBefore(messageCard, container.firstChild);
                    
                    // Recharger le tableau si nouveau message sauvegardé
                    if (saveResult.status === 'success') {
                        loadFromDatabase(currentFilter);
                    }
                }
            }
            
            updateStats(messages, newMessages, savedCount);
            lastMessages = messages;
            updateStatus(`${messages.length} messages chargés, ${newMessages.length} nouveaux, ${savedCount} sauvegardés`, fetchInterval !== null);
        }

        function updateStats(messages, newMessages, savedCount = 0) {
            const statsHTML = `
                <div class="stat-card">
                    <div class="stat-number">${messages.length}</div>
                    <div class="stat-label">Messages chargés</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${newMessages.length}</div>
                    <div class="stat-label">Nouveaux messages</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${allExtractedData.length}</div>
                    <div class="stat-label">Total en base</div>
                </div>
            `;
            document.getElementById('stats').innerHTML = statsHTML;
        }

        async function fetchNow() {
            const messages = await fetchTelegramMessages();
            await displayMessages(messages);
        }

        function startAutoFetch() {
            const intervalMinutes = parseInt(document.getElementById('interval').value) || 5;
            const intervalMs = intervalMinutes * 60 * 1000;
            
            stopAutoFetch();
            fetchNow();
            fetchInterval = setInterval(fetchNow, intervalMs);
            
            updateStatus(`Surveillance active - vérification toutes les ${intervalMinutes} minutes`, true);
        }

        function stopAutoFetch() {
            if (fetchInterval) {
                clearInterval(fetchInterval);
                fetchInterval = null;
                updateStatus('Surveillance arrêtée', false);
            }
        }

        function exportData() {
            const dataToExport = allExtractedData.filter(data => 
                data.mission && data.location
            );
            
            if (dataToExport.length === 0) {
                alert('Aucune donnée à exporter');
                return;
            }

            const csvContent = [
                ['Type', 'Mission', 'Location', 'Available Slots', 'Message Date'],
                ...dataToExport.map(data => [
                    data.type,
                    data.mission,
                    data.location,
                    data.available_slot,
                    new Date(data.messageDate).toLocaleString('fr-FR')
                ])
            ].map(row => row.map(field => `"${field}"`).join(',')).join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', `telegram_data_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Démarrer automatiquement au chargement
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Démarrage de l\'application...');
            setTimeout(startAutoFetch, 1000);
            // Charger les données existantes au démarrage
            setTimeout(() => loadFromDatabase('all'), 2000);
        });
    </script>
</body>
</html>