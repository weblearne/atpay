<?php
session_start();

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
    
    switch ($_POST['action']) {
        case 'send_gift':
            $recipientPhone = $_POST['recipient_phone'] ?? '';
            $amount = $_POST['amount'] ?? '';
            
            if (!validatePhoneNumber($recipientPhone)) {
                echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
                exit;
            }
            
            if (!is_numeric($amount) || $amount < 100) {
                echo json_encode(['success' => false, 'message' => 'Minimum amount is ₦100']);
                exit;
            }
            
            $transactionId = 'GFT' . time() . rand(1000, 9999);
            
            if (!isset($_SESSION['gift_history'])) {
                $_SESSION['gift_history'] = [];
            }
            
            $_SESSION['gift_history'][] = [
                'id' => $transactionId,
                'recipient_phone' => $recipientPhone,
                'amount' => $amount,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'successful'
            ];
            
            echo json_encode([
                'success' => true,
                'message' => 'Gift sent successfully',
                'transaction_id' => $transactionId
            ]);
            exit;
    }
}

// Get transaction history
function getTransactionHistory() {
    return $_SESSION['gift_history'] ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Gift</title>
           <link rel="icon" type="image/png" href="../../images/logo.png">

   <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Top Navigation -->
    <?php include '../../include/user_top_navbar.php';?>

    <!-- Main Container -->
    <div class="container">
        <div id="alert-container"></div>

        <!-- Recipient Phone Number Input -->
        <div class="input-section">
            <fieldset class="input-fieldset">
                <legend class="input-legend">Recipient Phone Number</legend>
                <input type="tel" id="recipient-phone" class="input-field" placeholder="Enter recipient phone number" maxlength="11">
            </fieldset>
        </div>

        <!-- Amount Input -->
        <div class="input-section">
            <fieldset class="input-fieldset">
                <legend class="input-legend">Amount (₦)</legend>
                <input type="number" id="amount" class="input-field" placeholder="Enter amount" min="100" step="1">
            </fieldset>
        </div>

        <!-- Send Button -->
        <div class="input-section">
            <button id="send-btn" class="send-btn" disabled onclick="showConfirmation()">Send Gift</button>
        </div>
    </div>

    <!-- Confirmation Popup -->
    <div id="confirmation-popup" class="popup">
        <div class="popup-content">
            <h3>Confirm Gift Details</h3>
            <p id="confirmation-details"></p>
            <div class="popup-buttons">
                <button class="confirm-btn" onclick="sendGift()">Confirm</button>
                <button class="cancel-btn" onclick="hideConfirmation()">Cancel</button>
            </div>
        </div>
    </div>



                
      <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>

        
    <script>
        const recipientPhoneInput = document.getElementById('recipient-phone');
        const amountInput = document.getElementById('amount');
        const sendBtn = document.getElementById('send-btn');
        const confirmationPopup = document.getElementById('confirmation-popup');
        const confirmationDetails = document.getElementById('confirmation-details');
        const alertContainer = document.getElementById('alert-container');

        // Validate inputs and enable/disable send button
        function validateInputs() {
            const phone = recipientPhoneInput.value;
            const amount = amountInput.value;
            sendBtn.disabled = !phone || phone.length !== 11 || !amount || parseFloat(amount) < 100;
        }

        // Input event listeners
        recipientPhoneInput.addEventListener('input', function() {
            let phone = this.value.replace(/[^0-9]/g, '');
            if (phone.length > 11) phone = phone.substring(0, 11);
            this.value = phone;
            validateInputs();
        });

        amountInput.addEventListener('input', function() {
            validateInputs();
        });

        // Show confirmation popup
        function showConfirmation() {
            const phone = recipientPhoneInput.value;
            const amount = amountInput.value;
            confirmationDetails.innerHTML = `Send ₦${parseFloat(amount).toLocaleString()} to ${phone}?`;
            confirmationPopup.classList.add('active');
        }

        // Hide confirmation popup
        function hideConfirmation() {
            confirmationPopup.classList.remove('active');
        }

        // Send gift function
        function sendGift() {
            const phone = recipientPhoneInput.value;
            const amount = amountInput.value;

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=send_gift&recipient_phone=' + encodeURIComponent(phone) +
                      '&amount=' + encodeURIComponent(amount)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(`Gift sent successfully! Transaction ID: ${data.transaction_id}`, 'success');
                    recipientPhoneInput.value = '';
                    amountInput.value = '';
                    validateInputs();
                } else {
                    showAlert(data.message || 'Failed to send gift', 'error');
                }
                hideConfirmation();
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'error');
                hideConfirmation();
            });
        }

        // Show alert message
        function showAlert(message, type) {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alert);
            setTimeout(() => alert.remove(), 5000);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Go back function
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>