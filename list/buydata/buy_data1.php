<?php
session_start();

// Hard-coded data plans for each network
$plans = [
    'mtn' => [
        'sme' => [
            ['name' => 'MTN SME', 'size' => '500MB', 'price' => '₦145', 'validity' => '30 days'],
            ['name' => 'MTN SME', 'size' => '1GB', 'price' => '₦290', 'validity' => '30 days'],
            ['name' => 'MTN SME', 'size' => '2GB', 'price' => '₦580', 'validity' => '30 days'],
            ['name' => 'MTN SME', 'size' => '3GB', 'price' => '₦870', 'validity' => '30 days'],
            ['name' => 'MTN SME', 'size' => '5GB', 'price' => '₦1450', 'validity' => '30 days'],
            ['name' => 'MTN SME', 'size' => '10GB', 'price' => '₦2900', 'validity' => '30 days']
        ],
        'gifting' => [
            ['name' => 'MTN GIFTING', 'size' => '1GB', 'price' => '₦320', 'validity' => '30 days'],
            ['name' => 'MTN GIFTING', 'size' => '2GB', 'price' => '₦640', 'validity' => '30 days'],
            ['name' => 'MTN GIFTING', 'size' => '3GB', 'price' => '₦960', 'validity' => '30 days'],
            ['name' => 'MTN GIFTING', 'size' => '5GB', 'price' => '₦1600', 'validity' => '30 days'],
            ['name' => 'MTN GIFTING', 'size' => '10GB', 'price' => '₦3200', 'validity' => '30 days']
        ]
    ],
    'glo' => [
        'sme' => [
            ['name' => 'GLO SME', 'size' => '500MB', 'price' => '₦125', 'validity' => '14 days'],
            ['name' => 'GLO SME', 'size' => '1GB', 'price' => '₦250', 'validity' => '14 days'],
            ['name' => 'GLO SME', 'size' => '2GB', 'price' => '₦500', 'validity' => '14 days'],
            ['name' => 'GLO SME', 'size' => '3GB', 'price' => '₦750', 'validity' => '14 days'],
            ['name' => 'GLO SME', 'size' => '5GB', 'price' => '₦1250', 'validity' => '14 days']
        ],
        'gifting' => [
            ['name' => 'GLO GIFTING', 'size' => '1GB', 'price' => '₦280', 'validity' => '30 days'],
            ['name' => 'GLO GIFTING', 'size' => '2GB', 'price' => '₦560', 'validity' => '30 days'],
            ['name' => 'GLO GIFTING', 'size' => '3GB', 'price' => '₦840', 'validity' => '30 days'],
            ['name' => 'GLO GIFTING', 'size' => '5GB', 'price' => '₦1400', 'validity' => '30 days']
        ]
    ],
    '9mobile' => [
        'sme' => [
            ['name' => '9MOBILE SME', 'size' => '500MB', 'price' => '₦120', 'validity' => '30 days'],
            ['name' => '9MOBILE SME', 'size' => '1GB', 'price' => '₦240', 'validity' => '30 days'],
            ['name' => '9MOBILE SME', 'size' => '2GB', 'price' => '₦480', 'validity' => '30 days'],
            ['name' => '9MOBILE SME', 'size' => '5GB', 'price' => '₦1200', 'validity' => '30 days']
        ],
        'gifting' => [
            ['name' => '9MOBILE GIFTING', 'size' => '1GB', 'price' => '₦270', 'validity' => '30 days'],
            ['name' => '9MOBILE GIFTING', 'size' => '2GB', 'price' => '₦540', 'validity' => '30 days'],
            ['name' => '9MOBILE GIFTING', 'size' => '3GB', 'price' => '₦810', 'validity' => '30 days']
        ]
    ],
    'airtel' => [
        'sme' => [
            ['name' => 'AIRTEL SME', 'size' => '500MB', 'price' => '₦135', 'validity' => '30 days'],
            ['name' => 'AIRTEL SME', 'size' => '1GB', 'price' => '₦270', 'validity' => '30 days'],
            ['name' => 'AIRTEL SME', 'size' => '2GB', 'price' => '₦540', 'validity' => '30 days'],
            ['name' => 'AIRTEL SME', 'size' => '5GB', 'price' => '₦1350', 'validity' => '30 days']
        ],
        'gifting' => [
            ['name' => 'AIRTEL GIFTING', 'size' => '1GB', 'price' => '₦300', 'validity' => '30 days'],
            ['name' => 'AIRTEL GIFTING', 'size' => '2GB', 'price' => '₦600', 'validity' => '30 days'],
            ['name' => 'AIRTEL GIFTING', 'size' => '5GB', 'price' => '₦1500', 'validity' => '30 days']
        ]
    ]
];

// Network configurations
$networks = [
    'mtn' => [
        'name' => 'MTN',
        'logo' => '../../images/mtn.png', // Path to MTN logo
        'color' => '#FFD700'
    ],
    'glo' => [
        'name' => 'Glo',
        'logo' => '../../images/glo.jpg', // Path to Glo logo
        'color' => '#00A651'
    ],
    '9mobile' => [
        'name' => '9mobile',
        'logo' => '../../images/9mobile.png', // Path to 9mobile logo
        'color' => '#00843D'
    ],
    'airtel' => [
        'name' => 'Airtel',
        'logo' => '../../images/airtel.jpg', // Path to Airtel logo
        'color' => '#FF0000'
    ]
];

// Function to validate phone number
function validatePhoneNumber($phone) {
    // Remove any spaces or special characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // Check if it's 11 digits and starts with 0
    if (strlen($phone) == 11 && substr($phone, 0, 1) == '0') {
        return $phone;
    }
    
    // Check if it's 10 digits (without leading 0)
    if (strlen($phone) == 10) {
        return '0' . $phone;
    }
    
    return false;
}

// Function to get network from phone number
function getNetworkFromPhone($phone) {
    $phone = validatePhoneNumber($phone);
    if (!$phone) return false;
    
    $prefix = substr($phone, 0, 4);
    
    // MTN prefixes
    if (in_array($prefix, ['0803', '0806', '0813', '0810', '0814', '0816', '0903', '0906', '0913', '0916'])) {
        return 'mtn';
    }
    
    // Glo prefixes
    if (in_array($prefix, ['0805', '0807', '0811', '0815', '0905', '0915'])) {
        return 'glo';
    }
    
    // 9mobile prefixes
    if (in_array($prefix, ['0809', '0817', '0818', '0908', '0909'])) {
        return '9mobile';
    }
    
    // Airtel prefixes
    if (in_array($prefix, ['0802', '0808', '0812', '0901', '0902', '0904', '0907', '0912'])) {
        return 'airtel';
    }
    
    return false;
}

// Function to format currency
function formatCurrency($amount) {
    return '₦' . number_format($amount, 0);
}

// Function to get plan type display name
function getPlanTypeDisplayName($network, $planType) {
    if ($planType == 'sme') {
        return strtoupper($network) . ' SME';
    } else {
        return strtoupper($planType);
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    switch ($_POST['action']) {
        case 'get_plans':
            $network = $_POST['network'] ?? '';
            $planType = $_POST['plan_type'] ?? '';
            
            if (isset($plans[$network][$planType])) {
                echo json_encode(['success' => true, 'plans' => $plans[$network][$planType]]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No plans found']);
            }
            exit;
            
        case 'detect_network':
            $phone = $_POST['phone'] ?? '';
            $detectedNetwork = getNetworkFromPhone($phone);
            
            if ($detectedNetwork) {
                echo json_encode(['success' => true, 'network' => $detectedNetwork]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Could not detect network']);
            }
            exit;
            
        case 'purchase_data':
            $phone = $_POST['phone'] ?? '';
            $network = $_POST['network'] ?? '';
            $planType = $_POST['plan_type'] ?? '';
            $planData = json_decode($_POST['plan_data'], true);
            
            // Validate inputs
            if (!validatePhoneNumber($phone)) {
                echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
                exit;
            }
            
            // Here you would integrate with your payment gateway
            // For now, we'll just simulate a successful purchase
            
            $purchaseId = 'TXN' . time() . rand(1000, 9999);
            
            // Store purchase in session (in real app, store in database)
            if (!isset($_SESSION['purchases'])) {
                $_SESSION['purchases'] = [];
            }
            
            $_SESSION['purchases'][] = [
                'id' => $purchaseId,
                'phone' => $phone,
                'network' => $network,
                'plan_type' => $planType,
                'plan_data' => $planData,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'successful'
            ];
            
            echo json_encode([
                'success' => true, 
                'message' => 'Data purchase successful',
                'transaction_id' => $purchaseId
            ]);
            exit;
    }
}

// Get purchase history
function getPurchaseHistory() {
    return $_SESSION['purchases'] ?? [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Data</title>
    <style>
        :root {
            --primary-color: #4c1d95;
            --secondary-color: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --hover-bg: #f3f4f6;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --success-color: #10b981;
            --error-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f9fafb;
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Top Navigation */
        .top-nav {
            background-color: var(--secondary-color);
            padding: 1rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .back-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-primary);
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .back-btn:hover {
            background-color: var(--hover-bg);
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .history-btn {
            background: none;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--text-secondary);
            transition: all 0.2s;
            text-decoration: none;
        }

        .history-btn:hover {
            background-color: var(--hover-bg);
            border-color: var(--primary-color);
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Section Styling */
        .section {
            background-color: var(--secondary-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        /* Network Selection */
        .network-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
        }

        .network-card {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background-color: var(--secondary-color);
        }

        .network-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .network-card.selected {
            border-color: var(--primary-color);
            background-color: #f3f4f6;
        }

        .network-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: var(--hover-bg);
        }

        .network-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .network-name {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* Phone Number Input */
        .phone-section {
            background-color: var(--secondary-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }

        .phone-fieldset {
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1rem;
            position: relative;
        }

        .phone-legend {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 0 0.5rem;
            background-color: var(--secondary-color);
        }

        .phone-input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 1rem;
            padding: 0.5rem 0;
            background-color: transparent;
        }

        .phone-input::placeholder {
            color: var(--text-secondary);
        }

        /* Plan Type Selection */
        .plan-type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .plan-type-card {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background-color: var(--secondary-color);
        }

        .plan-type-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .plan-type-card.selected {
            border-color: var(--primary-color);
            background-color: #f3f4f6;
        }

        .plan-type-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .plan-type-desc {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Data Plans */
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }

        .plan-card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            background-color: var(--secondary-color);
            cursor: pointer;
            transition: all 0.2s;
        }

        .plan-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .plan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .plan-name {
            font-size: 0.75rem;
            color: var(--text-secondary);
            background-color: var(--hover-bg);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }

        .plan-size {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .plan-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .plan-price {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .plan-validity {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .no-selection {
            text-align: center;
            color: var(--text-secondary);
            font-style: italic;
            padding: 2rem;
        }

        /* Purchase Button */
        .purchase-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s;
            width: 100%;
            margin-top: 1rem;
        }

        .purchase-btn:hover {
            background-color: #3730a3;
            transform: translateY(-1px);
        }

        .purchase-btn:disabled {
            background-color: var(--text-secondary);
            cursor: not-allowed;
            transform: none;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        /* Loading State */
        .loading {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0.75rem;
            }

            .section {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .network-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .plans-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .plan-type-grid {
                gap: 0.75rem;
            }

            .top-nav {
                padding: 0.75rem;
            }

            .page-title {
                font-size: 1.125rem;
            }
        }

        @media (max-width: 480px) {
            .network-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .network-card {
                padding: 0.75rem;
            }

            .network-logo {
                width: 50px;
                height: 50px;
            }

            .plan-type-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-left">
            <button class="back-btn" onclick="goBack()">←</button>
            <h1 class="page-title">Buy Data</h1>
        </div>
        <a href="?page=history" class="history-btn">History</a>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div id="alert-container"></div>

        <!-- Network Selection -->
        <div class="section">
            <h2 class="section-title">Select Network</h2>
            <div class="network-grid">
                <?php foreach ($networks as $networkKey => $networkData): ?>
                <div class="network-card" data-network="<?php echo $networkKey; ?>">
                    <div class="network-logo">
                        <img src="<?php echo htmlspecialchars($networkData['logo']); ?>" 
                             alt="<?php echo htmlspecialchars($networkData['name']); ?> Logo"
                             onerror="this.style.display='none'; this.parentNode.innerHTML='<?php echo strtoupper(substr($networkData['name'], 0, 2)); ?>';">
                    </div>
                    <div class="network-name"><?php echo htmlspecialchars($networkData['name']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Phone Number Input -->
        <div class="phone-section">
            <fieldset class="phone-fieldset">
                <legend class="phone-legend">Phone Number</legend>
                <input type="tel" id="phone-input" class="phone-input" placeholder="Enter phone number" maxlength="11">
            </fieldset>
        </div>

        <!-- Plan Type Selection -->
        <div class="section">
            <h2 class="section-title">Plan Type</h2>
            <div class="plan-type-grid">
                <div class="plan-type-card" data-plan-type="sme">
                    <div class="plan-type-title" id="sme-title">SME</div>
                    <div class="plan-type-desc">Share and earn</div>
                </div>
                <div class="plan-type-card" data-plan-type="gifting">
                    <div class="plan-type-title">GIFTING</div>
                    <div class="plan-type-desc">Direct gifting</div>
                </div>
            </div>
        </div>

        <!-- Data Plans -->
        <div class="section">
            <h2 class="section-title">Available Plans</h2>
            <div id="plans-container">
                <div class="no-selection">Please select a network and plan type to view available plans</div>
            </div>
            <button id="purchase-btn" class="purchase-btn" disabled onclick="purchaseData()">
                Select a plan to purchase
            </button>
        </div>
    </div>

    <script>
        const dataPlans = <?php echo json_encode($plans); ?>;
        const networks = <?php echo json_encode($networks); ?>;
        let selectedNetwork = '';
        let selectedPlanType = '';
        let selectedPlan = null;

        // DOM Elements
        const phoneInput = document.getElementById('phone-input');
        const purchaseBtn = document.getElementById('purchase-btn');
        const alertContainer = document.getElementById('alert-container');
        const smeTitle = document.getElementById('sme-title');

        // Network selection
        document.querySelectorAll('.network-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.network-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedNetwork = this.dataset.network;
                
                // Update SME title based on selected network
                if (selectedNetwork) {
                    smeTitle.textContent = networks[selectedNetwork].name.toUpperCase() + ' SME';
                }
                
                updatePlansDisplay();
                validatePurchaseButton();
            });
        });

        // Plan type selection
        document.querySelectorAll('.plan-type-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.plan-type-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedPlanType = this.dataset.planType;
                updatePlansDisplay();
                validatePurchaseButton();
            });
        });

        // Phone input validation and network detection
        phoneInput.addEventListener('input', function() {
            let phone = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 11 digits
            if (phone.length > 11) {
                phone = phone.substring(0, 11);
            }
            
            this.value = phone;
            
            // Auto-detect network if phone number is complete
            if (phone.length === 11) {
                detectNetwork(phone);
            }
            
            validatePurchaseButton();
        });

        // Detect network from phone number
        function detectNetwork(phone) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=detect_network&phone=' + encodeURIComponent(phone)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Auto-select the detected network
                    document.querySelectorAll('.network-card').forEach(card => {
                        card.classList.remove('selected');
                        if (card.dataset.network === data.network) {
                            card.classList.add('selected');
                            selectedNetwork = data.network;
                            
                            // Update SME title
                            smeTitle.textContent = networks[selectedNetwork].name.toUpperCase() + ' SME';
                            
                            updatePlansDisplay();
                            validatePurchaseButton();
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error detecting network:', error);
            });
        }

        // Update plans display
        function updatePlansDisplay() {
            const container = document.getElementById('plans-container');
            
            if (!selectedNetwork || !selectedPlanType) {
                container.innerHTML = '<div class="no-selection">Please select a network and plan type to view available plans</div>';
                selectedPlan = null;
                return;
            }

            // Get plans via AJAX
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',                },
                body: 'action=get_plans&network=' + encodeURIComponent(selectedNetwork) + 
                      '&plan_type=' + encodeURIComponent(selectedPlanType)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.plans.length > 0) {
                    let plansHTML = '<div class="plans-grid">';
                    
                    data.plans.forEach(plan => {
                        plansHTML += `
                            <div class="plan-card" data-plan='${JSON.stringify(plan).replace(/'/g, "\\'")}'>
                                <div class="plan-header">
                                    <span class="plan-name">${plan.name}</span>
                                </div>
                                <div class="plan-size">${plan.size}</div>
                                <div class="plan-details">
                                    <span class="plan-price">${plan.price}</span>
                                    <span class="plan-validity">${plan.validity}</span>
                                </div>
                            </div>
                        `;
                    });
                    
                    plansHTML += '</div>';
                    container.innerHTML = plansHTML;
                    
                    // Add click event to plan cards
                    document.querySelectorAll('.plan-card').forEach(card => {
                        card.addEventListener('click', function() {
                            document.querySelectorAll('.plan-card').forEach(c => {
                                c.style.borderColor = 'var(--border-color)';
                            });
                            this.style.borderColor = 'var(--primary-color)';
                            selectedPlan = JSON.parse(this.dataset.plan);
                            validatePurchaseButton();
                        });
                    });
                } else {
                    container.innerHTML = '<div class="no-selection">No plans available for the selected options</div>';
                    selectedPlan = null;
                }
            })
            .catch(error => {
                console.error('Error fetching plans:', error);
                container.innerHTML = '<div class="no-selection">Error loading plans. Please try again.</div>';
                selectedPlan = null;
            });
        }

        // Validate purchase button state
        function validatePurchaseButton() {
            if (!phoneInput.value || phoneInput.value.length !== 11 || !selectedNetwork || !selectedPlanType || !selectedPlan) {
                purchaseBtn.disabled = true;
                purchaseBtn.textContent = 'Select a plan to purchase';
            } else {
                purchaseBtn.disabled = false;
                purchaseBtn.textContent = `Purchase ${selectedPlan.size} for ${selectedPlan.price}`;
            }
        }

        // Purchase data function
        function purchaseData() {
            if (!selectedPlan || !phoneInput.value || phoneInput.value.length !== 11) {
                showAlert('Please select a plan and enter a valid phone number', 'error');
                return;
            }

            purchaseBtn.disabled = true;
            purchaseBtn.innerHTML = '<span class="loading"><span class="spinner"></span> Processing...</span>';

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=purchase_data&phone=' + encodeURIComponent(phoneInput.value) + 
                      '&network=' + encodeURIComponent(selectedNetwork) + 
                      '&plan_type=' + encodeURIComponent(selectedPlanType) + 
                      '&plan_data=' + encodeURIComponent(JSON.stringify(selectedPlan))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(`Data purchase successful! Transaction ID: ${data.transaction_id}`, 'success');
                    // Reset selections
                    selectedPlan = null;
                    document.querySelectorAll('.plan-card').forEach(c => {
                        c.style.borderColor = 'var(--border-color)';
                    });
                    validatePurchaseButton();
                } else {
                    showAlert(data.message || 'Purchase failed. Please try again.', 'error');
                }
                purchaseBtn.disabled = false;
                purchaseBtn.textContent = `Purchase ${selectedPlan.size} for ${selectedPlan.price}`;
            })
            .catch(error => {
                console.error('Error purchasing data:', error);
                showAlert('An error occurred. Please try again.', 'error');
                purchaseBtn.disabled = false;
                purchaseBtn.textContent = `Purchase ${selectedPlan.size} for ${selectedPlan.price}`;
            });
        }

        // Show alert message
        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alertContainer.appendChild(alert);
            
            // Remove alert after 5 seconds
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        // Go back function
        function goBack() {
            window.history.back();
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-select first network and plan type for demo purposes
            // In production, you might want to remove this
            const firstNetworkCard = document.querySelector('.network-card');
            if (firstNetworkCard) {
                firstNetworkCard.click();
            }
            
            const firstPlanTypeCard = document.querySelector('.plan-type-card');
            if (firstPlanTypeCard) {
                firstPlanTypeCard.click();
            }
        });
    </script>
</body>
</html>