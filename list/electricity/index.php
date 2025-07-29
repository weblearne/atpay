<?php
session_start();

// Nigerian Electricity Distribution Companies
$networks = [
    'kedco' => [
        'name' => 'KEDCO',
        'full_name' => 'Kano Electricity Distribution Company',
        'logo' => '../../images/kedco.png',
        'color' => '#FF6B35'
    ],
    'kaedco' => [
        'name' => 'KAEDCO', 
        'full_name' => 'Kaduna Electric',
        'logo' => '../../images/kaedco.png',
        'color' => '#4ECDC4'
    ],
    'aedc' => [
        'name' => 'AEDC',
        'full_name' => 'Abuja Electricity Distribution Company',
        'logo' => '../../images/aedc.png',
        'color' => '#45B7D1'
    ],
    'ie' => [
        'name' => 'IKEDC',
        'full_name' => 'Ikeja Electric',
        'logo' => '../../images/ie.png',
        'color' => '#96CEB4'
    ],
    'ekedc' => [
        'name' => 'EKEDC',
        'full_name' => 'Eko Electricity Distribution Company',
        'logo' => '../../images/ekedc.png',
        'color' => '#FFEAA7'
    ],
    'ibedc' => [
        'name' => 'IBEDC',
        'full_name' => 'Ibadan Electricity Distribution Company',
        'logo' => '../../images/ibedc.png',
        'color' => '#DDA0DD'
    ],
    'eedc' => [
        'name' => 'EEDC',
        'full_name' => 'Enugu Electricity Distribution Company',
        'logo' => '../../images/eedc.png',
        'color' => '#98D8C8'
    ],
    'phedc' => [
        'name' => 'PHEDC',
        'full_name' => 'Port Harcourt Electricity Distribution Company',
        'logo' => '../../images/phedc.png',
        'color' => '#F7DC6F'
    ],
    'jedc' => [
        'name' => 'JEDC',
        'full_name' => 'Jos Electricity Distribution Company',
        'logo' => '../../images/jedc.png',
        'color' => '#BB8FCE'
    ],
    'yedc' => [
        'name' => 'YEDC',
        'full_name' => 'Yola Electricity Distribution Company',
        'logo' => '../../images/yedc.png',
        'color' => '#85C1E9'
    ],
    'bedc' => [
        'name' => 'BEDC',
        'full_name' => 'Benin Electricity Distribution Company',
        'logo' => '../../images/bedc.png',
        'color' => '#F8C471'
    ]
];

// Function to validate meter number
function validateMeterNumber($meter) {
    // Remove any spaces or special characters
    $meter = preg_replace('/[^0-9]/', '', $meter);
    
    // Check if it's between 8-13 digits (typical meter number range)
    if (strlen($meter) >= 8 && strlen($meter) <= 13) {
        return $meter;
    }
    
    return false;
}

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

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    switch ($_POST['action']) {
        case 'verify_meter':
            $network = $_POST['network'] ?? '';
            $meter = $_POST['meter_number'] ?? '';
            $paymentType = $_POST['payment_type'] ?? '';
            
            if (!validateMeterNumber($meter)) {
                echo json_encode(['success' => false, 'message' => 'Invalid meter number']);
                exit;
            }
            
            // Simulate meter verification (in real app, call DISCO API)
            $customerInfo = [
                'name' => 'John Doe Customer',
                'address' => '123 Sample Street, Lagos',
                'meter_type' => ucfirst($paymentType),
                'outstanding_balance' => $paymentType === 'postpaid' ? rand(1000, 5000) : 0
            ];
            
            echo json_encode([
                'success' => true, 
                'customer_info' => $customerInfo
            ]);
            exit;
            
        case 'purchase_electricity':
            $network = $_POST['network'] ?? '';
            $paymentType = $_POST['payment_type'] ?? '';
            $meter = $_POST['meter_number'] ?? '';
            $amount = $_POST['amount'] ?? '';
            $phone = $_POST['phone_number'] ?? '';
            
            // Validate inputs
            if (!validateMeterNumber($meter)) {
                echo json_encode(['success' => false, 'message' => 'Invalid meter number']);
                exit;
            }
            
            if (!validatePhoneNumber($phone)) {
                echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
                exit;
            }
            
            if (!is_numeric($amount) || $amount < 100) {
                echo json_encode(['success' => false, 'message' => 'Minimum amount is ₦100']);
                exit;
            }
            
            // Generate transaction ID
            $transactionId = 'ELE' . time() . rand(1000, 9999);
            
            // Store transaction in session (in real app, store in database)
            if (!isset($_SESSION['electricity_history'])) {
                $_SESSION['electricity_history'] = [];
            }
            
            $_SESSION['electricity_history'][] = [
                'id' => $transactionId,
                'network' => $network,
                'payment_type' => $paymentType,
                'meter_number' => $meter,
                'amount' => $amount,
                'phone_number' => $phone,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'successful',
                'token' => $paymentType === 'prepaid' ? rand(1000000000000000, 9999999999999999) : null
            ];
            
            $response = [
                'success' => true,
                'message' => 'Electricity payment successful',
                'transaction_id' => $transactionId
            ];
            
            if ($paymentType === 'prepaid') {
                $response['token'] = $_SESSION['electricity_history'][count($_SESSION['electricity_history']) - 1]['token'];
            }
            
            echo json_encode($response);
            exit;
    }
}

// Get transaction history
function getTransactionHistory() {
    return $_SESSION['electricity_history'] ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Payment</title>
    <style>
        :root {
            --primary-color: #4c1d95;
            --secondary-color: #ffffff;
            --accent-color: #6366f1;
            --success-color: #10b981;
            --error-color: #ef4444;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --hover-bg: #f3f4f6;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
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

        /* Payment Type Selection */
        .payment-type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .payment-type-card {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background-color: var(--secondary-color);
        }

        .payment-type-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .payment-type-card.selected {
            border-color: var(--primary-color);
            background-color: #f3f4f6;
        }

        .payment-type-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .payment-type-desc {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Network Selection Dropdown */
        .network-select-container {
            position: relative;
        }

        .network-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            background-color: var(--secondary-color);
            appearance: none;
            padding-right: 2.5rem;
            transition: border-color 0.2s;
        }

        .network-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .network-select-arrow {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--text-secondary);
        }

        /* Input Field Styling */
        .input-section {
            background-color: var(--secondary-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }

        .input-fieldset {
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1rem;
            position: relative;
        }

        .input-legend {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 0 0.5rem;
            background-color: var(--secondary-color);
        }

        .input-field {
            width: 100%;
            border: none;
            outline: none;
            font-size: 1rem;
            padding: 0.5rem 0;
            background-color: transparent;
        }

        .input-field::placeholder {
            color: var(--text-secondary);
        }

        /* Customer Info */
        .customer-info {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .customer-info h4 {
            color: #0ea5e9;
            margin-bottom: 0.5rem;
        }

        .customer-info p {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        /* Proceed Button */
        .proceed-btn {
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

        .proceed-btn:hover {
            background-color: #3730a3;
            transform: translateY(-1px);
        }

        .proceed-btn:disabled {
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

        /* History Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background: var(--secondary-color);
            margin: 5% auto;
            padding: 0;
            width: 90%;
            max-width: 500px;
            border-radius: 1rem;
            max-height: 80vh;
            overflow: hidden;
        }

        .modal-header {
            background: var(--primary-color);
            color: var(--secondary-color);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--secondary-color);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .modal-body {
            padding: 1rem;
            max-height: 60vh;
            overflow-y: auto;
        }

        .history-item {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .history-id {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 0.5rem;
        }

        .history-details {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .history-amount {
            font-weight: 600;
            color: var(--success-color);
            font-size: 1.1rem;
        }

        .token-display {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin-top: 0.5rem;
        }

        .token-display strong {
            color: #92400e;
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

            .payment-type-grid {
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
            .payment-type-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 95%;
                margin: 10% auto;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-left">
            <button class="back-btn" onclick="goBack()">←</button>
            <h1 class="page-title">Electricity</h1>
        </div>
        <button class="history-btn" onclick="showHistory()">History</button>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div id="alert-container"></div>

        <!-- Payment Type Selection -->
        <div class="section">
            <h2 class="section-title">Payment Type</h2>
            <div class="payment-type-grid">
                <div class="payment-type-card" data-payment-type="postpaid">
                    <div class="payment-type-title">Postpaid</div>
                    <div class="payment-type-desc">Pay bills</div>
                </div>
                <div class="payment-type-card" data-payment-type="prepaid">
                    <div class="payment-type-title">Prepaid</div>
                    <div class="payment-type-desc">Buy units</div>
                </div>
            </div>
        </div>

        <!-- Network Selection -->
        <div class="section">
            <h2 class="section-title">Select Network</h2>
            <div class="network-select-container">
                <select class="network-select" id="network-select">
                    <option value="">Select Electricity Network</option>
                    <?php foreach ($networks as $networkKey => $networkData): ?>
                        <option value="<?php echo htmlspecialchars($networkKey); ?>">
                            <?php echo htmlspecialchars($networkData['full_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="network-select-arrow">▼</span>
            </div>
        </div>

        <!-- Meter Number Input -->
        <div class="input-section">
            <fieldset class="input-fieldset">
                <legend class="input-legend">Meter Number</legend>
                <input type="text" id="meter-input" class="input-field" placeholder="Enter your meter number" maxlength="13">
            </fieldset>
            <div id="customer-info-container"></div>
        </div>

        <!-- Amount Input -->
        <div class="input-section">
            <fieldset class="input-fieldset">
                <legend class="input-legend">Amount (₦)</legend>
                <input type="number" id="amount-input" class="input-field" placeholder="Enter amount" min="100" step="1">
            </fieldset>
        </div>

        <!-- Phone Number Input -->
        <div class="input-section">
            <fieldset class="input-fieldset">
                <legend class="input-legend">Phone Number</legend>
                <input type="tel" id="phone-input" class="input-field" placeholder="Enter your phone number" maxlength="11">
            </fieldset>
        </div>

        <!-- Proceed Button -->
        <div class="section">
            <button id="proceed-btn" class="proceed-btn" disabled onclick="purchaseElectricity()">
                Select payment type and network to proceed
            </button>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Transaction History</h2>
                <button class="modal-close" onclick="closeHistory()">&times;</button>
            </div>
            <div class="modal-body">
                <?php 
                $history = getTransactionHistory();
                if (empty($history)): ?>
                    <p style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                        No transactions yet
                    </p>
                <?php else: ?>
                    <?php foreach (array_reverse($history) as $transaction): ?>
                        <div class="history-item">
                            <div class="history-id"><?php echo htmlspecialchars($transaction['id']); ?></div>
                            <div class="history-details">
                                <div><strong><?php echo htmlspecialchars($networks[$transaction['network']]['full_name']); ?></strong></div>
                                <div>Type: <?php echo ucfirst(htmlspecialchars($transaction['payment_type'])); ?></div>
                                <div>Meter: <?php echo htmlspecialchars($transaction['meter_number']); ?></div>
                                <div>Phone: <?php echo htmlspecialchars($transaction['phone_number']); ?></div>
                                <div>Date: <?php echo date('M j, Y - g:i A', strtotime($transaction['date'])); ?></div>
                                <div class="history-amount">₦<?php echo number_format($transaction['amount']); ?></div>
                                <?php if ($transaction['token']): ?>
                                    <div class="token-display">
                                        <strong>Token:</strong> <?php echo $transaction['token']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        const networks = <?php echo json_encode($networks); ?>;
        let selectedPaymentType = '';
        let selectedNetwork = '';
        let customerInfo = null;

        // DOM Elements
        const meterInput = document.getElementById('meter-input');
        const amountInput = document.getElementById('amount-input');
        const phoneInput = document.getElementById('phone-input');
        const proceedBtn = document.getElementById('proceed-btn');
        const alertContainer = document.getElementById('alert-container');
        const customerInfoContainer = document.getElementById('customer-info-container');
        const networkSelect = document.getElementById('network-select');

        // Payment type selection
        document.querySelectorAll('.payment-type-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.payment-type-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedPaymentType = this.dataset.paymentType;
                validateProceedButton();
            });
        });

        // Network selection
        networkSelect.addEventListener('change', function() {
            selectedNetwork = this.value;
            validateProceedButton();
            if (meterInput.value.length >= 8 && selectedNetwork && selectedPaymentType) {
                verifyMeter(meterInput.value);
            }
        });

        // Meter number input validation
        meterInput.addEventListener('input', function() {
            let meter = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 13 digits
            if (meter.length > 13) {
                meter = meter.substring(0, 13);
            }
            
            this.value = meter;
            
            // Clear previous customer info
            customerInfo = null;
            customerInfoContainer.innerHTML = '';
            
            // Verify meter if valid length and network selected
            if (meter.length >= 8 && selectedNetwork && selectedPaymentType) {
                verifyMeter(meter);
            }
            
            validateProceedButton();
        });

        // Amount input validation
        amountInput.addEventListener('input', function() {
            validateProceedButton();
        });

        // Phone input validation
        phoneInput.addEventListener('input', function() {
            let phone = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 11 digits
            if (phone.length > 11) {
                phone = phone.substring(0, 11);
            }
            
            this.value = phone;
            validateProceedButton();
        });

        // Verify meter number
        function verifyMeter(meter) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=verify_meter&network=' + encodeURIComponent(selectedNetwork) + 
                      '&meter_number=' + encodeURIComponent(meter) +
                      '&payment_type=' + encodeURIComponent(selectedPaymentType)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    customerInfo = data.customer_info;
                    displayCustomerInfo(data.customer_info);
                } else {
                    showAlert(data.message || 'Could not verify meter number', 'error');
                }
            })
            .catch(error => {
                console.error('Error verifying meter:', error);
            });
        }

        // Display customer information
        function displayCustomerInfo(info) {
            let html = `
                <div class="customer-info">
                    <h4>Customer Information</h4>
                    <p><strong>Name:</strong> ${info.name}</p>
                    <p><strong>Address:</strong> ${info.address}</p>
                    <p><strong>Meter Type:</strong> ${info.meter_type}</p>
            `;
            
            if (info.outstanding_balance > 0) {
                html += `<p><strong>Outstanding Balance:</strong> ₦${info.outstanding_balance.toLocaleString()}</p>`;
            }
            
            html += '</div>';
            customerInfoContainer.innerHTML = html;
        }

        // Validate proceed button state
        function validateProceedButton() {
            const meter = meterInput.value;
            const amount = parseFloat(amountInput.value);
            const phone = phoneInput.value;
            
            if (!selectedPaymentType || !selectedNetwork || !meter || meter.length < 8 || 
                !amount || amount < 100 || !phone || phone.length !== 11) {
                proceedBtn.disabled = true;
                proceedBtn.textContent = 'Complete all fields to proceed';
            } else {
                proceedBtn.disabled = false;
                proceedBtn.textContent = `Pay ₦${amount.toLocaleString()} for ${selectedPaymentType}`;
            }
        }

        // Purchase electricity function
        function purchaseElectricity() {
            const meter = meterInput.value;
            const amount = parseFloat(amountInput.value);
            const phone = phoneInput.value;
            
            if (!selectedPaymentType || !selectedNetwork || !meter || !amount || !phone) {
                showAlert('Please complete all fields', 'error');
                return;
            }
            
            // Disable button and show loading state
            proceedBtn.disabled = true;
            proceedBtn.innerHTML = '<span class="loading"><span class="spinner"></span> Processing...</span>';
            
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=purchase_electricity&network=' + encodeURIComponent(selectedNetwork) + 
                      '&payment_type=' + encodeURIComponent(selectedPaymentType) +
                      '&meter_number=' + encodeURIComponent(meter) +
                      '&amount=' + encodeURIComponent(amount) +
                      '&phone_number=' + encodeURIComponent(phone)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(data.message, data.transaction_id, data.token);
                } else {
                    showAlert(data.message || 'Payment failed', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'error');
            })
            .finally(() => {
                proceedBtn.disabled = false;
                proceedBtn.innerHTML = 'Pay ₦' + amount.toLocaleString() + ' for ' + selectedPaymentType;
            });
        }

        // Show success message
        function showSuccess(message, transactionId, token) {
            let html = `
                <div class="alert alert-success">
                    <h3>${message}</h3>
                    <p>Transaction ID: ${transactionId}</p>
            `;
            
            if (token) {
                html += `
                    <div class="token-display">
                        <strong>Token:</strong> ${token}
                    </div>
                `;
            }
            
            html += '</div>';
            
            alertContainer.innerHTML = html;
            
            // Scroll to top to show the success message
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Clear form
            meterInput.value = '';
            amountInput.value = '';
            phoneInput.value = '';
            customerInfoContainer.innerHTML = '';
            customerInfo = null;
            
            // Reset selections
            document.querySelectorAll('.payment-type-card').forEach(card => {
                card.classList.remove('selected');
            });
            networkSelect.value = '';
            selectedPaymentType = '';
            selectedNetwork = '';
            validateProceedButton();
        }

        // Show alert message
        function showAlert(message, type = 'error') {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = message;
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alert);
            
            // Scroll to top to show the alert
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        // History modal functions
        function showHistory() {
            document.getElementById('historyModal').style.display = 'block';
        }

        function closeHistory() {
            document.getElementById('historyModal').style.display = 'none';
        }

        // Go back function
        function goBack() {
            window.history.back();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('historyModal');
            if (event.target == modal) {
                closeHistory();
            }
        }
    </script>
</body>
</html>