<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agence Voyage - Prise de Rendez-vous</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2d6cdf;
            --secondary: #1e4fab;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
            --travel-blue: #2563eb;
            --travel-green: #059669;
            --travel-gold: #d97706;
            --border-radius: 16px;
            --box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--dark);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
            }
        }

        .header {
            grid-column: 1 / -1;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--travel-blue), var(--travel-green), var(--travel-gold));
        }

        .header h1 {
            color: var(--travel-blue);
            font-size: 2.8rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .header p {
            color: #64748b;
            font-size: 1.2rem;
            font-weight: 400;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            transition: var(--transition);
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(45, 108, 223, 0.1);
        }

        .form-control.error {
            border-color: var(--danger);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--travel-blue), var(--primary));
            color: white;
            box-shadow: 0 4px 15px rgba(45, 108, 223, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(45, 108, 223, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--travel-green), #047857);
            color: white;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            margin-top: 1rem;
        }

        .calendar-header {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            margin-bottom: 1rem;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            color: var(--dark);
            padding: 0.5rem;
            background: #f1f5f9;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            background: white;
            position: relative;
            padding: 0.5rem;
        }

        .calendar-day.disponible {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border-color: var(--travel-green);
            color: #065f46;
            font-weight: 600;
        }

        .calendar-day.complet {
            background: linear-gradient(135deg, #fecaca, #fca5a5);
            border-color: var(--danger);
            color: #dc2626;
            cursor: not-allowed;
        }

        .calendar-day.non-disponible {
            background: #f8fafc;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .calendar-day:hover:not(.complet):not(.non-disponible) {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .day-number {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .day-status {
            font-size: 0.7rem;
            margin-top: 2px;
        }

        .clients-count {
            position: absolute;
            top: 4px;
            right: 4px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background: linear-gradient(135deg, #fecaca, #fca5a5);
            color: #dc2626;
            border: 1px solid #ef4444;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f4f6;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--travel-blue), var(--primary));
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: var(--box-shadow);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .refresh-info {
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .passport-illustration {
            text-align: center;
            margin: 1rem 0;
        }

        .passport-illustration i {
            font-size: 4rem;
            color: var(--travel-gold);
            margin-bottom: 1rem;
        }

        .country-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .selector-card {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .selector-card.active {
            background: linear-gradient(135deg, #dbeafe, #93c5fd);
            border-color: var(--travel-blue);
            color: var(--travel-blue);
            font-weight: 600;
        }

        .selector-card:hover:not(.active) {
            border-color: #cbd5e1;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-passport"></i>
                Agence Voyage - Prise de Rendez-vous
            </h1>
            <p>Simplifiez vos démarches de visa avec notre service de rendez-vous automatique</p>
        </div>

        <!-- Formulaire de rendez-vous -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user-plus"></i> Informations Client</h2>
            </div>
            <div class="card-body">
                <div class="passport-illustration">
                    <i class="fas fa-passport"></i>
                </div>

                <div id="alertMessage"></div>

                <form id="formRendezVous">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="nom">Nom *</label>
                            <input type="text" id="nom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="prenom">Prénom *</label>
                            <input type="text" id="prenom" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="numero_passeport">Numéro de Passeport *</label>
                        <input type="text" id="numero_passeport" class="form-control" maxlength="9" required>
                        <small style="color: #64748b; font-size: 0.8rem;">Maximum 9 caractères</small>
                    </div>

                    <div class="country-selector">
                        <div class="selector-card" data-type="VFS" id="selectorVFS">
                            <i class="fas fa-building"></i>
                            <div>Centre VFS</div>
                        </div>
                        <div class="selector-card" data-type="TLS" id="selectorTLS">
                            <i class="fas fa-landmark"></i>
                            <div>Centre TLS</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="pays">Pays *</label>
                        <select id="pays" class="form-control" required>
                            <option value="">Sélectionnez un pays</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="date_delivrance">Date de Délivrance *</label>
                            <input type="date" id="date_delivrance" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="date_expiration">Date d'Expiration *</label>
                            <input type="date" id="date_expiration" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="lieu_naissance">Lieu de Naissance *</label>
                        <input type="text" id="lieu_naissance" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-calendar-check"></i>
                        Prendre Rendez-vous
                    </button>
                </form>
            </div>
        </div>

        <!-- Calendrier et informations -->
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-calendar-alt"></i> Calendrier des Disponibilités</h2>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number" id="statDisponibles">0</div>
                        <div class="stat-label">Dates Disponibles</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="statComplets">0</div>
                        <div class="stat-label">Dates Complètes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="statTotal">0</div>
                        <div class="stat-label">Total Jours</div>
                    </div>
                </div>

                <div id="calendrierContainer">
                    <div id="calendrierEmpty" class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h3>Aucun calendrier chargé</h3>
                        <p>Sélectionnez un pays pour voir les disponibilités</p>
                    </div>
                    <div class="calendar" id="calendrier" style="display: none;">
                        <!-- Le calendrier sera généré ici par JavaScript -->
                    </div>
                </div>

                <div class="refresh-info">
                    <i class="fas fa-sync-alt"></i>
                    Mise à jour automatique toutes les 10 secondes
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'api_rendezvous.php';
        let currentTypeCentre = 'VFS';
        let currentPays = '';
        let refreshInterval;

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            initializeTypeSelector();
            loadPaysDisponibles('VFS');
            startAutoRefresh();
        });

        // Sélecteur de type de centre
        function initializeTypeSelector() {
            const selectors = document.querySelectorAll('.selector-card');
            selectors.forEach(selector => {
                selector.addEventListener('click', function() {
                    selectors.forEach(s => s.classList.remove('active'));
                    this.classList.add('active');
                    currentTypeCentre = this.dataset.type;
                    loadPaysDisponibles(currentTypeCentre);
                    // Réinitialiser le calendrier
                    currentPays = '';
                    document.getElementById('pays').value = '';
                    resetCalendrier();
                });
            });
            document.getElementById('selectorVFS').classList.add('active');
        }

        // Charger les pays disponibles
        async function loadPaysDisponibles(type) {
            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'get_pays_disponibles',
                        type_centre: type
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    const select = document.getElementById('pays');
                    select.innerHTML = '<option value="">Sélectionnez un pays</option>';
                    
                    result.pays.forEach(pays => {
                        const option = document.createElement('option');
                        option.value = pays;
                        option.textContent = pays;
                        select.appendChild(option);
                    });
                    
                    // Charger le calendrier si un pays est sélectionné
                    select.addEventListener('change', function() {
                        currentPays = this.value;
                        if (currentPays) {
                            loadCalendrier();
                        } else {
                            resetCalendrier();
                        }
                    });
                } else {
                    console.error('Erreur lors du chargement des pays');
                }
            } catch (error) {
                console.error('Erreur chargement pays:', error);
                showAlert('Erreur de connexion lors du chargement des pays', 'error');
            }
        }

        // Charger le calendrier
        async function loadCalendrier() {
            if (!currentPays) return;
            
            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'get_calendrier',
                        type_centre: currentTypeCentre,
                        pays: currentPays
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    afficherCalendrier(result.calendrier);
                    updateStats(result.calendrier);
                } else {
                    showAlert('Aucune disponibilité pour ce pays', 'error');
                    resetCalendrier();
                }
            } catch (error) {
                console.error('Erreur chargement calendrier:', error);
                showAlert('Erreur de connexion lors du chargement du calendrier', 'error');
            }
        }

        // Afficher le calendrier
        function afficherCalendrier(calendrier) {
            const container = document.getElementById('calendrier');
            const emptyState = document.getElementById('calendrierEmpty');
            
            if (calendrier.length === 0) {
                emptyState.style.display = 'block';
                container.style.display = 'none';
                return;
            }
            
            emptyState.style.display = 'none';
            container.style.display = 'grid';
            container.innerHTML = '';
            
            // En-têtes des jours
            const jours = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            jours.forEach(jour => {
                const header = document.createElement('div');
                header.className = 'calendar-day-header';
                header.textContent = jour;
                container.appendChild(header);
            });
            
            // Jours du calendrier
            calendrier.forEach(jour => {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                
                if (jour.complet) {
                    dayElement.classList.add('complet');
                } else if (jour.disponible) {
                    dayElement.classList.add('disponible');
                } else {
                    dayElement.classList.add('non-disponible');
                }
                
                const date = new Date(jour.date);
                const dayNumber = document.createElement('div');
                dayNumber.className = 'day-number';
                dayNumber.textContent = date.getDate();
                
                const dayStatus = document.createElement('div');
                dayStatus.className = 'day-status';
                dayStatus.textContent = jour.complet ? 'Complet' : (jour.disponible ? 'Disponible' : 'Indisponible');
                
                dayElement.appendChild(dayNumber);
                dayElement.appendChild(dayStatus);
                
                if (jour.clients_inscrits > 0) {
                    const count = document.createElement('div');
                    count.className = 'clients-count';
                    count.textContent = jour.clients_inscrits;
                    dayElement.appendChild(count);
                }
                
                container.appendChild(dayElement);
            });
        }

        // Réinitialiser le calendrier
        function resetCalendrier() {
            document.getElementById('calendrierEmpty').style.display = 'block';
            document.getElementById('calendrier').style.display = 'none';
            document.getElementById('statTotal').textContent = '0';
            document.getElementById('statDisponibles').textContent = '0';
            document.getElementById('statComplets').textContent = '0';
        }

        // Mettre à jour les statistiques
        function updateStats(calendrier) {
            const total = calendrier.length;
            const disponibles = calendrier.filter(j => j.disponible).length;
            const complets = calendrier.filter(j => j.complet).length;
            
            document.getElementById('statTotal').textContent = total;
            document.getElementById('statDisponibles').textContent = disponibles;
            document.getElementById('statComplets').textContent = complets;
        }

        // Gestion du formulaire
        document.getElementById('formRendezVous').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!currentPays) {
                showAlert('Veuillez sélectionner un pays', 'error');
                return;
            }
            
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div> Traitement...';
            btn.disabled = true;
            
            try {
                const formData = {
                    action: 'prendre_rendezvous',
                    nom: document.getElementById('nom').value,
                    prenom: document.getElementById('prenom').value,
                    numero_passeport: document.getElementById('numero_passeport').value,
                    type_centre: currentTypeCentre,
                    pays: currentPays,
                    date_expiration: document.getElementById('date_expiration').value,
                    date_delivrance: document.getElementById('date_delivrance').value,
                    lieu_naissance: document.getElementById('lieu_naissance').value
                };
                
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message, 'success');
                    document.getElementById('formRendezVous').reset();
                    loadCalendrier(); // Recharger le calendrier
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                showAlert('Erreur de connexion', 'error');
                console.error('Erreur:', error);
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });

        // Affichage des alertes
        function showAlert(message, type) {
            const container = document.getElementById('alertMessage');
            container.innerHTML = `
                <div class="alert alert-${type}">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                    ${message}
                </div>
            `;
            
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }

        // Rafraîchissement automatique
        function startAutoRefresh() {
            refreshInterval = setInterval(() => {
                if (currentPays) {
                    loadCalendrier();
                }
            }, 10000); // 10 secondes
        }

        // Nettoyage
        window.addEventListener('beforeunload', () => {
            clearInterval(refreshInterval);
        });
    </script>
</body>
</html>