<?php
session_start();

if (!isset($_SESSION['atpay_auth_token_key'])) {
    header("Location: ../Auth/login");
    exit();
}

// API URL for Disco list
$api_url = "https://atpay.ng/List/electricity/";

// Fetch Discos from API
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// Build networks array dynamically

$networks = [];
if ($data && isset($data['Disco'])) {
    foreach ($data['Disco'] as $disco) {
        $id   = strtolower($disco['DiscoId']);
        $name = $disco['DiscoName'];

        $networks[$id] = [
            'name'      => strtoupper($name),
            'full_name' => $name,
            'logo'      => "../../images/" . $id . ".png", // fallback, use your own naming convention
            'color'     => "#45B7D1" // default color (you can assign custom colors if needed)
        ];
    }
}

// ✅ Function to validate meter number
function validateMeterNumber($meter) {
    $meter = preg_replace('/[^0-9]/', '', $meter);
    return (strlen($meter) >= 8 && strlen($meter) <= 13) ? $meter : false;
}

// ✅ Function to validate phone number
function validatePhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phone) == 11 && substr($phone, 0, 1) == '0') return $phone;
    if (strlen($phone) == 10) return '0' . $phone;
    return false;
}

// ✅ Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    switch ($_POST['action']) {
        case 'verify_meter':
            $network     = $_POST['network'] ?? '';
            $meter       = $_POST['meter_number'] ?? '';
            $paymentType = $_POST['payment_type'] ?? '';

            if (!validateMeterNumber($meter)) {
                echo json_encode(['success' => false, 'message' => 'Invalid meter number']);
                exit;
            }

            // Simulated verification (replace with real API call later)
            $customerInfo = [
                'name'                => 'John Doe Customer',
                'address'             => '123 Sample Street, Lagos',
                'meter_type'          => ucfirst($paymentType),
                'outstanding_balance' => $paymentType === 'postpaid' ? rand(1000, 5000) : 0
            ];

            echo json_encode(['success' => true, 'customer_info' => $customerInfo]);
            exit;

        case 'purchase_electricity':
            $network     = $_POST['network'] ?? '';
            $paymentType = $_POST['payment_type'] ?? '';
            $meter       = $_POST['meter_number'] ?? '';
            $amount      = $_POST['amount'] ?? '';
            $phone       = $_POST['phone_number'] ?? '';

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

            $transactionId = 'ELE' . time() . rand(1000, 9999);

            if (!isset($_SESSION['electricity_history'])) {
                $_SESSION['electricity_history'] = [];
            }

            $_SESSION['electricity_history'][] = [
                'id'            => $transactionId,
                'network'       => $network,
                'payment_type'  => $paymentType,
                'meter_number'  => $meter,
                'amount'        => $amount,
                'phone_number'  => $phone,
                'date'          => date('Y-m-d H:i:s'),
                'status'        => 'successful',
                'token'         => $paymentType === 'prepaid' ? rand(1000000000000000, 9999999999999999) : null
            ];

            $response = [
                'success'        => true,
                'message'        => 'Electricity payment successful',
                'transaction_id' => $transactionId
            ];

            if ($paymentType === 'prepaid') {
                $response['token'] = $_SESSION['electricity_history'][count($_SESSION['electricity_history']) - 1]['token'];
            }

            echo json_encode($response);
            exit;
    }
}

// ✅ Get transaction history
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
       <link rel="icon" type="image/png" href="../../images/logo.png">

<link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Top Navigation -->
   <?php include '../../include/user_top_navbar.php';?>

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

    <?php include '../../include/app_settings.php'; ?>
<footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
    <?php echo APP_NAME_FOOTER; ?>
</footer>


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