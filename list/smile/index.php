 <?php
    session_start();

    // Hard-coded Smile Voice plans
    $smile_voice_plans = [
        [
            'name' => 'Smile Voice Only 65',
            'validity' => '30 days',
            'price' => '₦900.0'
        ],
        [
            'name' => 'Smile Voice Only 130',
            'validity' => '30 days',
            'price' => '₦1800.0'
        ],
        [
            'name' => 'Smile Voice Only 200',
            'validity' => '30 days',
            'price' => '₦2600.0'
        ],
        [
            'name' => 'Smile Voice Only 350',
            'validity' => '30 days',
            'price' => '₦4500.0'
        ]
    ];

    // Function to validate phone number
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

    // Handle AJAX requests
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        header('Content-Type: application/json');
        
        if ($_POST['action'] == 'purchase_voice') {
            $phone = $_POST['phone'] ?? '';
            $plan = json_decode($_POST['plan'], true);
            
            if (!validatePhoneNumber($phone)) {
                echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
                exit;
            }
            
            if (!isset($plan['name']) || !isset($plan['price'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid plan selected']);
                exit;
            }
            
            $purchaseId = 'VOXN' . time() . rand(1000, 9999);
            
            if (!isset($_SESSION['voice_purchases'])) {
                $_SESSION['voice_purchases'] = [];
            }
            
            $_SESSION['voice_purchases'][] = [
                'id' => $purchaseId,
                'phone' => $phone,
                'plan' => $plan,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'successful'
            ];
            
            echo json_encode([
                'success' => true,
                'message' => 'Voice plan purchase successful',
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
    <title>Smile Voice - atPay</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
</head>
<body>
   

    <div class="container">
        <!-- Top Navigation -->
   <?php include '../../include/user_top_navbar.php';?>
<br>
                    <center> <div class="nav-title">Smile Voice</div>
            <div style="width: 1.5rem;"></div> <!-- Spacer for alignment --></center>
        <br>
            <!-- Alert Container -->
        <div id="alert-container"></div>

        <!-- Phone Number Input -->
        <div class="section">
            <fieldset class="phone-fieldset">
                <legend class="phone-legend">Phone Number</legend>
                <input type="tel" id="phone-input" class="phone-input" placeholder="Enter phone number" maxlength="11">
            </fieldset>
        </div>

        <!-- Plan Selection -->
        <div class="section">
            <h2 class="section-title">Choose Plan</h2>
            <div class="plans-grid">
                <?php foreach ($smile_voice_plans as $plan): ?>
                    <div class="plan-card" data-plan='<?php echo json_encode($plan); ?>'>
                        <div class="plan-name"><?php echo htmlspecialchars($plan['name']); ?></div>
                        <div class="plan-validity"><?php echo htmlspecialchars($plan['validity']); ?></div>
                        <div class="plan-price"><?php echo htmlspecialchars($plan['price']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Confirmation Section -->
        <div class="confirmation-section" id="confirmation-section">
            <h2 class="confirmation-title">Summary</h2>
            <div class="confirmation-details">
                <div class="confirmation-item">
                    <span class="confirmation-label">Plan Name</span>
                    <span class="confirmation-value" id="confirm-plan-name"></span>
                </div>
                <div class="confirmation-item">
                    <span class="confirmation-label">Price</span>
                    <span class="confirmation-value" id="confirm-plan-price"></span>
                </div>
                <div class="confirmation-item">
                    <span class="confirmation-label">Recipient</span>
                    <span class="confirmation-value" id="confirm-recipient"></span>
                </div>
            </div>
            <button class="confirm-btn" id="confirm-btn" disabled onclick="purchaseVoice()">Confirm Purchase</button>
        </div>
    </div>

                              <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>

        
    <script>
        let selectedPlan = null;
        const phoneInput = document.getElementById('phone-input');
        const confirmationSection = document.getElementById('confirmation-section');
        const confirmPlanName = document.getElementById('confirm-plan-name');
        const confirmPlanPrice = document.getElementById('confirm-plan-price');
        const confirmRecipient = document.getElementById('confirm-recipient');
        const confirmBtn = document.getElementById('confirm-btn');
        const alertContainer = document.getElementById('alert-container');

        // Phone input validation
        phoneInput.addEventListener('input', function() {
            let phone = this.value.replace(/[^0-9]/g, '');
            if (phone.length > 11) {
                phone = phone.substring(0, 11);
            }
            this.value = phone;
            updateConfirmation();
        });

        // Plan selection
        document.querySelectorAll('.plan-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedPlan = JSON.parse(this.dataset.plan);
                updateConfirmation();
            });
        });

        // Update confirmation section
        function updateConfirmation() {
            const phone = phoneInput.value;
            if (phone.length === 11 && selectedPlan) {
                confirmPlanName.textContent = selectedPlan.name;
                confirmPlanPrice.textContent = selectedPlan.price;
                confirmRecipient.textContent = phone;
                confirmationSection.classList.add('active');
                confirmBtn.disabled = false;
            } else {
                confirmationSection.classList.remove('active');
                confirmBtn.disabled = true;
            }
        }

        // Purchase voice plan
        function purchaseVoice() {
            if (!selectedPlan || !phoneInput.value || phoneInput.value.length !== 11) {
                showAlert('Please enter a valid phone number and select a plan', 'error');
                return;
            }

            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<span class="loading"><span class="spinner"></span> Processing...</span>';

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=purchase_voice&phone=${encodeURIComponent(phoneInput.value)}&plan=${encodeURIComponent(JSON.stringify(selectedPlan))}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(`Voice plan purchase successful! Transaction ID: ${data.transaction_id}`, 'success');
                    phoneInput.value = '';
                    selectedPlan = null;
                    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
                    confirmationSection.classList.remove('active');
                    confirmBtn.disabled = true;
                } else {
                    showAlert(data.message || 'Purchase failed. Please try again.', 'error');
                }
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = 'Confirm Purchase';
            })
            .catch(error => {
                console.error('Error purchasing voice plan:', error);
                showAlert('An error occurred. Please try again.', 'error');
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = 'Confirm Purchase';
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
    </script>
</body>
</html>