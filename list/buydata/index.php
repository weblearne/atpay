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
        'logo' => '../../images/9mobile.jpg', // Path to 9mobile logo
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
<link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Top Navigation -->
 <?php include '../../include/user_top_navbar.php';?>

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