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
            --alternate-bg: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

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
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .nav-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
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

        .section {
            background-color: var(--secondary-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
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

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .plan-card {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background-color: var(--alternate-bg);
        }

        .plan-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .plan-card.selected {
            border-color: var(--primary-color);
            background-color: var(--hover-bg);
        }

        .plan-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .plan-validity {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
        }

        .plan-price {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .confirmation-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--secondary-color);
            border-top: 2px solid var(--border-color);
            padding: 1.5rem;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(100%);
            transition: transform 0.3s ease-in-out;
            z-index: 200;
        }

        .confirmation-section.active {
            transform: translateY(0);
        }

        .confirmation-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .confirmation-details {
            background-color: var(--alternate-bg);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .confirmation-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.875rem;
        }

        .confirmation-label {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .confirmation-value {
            font-weight: 600;
            color: var(--text-primary);
        }

        .confirm-btn {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s;
            width: 100%;
        }

        .confirm-btn:hover {
            background-color: #3730a3;
            transform: translateY(-1px);
        }

        .confirm-btn:disabled {
            background-color: var(--text-secondary);
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid var(--success-color);
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid var(--error-color);
        }

        .loading {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid var(--secondary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0.75rem;
            }

            .section {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .plans-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 0.75rem;
            }

            .confirmation-section {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .nav-title {
                font-size: 1rem;
            }

            .back-btn {
                font-size: 1.25rem;
            }

            .section-title {
                font-size: 1rem;
            }

            .plan-card {
                padding: 0.75rem;
            }

            .plan-name {
                font-size: 0.75rem;
            }

            .plan-validity {
                font-size: 0.7rem;
            }

            .plan-price {
                font-size: 0.875rem;
            }

            .confirmation-title {
                font-size: 1rem;
            }

            .confirmation-item {
                font-size: 0.75rem;
            }
        }
    </style>
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