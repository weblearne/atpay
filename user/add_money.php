<?php
// Hard-coded user data
$user_balance = "NGN 5,000.00";
$user_bonus = "NGN 0.00";
$account_number = "1234567890";
$bank_name = "Palmpay";
$account_name = "Web Learner";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Money - atPay Wallet</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="add_money.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body>
    <div class="main-container">
        <!-- Top Navigation -->
        <nav class="navbar">
            <div class="nav-left" >
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="nav-title" onclick="goBack()">Back</div>
            </div>
        </nav>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Wallet Header -->
            <div class="wallet-header">
                <div class="logo">
                <img src="../images/logo.png" style="width:100px; height:100px; border-radius:50px;" alt="">
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
                <div class="bonus" id="bonus">NGN Bonus: <?php echo $user_bonus; ?></div>

                <div class="account-info">
                    <div class="account-row">
                        <span class="account-label">Account Number</span>
                        <div class="account-value">
                            <span id="accountNumber"><?php echo $account_number; ?></span>
                            <button class="copy-btn" onclick="copyToClipboard('<?php echo $account_number; ?>')">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                    <div class="account-row">
                        <span class="account-label">Bank Name</span>
                        <span class="account-value"><?php echo $bank_name; ?></span>
                    </div>
                    <div class="account-row">
                        <span class="account-label">Account Name</span>
                        <span class="account-value"><?php echo $account_name; ?></span>
                    </div>
                </div>
            </div>

            <!-- Funding Options -->
            <div class="funding-options">
                <div class="options-grid">
                    <a href="/bank-transfer" class="option">
                        <div class="option-icon">
                          <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div class="option-text">
                            <h4>Bank Transfer</h4>
                            <p>Top-up your wallet with one-time transfer from any bank account</p>
                        </div>
                    </a>

                    <a href="/usdt-transfer" class="option">
                        <div class="option-icon">
                          <i class="fa-solid fa-hashtag"></i>
                        </div>
                        <div class="option-text">
                            <h4>USDT Transfer</h4>
                            <p>Fund your wallet using USDT cryptocurrency for instant transfers</p>
                        </div>
                    </a>

                    <a href="/manual-funding" class="option">
                        <div class="option-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="option-text">
                            <h4>Manual Funding</h4>
                            <p>Manually fund your wallet with verification from our support team</p>
                        </div>
                    </a>

                    <a href="/airtime-to-cash" class="option">
                        <div class="option-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="option-text">
                            <h4>Airtime to Cash</h4>
                            <p>Convert your airtime credit to wallet balance instantly</p>
                        </div>
                    </a>

                    <a href="/virtual-account" class="option">
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