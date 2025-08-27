<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['atpay_auth_token_key'])) {
    header("Location: ../../Auth/login/");
    exit();
}

// Function to fetch user info from API
function fetchUserInfo($token) {
    $endpoint = "https://atpay.ng/api/user/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Token $token"
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

// Fetch details using token
$response = fetchUserInfo($_SESSION['atpay_auth_token_key']);

if (isset($response['error']) && $response['error'] === false) {
    // Wallet info
    $wallet = $response['wallets'][0] ?? [];
    $user_balance_raw = floatval(str_replace(["N",","], "", $wallet['AccountBalance'] ?? 0));
    $user_bonus_raw   = floatval(str_replace(["N",","], "", $wallet['AccountBonus'] ?? 0));

  // Fetch all accounts
$accounts = $response['accounts'] ?? [];


} else {
    $user_balance_raw = 0;
    $user_bonus_raw   = 0;
    $account_number   = "N/A";
    $bank_name        = "N/A";
    $account_name     = "N/A";

    // If token invalid, logout
    if (isset($response['message']) && stripos($response['message'], 'unauthorized') !== false) {
        session_destroy();
        header("Location: ../../Auth/login.php?error=SessionExpired");
        exit();
    }
}

// Format currency values
$user_balance = "NGN " . number_format($user_balance_raw, 2);
$user_bonus   = "NGN " . number_format($user_bonus_raw, 2);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Money - atPay Wallet</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="add_money.css">
      <link rel="icon" type="image/png" href="../../images/logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body>
    <div class="main-container">
        <!-- Top Navigation -->
       <?php include '../../include/user_top_navbar.php';?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Wallet Header -->
            <div class="wallet-header">
                <div class="logo">
                <img src="../../images/logo.png" style="width:100px; height:100px; border-radius:50px;" alt="">
                <span style="font-size:30px;">Wallet</span>
            </div>
            </div>

            <!-- Security Message -->
            <div class="security-message">
                <h2>Keep Your Financial Information More Secure and Protected</h2>
                <p>Add funds to your wallet securely using various payment methods with advanced encryption technology</p>
            </div>

            <!-- Balance Section -->
            <div class="balance-section">
                <div class="balance-header">
                    <h3>Current Balance</h3>
                    <button class="balance-toggle" onclick="toggleBalance()">
                        <i class="fas fa-eye-slash" id="eyeIcon"></i>
                    </button>
                </div>
                
                <div class="balance" id="balance"><?php echo $user_balance; ?></div>
                <div class="bonus" id="bonus">NGN Bonus:<?php echo $user_bonus; ?></div>

              <div class="account-info">
    <?php if (!empty($accounts)): ?>
        <?php foreach ($accounts as $acc): ?>
            <div class="account-card">
                <div class="account-row">
                    <span class="account-label">Account Number</span>
                    <div class="account-value">
                        <span><?php echo $acc['AccNumber'] ?? "N/A"; ?></span>
                        <button class="copy-btn" onclick="copyToClipboard('<?php echo $acc['AccNumber'] ?? ''; ?>')">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
                <div class="account-row">
                    <span class="account-label">Bank Name</span>
                    <span class="account-value"><?php echo $acc['BnakName'] ?? "N/A"; ?></span>
                </div>
                <div class="account-row">
                    <span class="account-label">Account Name</span>
                    <span class="account-value"><?php echo $acc['AccName'] ?? "N/A"; ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-accounts">No accounts found</div>
    <?php endif; ?>
</div>
<br>

            <!-- Funding Options -->
            <div class="funding-options">
                <div class="options-grid">
                    <a href="#" class="option">
                        <div class="option-icon">
                          <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div class="option-text">
                            <h4>Bank Transfer</h4>
                            <p>Top-up your wallet with one-time transfer from any bank account</p>
                        </div>
                    </a>

                    <a href="#" class="option">
                        <div class="option-icon">
                          <i class="fa-solid fa-hashtag"></i>
                        </div>
                        <div class="option-text">
                            <h4>USDT Transfer</h4>
                            <p>Fund your wallet using USDT cryptocurrency for instant transfers</p>
                        </div>
                    </a>

                    <a href="#" class="option">
                        <div class="option-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="option-text">
                            <h4>Manual Funding</h4>
                            <p>Manually fund your wallet with verification from our support team</p>
                        </div>
                    </a>

                    <a href="#" class="option">
                        <div class="option-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="option-text">
                            <h4>Airtime to Cash</h4>
                            <p>Convert your airtime credit to wallet balance instantly</p>
                        </div>
                    </a>

                    <a href="#" class="option">
                        <div class="option-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="option-text">
                            <h4>Virtual Account</h4>
                            <p>Use your dedicated virtual account number for seamless funding</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Account number copied successfully!</span>
    </div>


      <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>


    <script>
        function goBack() {
  window.history.back();
}
        let balanceVisible = true;

        function toggleBalance() {
            const balanceElement = document.getElementById('balance');
            const bonusElement = document.getElementById('bonus');
            const toggleButton = document.getElementById('eyeIcon');
            
            if (balanceVisible) {
                balanceElement.textContent = '••••••••';
                bonusElement.textContent = 'NGN Bonus: ••••••';
                toggleButton.className = 'fas fa-eye';
                balanceVisible = false;
            } else {
                balanceElement.textContent = '<?php echo $user_balance; ?>';
                bonusElement.textContent = 'NGN Bonus: <?php echo $user_bonus; ?>';
                toggleButton.className = 'fas fa-eye-slash';
                balanceVisible = true;
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('Account number copied successfully!');
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('Account number copied successfully!');
            });
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Initialize page animations
        document.addEventListener('DOMContentLoaded', function() {
            const options = document.querySelectorAll('.option');
            options.forEach((option, index) => {
                option.style.opacity = '0';
                option.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    option.style.transition = 'all 0.6s ease-out';
                    option.style.opacity = '1';
                    option.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>