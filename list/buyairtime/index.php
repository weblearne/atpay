   <?php
    // session_start();

    // Network configurations (same as provided in buy data page)
    $networks = [
        'mtn' => [
            'name' => 'MTN',
            'logo' => '../../images/mtn.png',
            'color' => '#FFD700'
        ],
        'glo' => [
            'name' => 'Glo',
            'logo' => '../../images/glo.jpg',
            'color' => '#00A651'
        ],
        '9mobile' => [
            'name' => '9mobile',
            'logo' => '../../images/9mobile.jpg',
            'color' => '#00843D'
        ],
        'airtel' => [
            'name' => 'Airtel',
            'logo' => '../../images/airtel.jpg',
            'color' => '#FF0000'
        ]
    ];

    // Quick amounts
    $quick_amounts = [100, 500, 700, 1000, 1500, 2000];

    // Function to validate phone number (same as buy data page)
    function validatePhoneNumber($phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) == 11 && substr($phone, 0, 1) == '0') {
            return $phone;
        }
        if (strlen($phone) == 10) {
            return '0' . $phone;
        }
        return false;
    }

    // Function to get network from phone number (same as buy data page)
    function getNetworkFromPhone($phone) {
        $phone = validatePhoneNumber($phone);
        if (!$phone) return false;
        
        $prefix = substr($phone, 0, 4);
        
        if (in_array($prefix, ['0803', '0806', '0813', '0810', '0814', '0816', '0903', '0906', '0913', '0916'])) {
            return 'mtn';
        }
        if (in_array($prefix, ['0805', '0807', '0811', '0815', '0905', '0915'])) {
            return 'glo';
        }
        if (in_array($prefix, ['0809', '0817', '0818', '0908', '0909'])) {
            return '9mobile';
        }
        if (in_array($prefix, ['0802', '0808', '0812', '0901', '0902', '0904', '0907', '0912'])) {
            return 'airtel';
        }
        return false;
    }

    // Handle AJAX requests
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        header('Content-Type: application/json');
        
        switch ($_POST['action']) {
            case 'detect_network':
                $phone = $_POST['phone'] ?? '';
                $detectedNetwork = getNetworkFromPhone($phone);
                
                if ($detectedNetwork) {
                    echo json_encode(['success' => true, 'network' => $detectedNetwork]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Could not detect network']);
                }
                exit;
                
            case 'purchase_airtime':
                $phone = $_POST['phone'] ?? '';
                $network = $_POST['network'] ?? '';
                $amount = $_POST['amount'] ?? '';
                
                if (!validatePhoneNumber($phone)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
                    exit;
                }
                
                if (!is_numeric($amount) || $amount < 50) {
                    echo json_encode(['success' => false, 'message' => 'Invalid amount. Minimum is ₦50']);
                    exit;
                }
                
                if (!isset($networks[$network])) {
                    echo json_encode(['success' => false, 'message' => 'Invalid network']);
                    exit;
                }
                
                $purchaseId = 'ATXN' . time() . rand(1000, 9999);
                
                if (!isset($_SESSION['airtime_purchases'])) {
                    $_SESSION['airtime_purchases'] = [];
                }
                
                $_SESSION['airtime_purchases'][] = [
                    'id' => $purchaseId,
                    'phone' => $phone,
                    'network' => $network,
                    'amount' => $amount,
                    'date' => date('Y-m-d H:i:s'),
                    'status' => 'successful'
                ];
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Airtime purchase successful',
                    'transaction_id' => $purchaseId
                ]);
                exit;
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Airtime</title>
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

        <!-- Quick Amount Selection -->
        <div class="section">
            <h2 class="section-title">Quick Amount</h2>
            <div class="quick-amount-grid">
                <?php foreach ($quick_amounts as $amount): ?>
                <div class="amount-card" data-amount="<?php echo $amount; ?>">
                    <div class="amount-value">₦<?php echo number_format($amount); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Amount Input -->
        <div class="amount-input-section">
            <fieldset class="amount-fieldset">
                <legend class="amount-legend">Amount</legend>
                <input type="number" id="amount-input" class="amount-input" placeholder="Enter amount (min ₦50)" min="50">
            </fieldset>
        </div>

        <!-- Pay Button -->
        <div class="section">
            <button id="pay-btn" class="pay-btn" disabled>Pay</button>
        </div>
    </div>


          <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>

        
    <script>
        const networks = <?php echo json_encode($networks); ?>;
        let selectedNetwork = '';
        let selectedAmount = null;

        // DOM Elements
        const phoneInput = document.getElementById('phone-input');
        const amountInput = document.getElementById('amount-input');
        const payBtn = document.getElementById('pay-btn');
        const alertContainer = document.getElementById('alert-container');

        // Network selection
        document.querySelectorAll('.network-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.network-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedNetwork = this.dataset.network;
                validatePayButton();
            });
        });

        // Quick amount selection
        document.querySelectorAll('.amount-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.amount-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedAmount = this.dataset.amount;
                amountInput.value = selectedAmount;
                validatePayButton();
            });
        });

        // Phone input validation and network detection
        phoneInput.addEventListener('input', function() {
            let phone = this.value.replace(/[^0-9]/g, '');
            if (phone.length > 11) {
                phone = phone.substring(0, 11);
            }
            this.value = phone;
            
            if (phone.length === 11) {
                detectNetwork(phone);
            }
            
            validatePayButton();
        });

        // Amount input validation
        amountInput.addEventListener('input', function() {
            selectedAmount = this.value;
            document.querySelectorAll('.amount-card').forEach(c => c.classList.remove('selected'));
            if (quickAmounts.includes(parseInt(this.value))) {
                document.querySelector(`.amount-card[data-amount="${this.value}"]`)?.classList.add('selected');
            }
            validatePayButton();
        });

        const quickAmounts = <?php echo json_encode($quick_amounts); ?>;

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
                    document.querySelectorAll('.network-card').forEach(card => {
                        card.classList.remove('selected');
                        if (card.dataset.network === data.network) {
                            card.classList.add('selected');
                            selectedNetwork = data.network;
                            validatePayButton();
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error detecting network:', error);
            });
        }

        // Validate pay button state
        function validatePayButton() {
            if (!phoneInput.value || phoneInput.value.length !== 11 || !selectedNetwork || !selectedAmount || selectedAmount < 50) {
                payBtn.disabled = true;
                payBtn.textContent = 'Pay';
            } else {
                payBtn.disabled = false;
                payBtn.textContent = `Pay ₦${Number(selectedAmount).toLocaleString()}`;
            }
        }

        // Purchase airtime function
        function purchaseAirtime() {
            if (!selectedNetwork || !phoneInput.value || phoneInput.value.length !== 11 || !selectedAmount || selectedAmount < 50) {
                showAlert('Please select a network, enter a valid phone number, and select an amount', 'error');
                return;
            }

            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="loading"><span class="spinner"></span> Processing...</span>';

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=purchase_airtime&phone=${encodeURIComponent(phoneInput.value)}&network=${encodeURIComponent(selectedNetwork)}&amount=${encodeURIComponent(selectedAmount)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(`Airtime purchase successful! Transaction ID: ${data.transaction_id}`, 'success');
                    phoneInput.value = '';
                    amountInput.value = '';
                    selectedNetwork = '';
                    selectedAmount = null;
                    document.querySelectorAll('.network-card').forEach(c => c.classList.remove('selected'));
                    document.querySelectorAll('.amount-card').forEach(c => c.classList.remove('selected'));
                } else {
                    showAlert(data.message || 'Purchase failed. Please try again.', 'error');
                }
                validatePayButton();
            })
            .catch(error => {
                console.error('Error purchasing airtime:', error);
                showAlert('An error occurred. Please try again.', 'error');
                validatePayButton();
            });
        }

        // Show alert message
        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alertContainer.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            payBtn.addEventListener('click', purchaseAirtime);
        });
    </script>
</body>
</html>