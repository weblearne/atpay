<?php
session_start();

// === Redirect if token missing ===
if (!isset($_SESSION['atpay_auth_token_key'])) {
    header("Location: ../Auth/login");
    exit();
}

$token = $_SESSION['atpay_auth_token_key'];

// === Fetch user info from API ===
function fetchUserInfo($token) {
    $endpoint = "https://atpay.ng/api/user/";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true); // API requires POST
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json",
        "Authorization: Token $token"
    ]);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    }

    curl_close($ch);

    return json_decode($result, true);
}

$response = fetchUserInfo($token);
$user_id  = $_SESSION['user_id'] ?? 1;

// === Parse API response ===
if ($response && empty($response['error'])) {
    // ✅ API Success
    $wallet  = $response['wallets'][0] ?? [];
    $account = $response['accounts'][0] ?? [];

   $user = [
    'id'              => $user_id,
    'name'            => $response['name'] ?? 'Unknown User',
    'email'           => $_SESSION['user_email'] ?? '', // fallback from session, not API
    'profile_picture' => $_SESSION['profile_picture'] ?? '',
    'account_status'  => $response['status'] ?? 'verified',
    'account_tier'    => $response['tier'] ?? 'Basic'
];


    $status = [
        'transaction_count'    => $response['transaction_count'] ?? 0,
        'total_spent'          => $response['total_spent'] ?? 0.00,
        'total_bonus'          => $wallet['AccountBonus'] ?? 0.00,
        'monthly_transactions' => $response['monthly_transactions'] ?? 0,
        'success_rate'         => $response['success_rate'] ?? 0,
        'account_balance'      => $wallet['AccountBalance'] ?? 0.00
    ];

} else {
    // ❌ API Failed
    if (isset($response['message']) && stripos($response['message'], 'unauthorized') !== false) {
        session_destroy();
        header("Location: ../Auth/login/?error=SessionExpired");
        exit();
    }

    $user = [
        'id'              => $user_id,
        'name'            => 'Guest',
        'email'           => '',
        'profile_picture' => $_SESSION['profile_picture'] ?? '',
        'account_status'  => 'unknown',
        'account_tier'    => ''
    ];

    $status = [
        'transaction_count'    => 0,
        'total_spent'          => 0.00,
        'total_bonus'          => 0.00,
        'monthly_transactions' => 0,
        'success_rate'         => 0,
        'account_balance'      => 0.00
    ];
}

// === Profile Picture Upload ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $upload_dir = 'uploads/profile_pictures/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['profile_picture'];

    if (in_array($file['type'], $allowed_types) && $file['size'] <= 5000000) {
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = $user_id . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            if (!empty($user['profile_picture']) && file_exists($user['profile_picture'])) {
                unlink($user['profile_picture']);
            }

            $_SESSION['profile_picture'] = $upload_path;
            $user['profile_picture'] = $upload_path;
            $_SESSION['success_message'] = 'Profile picture updated successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to upload profile picture.';
        }
    } else {
        $_SESSION['error_message'] = 'Invalid file type or size. Please upload JPEG, PNG, GIF, or WebP under 5MB.';
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// === Profile Update ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $_SESSION['success_message'] = 'Profile updated successfully!';
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// === Logout ===
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - atPay Wallet</title>
       <link rel="icon" type="image/png" href="../../images/logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
</head>
<body>
     <?php include '../../include/user_top_navbar.php';?>

    <div class="container">
        <div class="profile-container">
            <!-- Alerts -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <!-- Profile Hero Section -->
            <div class="profile-hero">
                <div class="profile-picture-container" >
                  <img src="https://img.icons8.com/color/120/user-male-circle--v1.png" alt="Cartoon Profile" class="profile-img">
              
                    <div class="upload-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>

                <!-- <form method="POST" enctype="multipart/form-data" style="display: none;">
                    <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*" onchange="this.form.submit()">
                </form> -->

                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
                    <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>
                    <div class="user-status">
                        <i class="fas fa-check-circle"></i>
                        <?php echo ucfirst($user['account_status']); ?> <?php echo $user['account_tier']; ?> Account
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            

                <!-- Quick Actions -->
                <!-- <div class="nav-section">
                    <h3 class="section-title">Quick Actions</h3>
                    <div class="quick-actions">
                        <div class="action-card" onclick="location.href='send-money.php'">
                            <div class="action-icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="action-title">Send Money</div>
                            <div class="action-description">Transfer funds instantly</div>
                        </div>
                        <div class="action-card" onclick="location.href='add-funds.php'">
                            <div class="action-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="action-title">Add Funds</div>
                            <div class="action-description">Top up your wallet</div>
                        </div>
                        <div class="action-card" onclick="location.href='pay-bills.php'">
                            <div class="action-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div class="action-title">Pay Bills</div>
                            <div class="action-description">Utilities & services</div>
                        </div>
                    </div>
                </div> -->

                <!-- Navigation Links -->
                <div class="nav-section">
                    <h3 class="section-title">Account Management</h3>
                    <div class="nav-links">
                        <a href="../../user/acc_man/" class="nav-link">
                            <i class="fas fa-user-cog"></i>
                            <span>Account Settings</span>
                        </a>
                        <a href="../../list/history/" class="nav-link">
                            <i class="fas fa-history"></i>
                            <span>Transaction History</span>
                        </a>
                        <a href="../../list/invite/" class="nav-link">
                            <i class="fas fa-gift"></i>
                            <span>Bonus & Rewards</span>
                        </a>
                        <!-- <a href="payment-methods.php" class="nav-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Payment Methods</span>
                        </a> -->
                    </div>
                </div>

                <div class="nav-section">
                    <h3 class="section-title">Security & Support</h3>
                    <div class="nav-links">
                        <a href="../../user/acc_man" class="nav-link">
                            <i class="fas fa-shield-alt"></i>
                            <span>Security Settings</span>
                        </a>
                        <a href="legaldocs/" class="nav-link">
                            <i class="fas fa-file-contract"></i>
                            <span>Legal Documentation</span>
                        </a>
                        <a href="../../user/chat/" class="nav-link">
                            <i class="fas fa-headset"></i>
                            <span>Customer Support</span>
                        </a>
                        <a href="aboutatPay/" class="nav-link">
                            <i class="fas fa-info-circle"></i>
                            <span>About atPay</span>
                        </a>
                    </div>
                </div>

                <!-- Social Media Section -->
                <div class="social-section">
                    <h3 class="section-title">Connect With Us</h3>
                    <div class="social-media">
                        <a href="https://instagram.com/atpay" class="social-icon" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://x.com/atpay" class="social-icon" title="X (Twitter)">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://facebook.com/atpay" class="social-icon" title="Facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://tiktok.com/@atpay" class="social-icon" title="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>

                    <a href="../../logout.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

      <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);

        // Add loading state for profile picture upload
        document.getElementById('profilePictureInput').addEventListener('change', function() {
            if (this.files[0]) {
                const overlay = document.querySelector('.upload-overlay');
                overlay.innerHTML = '<i class="fas fa-spinner loading"></i>';
            }
        });

        // Add click animations to action cards
        document.querySelectorAll('.action-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>