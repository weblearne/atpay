<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    if ($_POST['action'] === 'get_plans') {
        $networkId = $_POST['network_id'] ?? '';
        if (!$networkId) {
            echo json_encode(['error' => 1, 'message' => 'Network ID required']);
            exit;
        }
        $plans = fetchPlans($token, $networkId);
        echo json_encode(['error' => 0, 'plans' => $plans]);
        exit;
    }
}

// Put your token in session or config
$token = $_SESSION['atpay_auth_token_key'] ?? "7b95e2f16a8405006e9bdeba62bb698087cd7";

// Fetch Networks
function fetchNetworks($token) {
    $url = "https://atpay.ng/api/networks/";
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Token $token",
            "Accept: application/json"
        ]
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die("cURL error: " . curl_error($ch));
    }
    curl_close($ch);
    return json_decode($response, true);
}

// Fetch Plans by NetworkId
function fetchPlans($token, $networkId) {
    $url = "https://atpay.ng/api/data/plans/$networkId/";
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Token $token",
            "Accept: application/json"
        ]
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die("cURL error: " . curl_error($ch));
    }
    curl_close($ch);
    return json_decode($response, true);
}

// Load networks for initial page render
$networks = fetchNetworks($token);
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
    <div class="network-card" data-network="<?php echo $networkData['id']; ?>">
        <div class="network-logo">
            <img src="<?php echo htmlspecialchars($networkData['logo']); ?>" 
                 alt="<?php echo htmlspecialchars($networkData['name']); ?> Logo">
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

// 👉 Point to your PHP file, not AtPay API
const API_URL = "buy_data.php"; 

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

// Phone input validation
phoneInput.addEventListener('input', function() {
    let phone = this.value.replace(/[^0-9]/g, '');
    if (phone.length > 11) phone = phone.substring(0, 11);
    this.value = phone;
    validatePurchaseButton();
});

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
                        <span class="plan-name">${plan.PlanName || plan.name}</span>
                        <div class="plan-size">${plan.DataType ? plan.DataType.toUpperCase() : ''}</div>
                        <span class="plan-price">₦${plan.User || plan.price}</span>
                        <span class="plan-validity">${plan.Validity || ''}</span>
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
        purchaseBtn.textContent = `Purchase ${selectedPlan.DataType?.toUpperCase() || ''} for ₦${selectedPlan.User || selectedPlan.price}`;
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
              '&plan_id=' + encodeURIComponent(selectedPlan.PlanId || selectedPlan.id) +
              '&network_id=' + encodeURIComponent(selectedPlan.NetworkId || selectedPlan.network_id)
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