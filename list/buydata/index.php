<?php
session_start();

// === AtPay API Config ===
$atpay_api_url = "https://atpay.ng/api/data/";
$token = $_SESSION['atpay_auth_token_key'] ?? 'atpay_auth_token_key'; // replace with session token or your token

// Default network info (for logos and display)
$networks = [
    'mtn' => ['name'=>'MTN','logo'=>'../../images/mtn.png','color'=>'#FFD700'],
    'glo' => ['name'=>'Glo','logo'=>'../../images/glo.jpg','color'=>'#00A651'],
    '9mobile' => ['name'=>'9mobile','logo'=>'../../images/9mobile.jpg','color'=>'#00843D'],
    'airtel' => ['name'=>'Airtel','logo'=>'../../images/airtel.jpg','color'=>'#FF0000']
];


// Helper: Validate phone number
function validatePhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phone) == 11 && substr($phone,0,1)=='0') return $phone;
    if (strlen($phone) == 10) return '0'.$phone;
    return false;
}

// Helper: Detect network from phone
function getNetworkFromPhone($phone) {
    $phone = validatePhoneNumber($phone);
    if (!$phone) return false;
    $prefix = substr($phone,0,4);
    $nets = [
        'mtn'=>['0803','0806','0813','0810','0814','0816','0903','0906','0913','0916'],
        'glo'=>['0805','0807','0811','0815','0905','0915'],
        '9mobile'=>['0809','0817','0818','0908','0909'],
        'airtel'=>['0802','0808','0812','0901','0902','0904','0907','0912']
    ];
    foreach($nets as $net=>$prefixes){
        if(in_array($prefix,$prefixes)) return $net;
    }
    return false;
}

// Fetch available networks
function fetchNetworks($token) {
    $url = "https://atpay.ng/api/networks/";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Token $token",
        "Accept: application/json"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Fetch plans for a specific network
function fetchPlans($token, $networkId) {
    $url = "https://atpay.ng/api/data/plans/$networkId/";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Token $token",
        "Accept: application/json"
    ]);
    $response = curl_exec($ch);

    if ($response === false) {
        return ['error'=>1, 'message'=>'Curl error: ' . curl_error($ch)];
    }

    curl_close($ch);
    return json_decode($response, true);
}


// Purchase data
function purchaseData($token, $networkId, $planId, $phone) {
    $payload = [
    'network_id' => $networkId,
    'plan_id'    => $planId,
    'phone'      => $phone
];

    $ch = curl_init("https://atpay.ng/api/data/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Token $token",
        "Accept: application/json"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get purchase history
function getPurchaseHistory() {
    return $_SESSION['purchases'] ?? [];
}

// Handle AJAX requests
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action'])){
    header('Content-Type: application/json');
    switch($_POST['action']){
        case 'detect_network':
            $phone = $_POST['phone'] ?? '';
            $network = getNetworkFromPhone($phone);
            echo json_encode($network ? ['success'=>true,'network'=>$network] : ['success'=>false,'message'=>'Could not detect network']);
            exit;

            $networkIds = [
            'mtn' => 1,
            'glo' => 2,
            '9mobile' => 3,
            'airtel' => 4
        ];


  case 'get_plans':
   $networkId = $_POST['network'] ?? '';
    $planType  = $_POST['plan_type'] ?? '';

    if (!$networkId) {
        echo json_encode(['success'=>false, 'message'=>'Network ID not provided']);
        exit;
    }

    // Call AtPay endpoint to fetch plans by network
    $plansResponse = fetchPlans($token, $networkId);

    if ($plansResponse && isset($plansResponse['plans']) && count($plansResponse['plans']) > 0) {
        $plans = $plansResponse['plans'];

        // Filter by plan_type if given
        if ($planType) {
            $plans = array_filter($plans, function($p) use ($planType) {
                return strtolower($p['DataType']) === strtolower($planType);
            });
        }

        echo json_encode([
            'success' => true,
            'plans'   => array_values($plans) // reset array indexes
        ]);
    } else {
        echo json_encode(['success'=>false, 'message'=>'No plans available for the selected options']);
    }
    exit;



        case 'purchase_data':
            $phone = $_POST['phone'] ?? '';
            $planId = $_POST['plan_id'] ?? '';
            $networkId = $_POST['network_id'] ?? '';


            if(!validatePhoneNumber($phone)) {
                echo json_encode(['success'=>false,'message'=>'Invalid phone number']); exit;
            }
            if(!$planId || !$networkId){
                echo json_encode(['success'=>false,'message'=>'Plan ID or Network ID missing']); exit;
            }

            $purchase = purchaseData($token,$networkId,$planId,$phone);

            // Save to session purchase history
            if(isset($purchase['success']) && $purchase['success']===true){
                $_SESSION['purchases'][] = [
                    'transaction_id'=>$purchase['transaction_id'] ?? 'TXN'.time(),
                    'phone'=>$phone,
                    'plan_id'=>$planId,
                    'network_id'=>$networkId,
                    'date'=>date('Y-m-d H:i:s'),
                    'status'=>'successful'
                ];
            }

            echo json_encode($purchase);
            exit;
    }
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


          <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>
        
<script>
const networks = <?php echo json_encode($networks); ?>;
let selectedNetwork = '';
let selectedPlanType = '';
let selectedPlan = null;

// Map string → numeric ID for API
const networkIds = {
    mtn: 1,
    glo: 2,
    "9mobile": 3,
    airtel: 4
};

// DOM Elements
const phoneInput = document.getElementById('phone-input');
const purchaseBtn = document.getElementById('purchase-btn');
const alertContainer = document.getElementById('alert-container');
const smeTitle = document.getElementById('sme-title');

// URL of backend PHP (update if filename differs)
const API_URL = "https://atpay.ng/List/data/";

// Network selection
document.querySelectorAll('.network-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.network-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        selectedNetwork = this.dataset.network;

        if (selectedNetwork && networks[selectedNetwork]) {
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

// Phone input validation & network detection
phoneInput.addEventListener('input', function() {
    let phone = this.value.replace(/[^0-9]/g, '');
    if (phone.length > 11) phone = phone.substring(0, 11);
    this.value = phone;

    if (phone.length === 11) detectNetwork(phone);
    validatePurchaseButton();
});

// Detect network from phone number
function detectNetwork(phone) {
    fetch(API_URL, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=detect_network&phone=' + encodeURIComponent(phone)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.network) {
            const network = data.network.toLowerCase();
            const card = document.querySelector(`.network-card[data-network="${network}"]`);
            if (card) card.click(); // auto-select network card
        }
    })
    .catch(err => console.error('Network detection error:', err));
}

// Fetch & display plans
function updatePlansDisplay() {
    const container = document.getElementById('plans-container');

    if (!selectedNetwork || !selectedPlanType) {
        container.innerHTML = '<div class="no-selection">Please select a network and plan type to view available plans</div>';
        selectedPlan = null;
        return;
    }

    const networkId = networkIds[selectedNetwork] || '';

    fetch(API_URL, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=get_plans&network_id=' + encodeURIComponent(networkId) + 
              '&plan_type=' + encodeURIComponent(selectedPlanType)
    })
    .then(res => res.json())
    .then(data => {
        const planList = data.plans || [];

        if (planList.length === 0) {
            container.innerHTML = '<div class="no-selection">No plans available for the selected options</div>';
            selectedPlan = null;
            return;
        }

        let html = '<div class="plans-grid">';
        planList.forEach(plan => {
            html += `
                <div class="plan-card" data-plan='${JSON.stringify(plan).replace(/'/g,"\\'")}'>
                    <div class="plan-header">
                        <span class="plan-name">${plan.PlanName}</span>
                        <div class="plan-size">${plan.DataType.toUpperCase()}</div>
                        <span class="plan-price">₦${plan.User}</span>
                        <span class="plan-validity">${plan.Validity}</span>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        container.innerHTML = html;

        document.querySelectorAll('.plan-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.plan-card').forEach(c => c.style.borderColor = 'var(--border-color)');
                this.style.borderColor = 'var(--primary-color)';
                selectedPlan = JSON.parse(this.dataset.plan);
                validatePurchaseButton();
            });
        });
    })
    .catch(err => {
        console.error('Error fetching plans:', err);
        container.innerHTML = '<div class="no-selection">Error loading plans. Please try again.</div>';
        selectedPlan = null;
    });
}

// Validate purchase button
function validatePurchaseButton() {
    if (!phoneInput.value || phoneInput.value.length !== 11 || !selectedNetwork || !selectedPlanType || !selectedPlan) {
        purchaseBtn.disabled = true;
        purchaseBtn.textContent = 'Select a plan to purchase';
    } else {
        purchaseBtn.disabled = false;
        purchaseBtn.textContent = `Purchase ${selectedPlan.DataType.toUpperCase()} for ₦${selectedPlan.User}`;
    }
}

// Purchase data
function purchaseData() {
    if (!selectedPlan || !phoneInput.value || phoneInput.value.length !== 11) {
        showAlert('Please select a plan and enter a valid phone number', 'error');
        return;
    }

    purchaseBtn.disabled = true;
    purchaseBtn.textContent = 'Processing...';

    fetch(API_URL, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=purchase_data&phone=' + encodeURIComponent(phoneInput.value) +
              '&plan_id=' + encodeURIComponent(selectedPlan.PlanId) +
              '&network_id=' + encodeURIComponent(selectedPlan.NetworkId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showAlert(`Data purchase successful! Transaction ID: ${data.transaction_id}`, 'success');
            selectedPlan = null;
            document.querySelectorAll('.plan-card').forEach(c => c.style.borderColor = 'var(--border-color)');
            validatePurchaseButton();
        } else {
            showAlert(data.message || 'Purchase failed. Please try again.', 'error');
        }
        purchaseBtn.disabled = false;
        validatePurchaseButton();
    })
    .catch(err => {
        console.error('Error purchasing data:', err);
        showAlert('An error occurred. Please try again.', 'error');
        purchaseBtn.disabled = false;
        validatePurchaseButton();
    });
}

// Show alerts
function showAlert(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    alertContainer.appendChild(alert);
    setTimeout(() => alert.remove(), 5000);
}

// Initialize default selection
document.addEventListener('DOMContentLoaded', function() {
    const firstPlanType = document.querySelector('.plan-type-card');
    if (firstPlanType) firstPlanType.click();

    // Bind purchase button
    purchaseBtn.addEventListener('click', purchaseData);
});
</script>



</body>
</html>