<?php
session_start();

// Sample referral data (in real app, fetch from database)
$referralInfo = [
    'user_referral_code' => 'REF' . strtoupper(substr(md5(uniqid()), 0, 6)),
    'earned_amount' => '₦500',
    'total_referrals' => 3
];

// Handle referral actions (e.g., applying a referral code)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    switch ($_POST['action']) {
        case 'apply_referral':
            $referralCode = $_POST['referral_code'] ?? '';
            // Simulate referral validation (in real app, check against database)
            if (strlen($referralCode) === 8 && strpos($referralCode, 'REF') === 0) {
                echo json_encode(['success' => true, 'message' => 'Referral applied successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid referral code']);
            }
            exit;
    }
}

// Get referral history (in real app, fetch from database)
function getReferralHistory() {
    return $_SESSION['referral_history'] ?? [
        ['id' => 'REF202307310001', 'referred_user' => 'Jane Doe', 'amount' => '₦200', 'date' => '2025-07-30 14:30'],
        ['id' => 'REF202307310002', 'referred_user' => 'Mike Smith', 'amount' => '₦150', 'date' => '2025-07-29 09:15']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refer and Earn</title>
       <link rel="icon" type="image/png" href="../../images/logo.png">

   <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Top Navigation -->
  <?php include '../../include/user_top_navbar.php';?>

    <!-- Main Container -->
    <div class="container">
        <div id="alert-container"></div>

        <!-- Referral Info -->
        <div class="section">
            <h2 class="section-title">Your Referral Details</h2>
            <div class="referral-info">
                <div class="referral-code"><?php echo htmlspecialchars($referralInfo['user_referral_code']); ?></div>
                <div class="referral-earnings">Total Earned: <?php echo htmlspecialchars($referralInfo['earned_amount']); ?></div>
                <div class="referral-count">Total Referrals: <?php echo htmlspecialchars($referralInfo['total_referrals']); ?></div>
                <button class="share-btn" onclick="shareReferral()">Share Referral Code</button>
            </div>
        </div>

        <!-- Apply Referral Section -->
        <div class="input-section">
            <fieldset class="input-fieldset">
                <legend class="input-legend">Apply Referral Code</legend>
                <input type="text" id="referral-input" class="input-field" placeholder="Enter referral code" maxlength="8">
            </fieldset>
            <button id="apply-btn" class="apply-btn" disabled onclick="applyReferral()">Apply Code</button>
        </div>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Referral History</h2>
                <button class="modal-close" onclick="closeHistory()">&times;</button>
            </div>
            <div class="modal-body">
                <?php 
                $history = getReferralHistory();
                if (empty($history)): ?>
                    <p style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                        No referral earnings yet
                    </p>
                <?php else: ?>
                    <?php foreach (array_reverse($history) as $transaction): ?>
                        <div class="history-item">
                            <div class="history-id"><?php echo htmlspecialchars($transaction['id']); ?></div>
                            <div class="history-details">
                                <div>Referred User: <?php echo htmlspecialchars($transaction['referred_user']); ?></div>
                                <div>Date: <?php echo date('M j, Y - g:i A', strtotime($transaction['date'])); ?></div>
                                <div class="history-amount"><?php echo htmlspecialchars($transaction['amount']); ?></div>
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
        const referralInput = document.getElementById('referral-input');
        const applyBtn = document.getElementById('apply-btn');
        const alertContainer = document.getElementById('alert-container');

        // Validate apply button state
        referralInput.addEventListener('input', function() {
            applyBtn.disabled = this.value.length !== 8 || !this.value.startsWith('REF');
        });

        // Apply referral code
        function applyReferral() {
            const referralCode = referralInput.value;

            applyBtn.disabled = true;
            applyBtn.textContent = 'Processing...';

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=apply_referral&referral_code=' + encodeURIComponent(referralCode)
            })
            .then(response => response.json())
            .then(data => {
                showAlert(data.message, data.success ? 'success' : 'error');
                if (data.success) {
                    referralInput.value = '';
                    applyBtn.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'error');
            })
            .finally(() => {
                applyBtn.textContent = 'Apply Code';
                applyBtn.disabled = referralInput.value.length !== 8 || !referralInput.value.startsWith('REF');
            });
        }

        // Share referral code
        function shareReferral() {
            const referralCode = '<?php echo htmlspecialchars($referralInfo['user_referral_code']); ?>';
            if (navigator.share) {
                navigator.share({
                    title: 'Refer and Earn',
                    text: `Use my referral code ${referralCode} to earn rewards!`,
                    url: window.location.href
                }).catch(error => console.error('Error sharing:', error));
            } else {
                prompt('Copy your referral code:', referralCode);
            }
        }

        // Show alert message
        function showAlert(message, type = 'error') {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = message;
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alert);
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(() => alert.remove(), 5000);
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