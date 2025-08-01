<?php
session_start();

// Cable TV providers and their plans
$providers = [
    'gotv' => [
        'name' => 'GOtv',
        'logo' => '../../images/gotv.png',
        'color' => '#FF6B35',
        'plans' => [
            ['name' => 'GOtv Lite', 'price' => '₦1,900', 'validity' => '30 days'],
            ['name' => 'GOtv Value', 'price' => '₦3,600', 'validity' => '30 days'],
            ['name' => 'GOtv Plus', 'price' => '₦5,700', 'validity' => '30 days'],
            ['name' => 'GOtv Max', 'price' => '₦7,600', 'validity' => '30 days'],
            ['name' => 'GOtv Supa', 'price' => '₦12,500', 'validity' => '30 days']
        ]
    ],
    'dstv' => [
        'name' => 'DStv',
        'logo' => '../../images/dstv.png',
        'color' => '#4ECDC4',
        'plans' => [
            ['name' => 'DStv Yanga', 'price' => '₦2,500', 'validity' => '30 days'],
            ['name' => 'DStv Confam', 'price' => '₦6,200', 'validity' => '30 days'],
            ['name' => 'DStv Yanga Extra', 'price' => '₦4,500', 'validity' => '30 days'],
            ['name' => 'DStv Confam Extra', 'price' => '₦8,000', 'validity' => '30 days'],
            ['name' => 'DStv Premium', 'price' => '₦24,500', 'validity' => '30 days']
        ]
    ],
    'startimes' => [
        'name' => 'StarTimes',
        'logo' => '../../images/startime.jpg',
        'color' => '#45B7D1',
        'plans' => [
            ['name' => 'Nova', 'price' => '₦1,300', 'validity' => '30 days'],
            ['name' => 'Basic', 'price' => '₦2,500', 'validity' => '30 days'],
            ['name' => 'Smart', 'price' => '₦3,600', 'validity' => '30 days'],
            ['name' => 'Classic', 'price' => '₦5,400', 'validity' => '30 days'],
            ['name' => 'Super', 'price' => '₦7,200', 'validity' => '30 days']
        ]
    ],
    'showmax' => [
        'name' => 'Showmax',
        'logo' => '../../images/showmax.jpg',
        'color' => '#96CEB4',
        'plans' => [
            ['name' => 'Mobile', 'price' => '₦1,200', 'validity' => '30 days'],
            ['name' => 'Standard', 'price' => '₦3,600', 'validity' => '30 days'],
            ['name' => 'Premium', 'price' => '₦4,400', 'validity' => '30 days']
        ]
    ]
];

// Function to validate smart card number
function validateSmartCard($number) {
    // Remove any spaces or special characters
    $number = preg_replace('/[^0-9]/', '', $number);
    
    // Check if it's between 10-16 digits (typical smart card number range)
    if (strlen($number) >= 10 && strlen($number) <= 16) {
        return $number;
    }
    
    return false;
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    switch ($_POST['action']) {
        case 'verify_smartcard':
            $provider = $_POST['provider'] ?? '';
            $smartcard = $_POST['smartcard'] ?? '';
            
            if (!validateSmartCard($smartcard)) {
                echo json_encode(['success' => false, 'message' => 'Invalid smart card number']);
                exit;
            }
            
            // Simulate smart card verification (in real app, call provider API)
            $customerInfo = [
                'name' => 'John Doe Customer',
                'address' => '123 Sample Street, Lagos',
                'current_plan' => 'None (New Subscription)',
                'due_date' => 'Not subscribed'
            ];
            
            echo json_encode([
                'success' => true, 
                'customer_info' => $customerInfo
            ]);
            exit;
            
        case 'purchase_subscription':
            $provider = $_POST['provider'] ?? '';
            $smartcard = $_POST['smartcard'] ?? '';
            $plan = json_decode($_POST['plan'], true);
            $phone = $_POST['phone'] ?? '';
            
            // Validate inputs
            if (!validateSmartCard($smartcard)) {
                echo json_encode(['success' => false, 'message' => 'Invalid smart card number']);
                exit;
            }
            
            if (!isset($plan['name']) || !isset($plan['price'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid plan selected']);
                exit;
            }
            
            // Generate transaction ID
            $transactionId = 'TV' . time() . rand(1000, 9999);
            
            // Store transaction in session (in real app, store in database)
            if (!isset($_SESSION['tv_history'])) {
                $_SESSION['tv_history'] = [];
            }
            
            $_SESSION['tv_history'][] = [
                'id' => $transactionId,
                'provider' => $provider,
                'smartcard' => $smartcard,
                'plan' => $plan,
                'phone' => $phone,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'successful'
            ];
            
            echo json_encode([
                'success' => true,
                'message' => 'TV subscription successful',
                'transaction_id' => $transactionId
            ]);
            exit;
    }
}

// Get transaction history
function getTransactionHistory() {
    return $_SESSION['tv_history'] ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cable TV Subscription</title>
   <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Top Navigation -->
   <?php include '../../include/user_top_navbar.php';?>

    <!-- Main Container -->
    <div class="container">
        <div id="alert-container"></div>

        <!-- Provider Selection -->
        <div class="section">
            <h2 class="section-title">Select Provider</h2>
            <div class="provider-grid">
                <?php foreach ($providers as $providerKey => $providerData): ?>
                <div class="provider-card" data-provider="<?php echo $providerKey; ?>">
                    <div class="provider-logo">
                        <img src="<?php echo htmlspecialchars($providerData['logo']); ?>" 
                             alt="<?php echo htmlspecialchars($providerData['name']); ?> Logo"
                             onerror="this.style.display='none'; this.parentNode.innerHTML='<?php echo strtoupper(substr($providerData['name'], 0, 2)); ?>';">
                    </div>
                    <div class="provider-name"><?php echo htmlspecialchars($providerData['name']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Smart Card Input -->
        <div class="input-section">
            <fieldset class="input-fieldset">
                <legend class="input-legend">Smart Card Number</legend>
                <input type="text" id="smartcard-input" class="input-field" placeholder="Enter your smart card number" maxlength="16">
            </fieldset>
            <div id="customer-info-container"></div>
        </div>

        <!-- Plans Section -->
        <div class="section" id="plans-section" style="display: none;">
            <h2 class="section-title">Select Plan</h2>
            <div class="plans-grid" id="plans-container">
                <!-- Plans will be loaded here dynamically -->
            </div>
        </div>

        <!-- Phone Number Input -->
        <div class="phone-section">
            <fieldset class="input-fieldset">
                <legend class="input-legend">Phone Number</legend>
                <input type="tel" id="phone-input" class="input-field" placeholder="Enter your phone number" maxlength="11">
            </fieldset>
        </div>

        <!-- Proceed Button -->
        <div class="section">
            <button id="proceed-btn" class="proceed-btn" disabled onclick="purchaseSubscription()">
                Select provider and plan to proceed
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
                                <div><strong><?php echo htmlspecialchars($providers[$transaction['provider']]['name']); ?></strong></div>
                                <div>Plan: <?php echo htmlspecialchars($transaction['plan']['name']); ?></div>
                                <div>Smart Card: <?php echo htmlspecialchars($transaction['smartcard']); ?></div>
                                <div>Phone: <?php echo htmlspecialchars($transaction['phone']); ?></div>
                                <div>Date: <?php echo date('M j, Y - g:i A', strtotime($transaction['date'])); ?></div>
                                <div class="history-amount"><?php echo htmlspecialchars($transaction['plan']['price']); ?></div>
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
        const providers = <?php echo json_encode($providers); ?>;
        let selectedProvider = '';
        let selectedPlan = null;
        let customerInfo = null;

        // DOM Elements
        const smartcardInput = document.getElementById('smartcard-input');
        const phoneInput = document.getElementById('phone-input');
        const proceedBtn = document.getElementById('proceed-btn');
        const alertContainer = document.getElementById('alert-container');
        const customerInfoContainer = document.getElementById('customer-info-container');
        const plansSection = document.getElementById('plans-section');
        const plansContainer = document.getElementById('plans-container');

        // Provider selection
        document.querySelectorAll('.provider-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.provider-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedProvider = this.dataset.provider;
                
                // Show plans section
                plansSection.style.display = 'block';
                loadPlans(selectedProvider);
                
                // Verify smart card if number is already entered
                if (smartcardInput.value.length >= 10) {
                    verifySmartCard(smartcardInput.value);
                }
                
                validateProceedButton();
            });
        });

        // Smart card input validation
        smartcardInput.addEventListener('input', function() {
            let cardNumber = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 16 digits
            if (cardNumber.length > 16) {
                cardNumber = cardNumber.substring(0, 16);
            }
            
            this.value = cardNumber;
            
            // Clear previous customer info
            customerInfo = null;
            customerInfoContainer.innerHTML = '';
            
            // Verify smart card if valid length and provider selected
            if (cardNumber.length >= 10 && selectedProvider) {
                verifySmartCard(cardNumber);
            }
            
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

        // Load plans for selected provider
        function loadPlans(provider) {
            if (!providers[provider] || !providers[provider].plans) {
                plansContainer.innerHTML = '<div style="text-align: center; color: var(--text-secondary); padding: 2rem;">No plans available</div>';
                return;
            }
            
            let plansHTML = '';
            providers[provider].plans.forEach(plan => {
                plansHTML += `
                    <div class="plan-card" data-plan='${JSON.stringify(plan).replace(/'/g, "\\'")}'>
                        <div class="plan-name">${plan.name}</div>
                        <div class="plan-price">${plan.price}</div>
                        <div class="plan-validity">${plan.validity}</div>
                    </div>
                `;
            });
            
            plansContainer.innerHTML = plansHTML;
            
            // Add click event to plan cards
            document.querySelectorAll('.plan-card').forEach(card => {
                card.addEventListener('click', function() {
                    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedPlan = JSON.parse(this.dataset.plan);
                    validateProceedButton();
                });
            });
        }

        // Verify smart card number
        function verifySmartCard(cardNumber) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=verify_smartcard&provider=' + encodeURIComponent(selectedProvider) + 
                      '&smartcard=' + encodeURIComponent(cardNumber)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    customerInfo = data.customer_info;
                    displayCustomerInfo(data.customer_info);
                } else {
                    showAlert(data.message || 'Could not verify smart card', 'error');
                }
            })
            .catch(error => {
                console.error('Error verifying smart card:', error);
            });
        }

        // Display customer information
        function displayCustomerInfo(info) {
            let html = `
                <div class="customer-info">
                    <h4>Customer Information</h4>
                    <p><strong>Name:</strong> ${info.name}</p>
                    <p><strong>Address:</strong> ${info.address}</p>
                    <p><strong>Current Plan:</strong> ${info.current_plan}</p>
                    <p><strong>Due Date:</strong> ${info.due_date}</p>
                </div>
            `;
            customerInfoContainer.innerHTML = html;
        }

        // Validate proceed button state
        function validateProceedButton() {
            const smartcard = smartcardInput.value;
            const phone = phoneInput.value;
            
            if (!selectedProvider || !smartcard || smartcard.length < 10 || 
                !selectedPlan || !phone || phone.length !== 11) {
                proceedBtn.disabled = true;
                proceedBtn.textContent = 'Complete all fields to proceed';
            } else {
                proceedBtn.disabled = false;
                proceedBtn.textContent = `Subscribe to ${selectedPlan.name} for ${selectedPlan.price}`;
            }
        }

        // Purchase subscription function
        function purchaseSubscription() {
            const smartcard = smartcardInput.value;
            const phone = phoneInput.value;
            
            if (!selectedProvider || !smartcard || !selectedPlan || !phone) {
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
                body: 'action=purchase_subscription&provider=' + encodeURIComponent(selectedProvider) + 
                      '&smartcard=' + encodeURIComponent(smartcard) +
                      '&plan=' + encodeURIComponent(JSON.stringify(selectedPlan)) +
                      '&phone=' + encodeURIComponent(phone)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(data.message, data.transaction_id);
                } else {
                    showAlert(data.message || 'Subscription failed', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'error');
            })
            .finally(() => {
                proceedBtn.disabled = false;
                proceedBtn.innerHTML = `Subscribe to ${selectedPlan.name} for ${selectedPlan.price}`;
            });
        }

        // Show success message
        function showSuccess(message, transactionId) {
            let html = `
                <div class="alert alert-success">
                    <h3>${message}</h3>
                    <p>Transaction ID: ${transactionId}</p>
                    <p>Your subscription has been activated successfully.</p>
                </div>
            `;
            
            alertContainer.innerHTML = html;
            
            // Scroll to top to show the success message
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Clear form
            smartcardInput.value = '';
            phoneInput.value = '';
            customerInfoContainer.innerHTML = '';
            customerInfo = null;
            selectedPlan = null;
            
            // Reset selections
            document.querySelectorAll('.provider-card, .plan-card').forEach(card => {
                card.classList.remove('selected');
            });
            selectedProvider = '';
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