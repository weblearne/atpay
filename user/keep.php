<?php
// Hardcoded user data
$user_balance = 25750.80;
$user_bonus = 1250.50;
$account_number = "2847593610";
$bank_name = "atPay Bank";
$account_name = "John Doe";

// Handle balance visibility toggle
$show_balance = isset($_GET['show']) ? $_GET['show'] === 'true' : true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Money - atPay Wallet</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4c1d95;
            --secondary-color: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --hover-bg: #f3f4f6;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --success-color: #10b981;
            --accent-color: #6366f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            background: var(--secondary-color);
            min-height: 100vh;
            box-shadow: var(--shadow);
        }

        /* Top Navigation */
        .top-nav {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--secondary-color);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .back-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-primary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background-color 0.2s;
        }

        .back-btn:hover {
            background: var(--hover-bg);
        }

        .nav-title {
            flex: 1;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Wallet Header */
        .wallet-header {
            text-align: center;
            padding: 2rem 1rem 1rem;
        }

        .wallet-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .wallet-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .security-text {
            color: var(--text-secondary);
            font-size: 0.95rem;
            max-width: 300px;
            margin: 0 auto;
            line-height: 1.5;
        }

        /* Balance Section */
        .balance-section {
            background: var(--primary-color);
            margin: 1.5rem 1rem;
            border-radius: 20px;
            padding: 2rem 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .balance-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .balance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .balance-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .balance-toggle {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .balance-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .balance-amount {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .balance-hidden {
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .bonus-amount {
            font-size: 0.85rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .account-info {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .account-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .account-row:last-child {
            margin-bottom: 0;
        }

        .account-label {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .account-value {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .copy-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 0.3rem 0.5rem;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .copy-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Funding Options */
        .funding-options {
            padding: 1rem;
        }

        .funding-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .funding-option {
            background: var(--secondary-color);
            border: 2px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem 1rem;
            text-align: center;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .funding-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 29, 149, 0.15);
        }

        .funding-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.2rem;
        }

        .funding-title {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .funding-description {
            font-size: 0.8rem;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        /* Responsive Design */
        @media (min-width: 481px) {
            .container {
                max-width: 600px;
                margin-top: 2rem;
                border-radius: 20px;
                min-height: calc(100vh - 4rem);
            }

            .funding-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 800px;
            }

            .funding-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .balance-amount {
                font-size: 3rem;
            }
        }

        @media (max-width: 480px) {
            .wallet-header {
                padding: 1.5rem 1rem 1rem;
            }

            .balance-section {
                margin: 1rem;
                padding: 1.5rem 1rem;
            }

            .balance-amount {
                font-size: 2rem;
            }

            .funding-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.8rem;
            }

            .funding-option {
                padding: 1rem 0.5rem;
            }

            .funding-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .funding-option {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .funding-option:nth-child(1) { animation-delay: 0.1s; }
        .funding-option:nth-child(2) { animation-delay: 0.2s; }
        .funding-option:nth-child(3) { animation-delay: 0.3s; }
        .funding-option:nth-child(4) { animation-delay: 0.4s; }
        .funding-option:nth-child(5) { animation-delay: 0.5s; }

        /* Toast notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .toast.show {
            transform: translateX(0);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <div class="top-nav">
            <button class="back-btn" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="nav-title">Add Money</div>
            <div style="width: 40px;"></div> <!-- Spacer for centering -->
        </div>

        <!-- Wallet Header -->
        <div class="wallet-header">
            <div class="wallet-logo">
                <div class="logo-icon">aP</div>
                <div class="wallet-name">Wallet</div>
            </div>
            <p class="security-text">
                Keep your financial information more secure and protected with our advanced encryption technology.
            </p>
        </div>

        <!-- Balance Section -->
        <div class="balance-section">
            <div class="balance-header">
                <span class="balance-label">Current Balance</span>
                <button class="balance-toggle" onclick="toggleBalance()">
                    <i class="fas <?php echo $show_balance ? 'fa-eye-slash' : 'fa-eye'; ?>" id="eyeIcon"></i>
                </button>
            </div>
            
            <div class="balance-amount" id="balanceAmount">
                <?php if ($show_balance): ?>
                    ₦<?php echo number_format($user_balance, 2); ?>
                <?php else: ?>
                    <span class="balance-hidden">••••••••</span>
                <?php endif; ?>
            </div>
            
            <div class="bonus-amount">
                NGN Bonus: <?php echo $show_balance ? '₦' . number_format($user_bonus, 2) : '••••••'; ?>
            </div>

            <div class="account-info">
                <div class="account-row">
                    <span class="account-label">Account Number</span>
                    <div class="account-value">
                        <span id="accountNumber"><?php echo $account_number; ?></span>
                        <button class="copy-btn" onclick="copyToClipboard('<?php echo $account_number; ?>')">
                            <i class="fas fa-copy"></i>
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
            <div class="funding-grid">
                <a href="bank-transfer.php" class="funding-option">
                    <div class="funding-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="funding-title">Bank Transfer</div>
                    <div class="funding-description">Top-up your wallet with one time transfer</div>
                </a>

                <a href="usdt-transfer.php" class="funding-option">
                    <div class="funding-icon">
                        <i class="fab fa-bitcoin"></i>
                    </div>
                    <div class="funding-title">USDT Transfer</div>
                    <div class="funding-description">Fund your account using cryptocurrency</div>
                </a>

                <a href="manual-funding.php" class="funding-option">
                    <div class="funding-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="funding-title">Manual Funding</div>
                    <div class="funding-description">Add money through manual verification</div>
                </a>

                <a href="airtime-to-cash.php" class="funding-option">
                    <div class="funding-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="funding-title">Airtime to Cash</div>
                    <div class="funding-description">Convert your airtime to wallet balance</div>
                </a>

                <a href="virtual-account.php" class="funding-option">
                    <div class="funding-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="funding-title">Virtual Account</div>
                    <div class="funding-description">Use dedicated virtual account number</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i> <span id="toastMessage">Account number copied!</span>
    </div>

    <script>
        let balanceVisible = <?php echo $show_balance ? 'true' : 'false'; ?>;

        function toggleBalance() {
            balanceVisible = !balanceVisible;
            const balanceAmount = document.getElementById('balanceAmount');
            const eyeIcon = document.getElementById('eyeIcon');
            const bonusElement = document.querySelector('.bonus-amount');
            
            if (balanceVisible) {
                balanceAmount.innerHTML = '₦<?php echo number_format($user_balance, 2); ?>';
                bonusElement.innerHTML = 'NGN Bonus: ₦<?php echo number_format($user_bonus, 2); ?>';
                eyeIcon.className = 'fas fa-eye-slash';
            } else {
                balanceAmount.innerHTML = '<span class="balance-hidden">••••••••</span>';
                bonusElement.innerHTML = 'NGN Bonus: ••••••';
                eyeIcon.className = 'fas fa-eye';
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('Account number copied!');
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('Account number copied!');
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

        // Add loading animation to funding options
        document.addEventListener('DOMContentLoaded', function() {
            const options = document.querySelectorAll('.funding-option');
            options.forEach((option, index) => {
                option.style.opacity = '0';
                option.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    option.style.transition = 'all 0.5s ease';
                    option.style.opacity = '1';
                    option.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>