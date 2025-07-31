<?php
session_start();

// Hardcoded user data (for testing)
$user_id = 1;
$user = [
    'id' => $user_id,
    'name' => 'Web Learner',
    'email' => 'basirulawan02@gmail.com',
    'profile_picture' => isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : ''
];
$status = [

    'transaction_count' => '100.000',
    'total_spent' => '100.000',
    'total_bonus' => '100.000',
];

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $upload_dir = '../images/img3.jpg';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['profile_picture'];

    if (in_array($file['type'], $allowed_types) && $file['size'] <= 5000000) {
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = $user_id . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            // Optionally remove old picture
            if (!empty($user['profile_picture']) && file_exists($user['profile_picture'])) {
                unlink($user['profile_picture']);
            }

            // Save to session as a stand-in for DB
            $_SESSION['profile_picture'] = $upload_path;
            $user['profile_picture'] = $upload_path;

            $_SESSION['success_message'] = 'Profile picture updated successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to upload profile picture.';
        }
    } else {
        $_SESSION['error_message'] = 'Invalid file type or size. Please upload JPEG, PNG, or GIF under 5MB.';
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Handle logout
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
    <title>User Profile - atPay</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                  <button class="back-btn" onclick="window.history.back()" style="color:var(--primary-color);"> 
                <i class="fas fa-arrow-left"></i>
            </button>
                <img src="../../images/logo.png" style="width:50px; height:50px;" alt="">
                <span>Profile</span>
            </div>
            <div class="header-actions">
                <!-- <span style="color: var(--text-secondary);">Welcome back, <!--?php echo htmlspecialchars($user['name'] ?? ''); ?--><!--/span> -->          
                        <a href="https://help.atpay.com" class="help-icon" title="Help Center">
                    <i class="fas fa-question-circle"></i>
                </a>
            </div>
        </header>

        <div class="profile-container">
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <div class="profile-picture-container" onclick="document.getElementById('profilePictureInput').click()">
              <img src="<?php echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'images/default-avatar.png'; ?>" 
     alt="Profile Picture" class="profile-img">

                <div class="upload-overlay">
                    <i class="fas fa-camera"></i>
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data" style="display: none;">
                <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*" onchange="this.form.submit()">
            </form>

            <div class="user-info">
                <div class="user-name"><?php echo htmlspecialchars($user['name'] ??'' . ' ' . $user['name'] ??''); ?></div>
                <div class="user-email"><?php echo htmlspecialchars($user['email']??''); ?></div>
                <div class="user-status">
                    <i class="fas fa-check-circle"></i> Verified Account
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number"><?php echo number_format($status['transaction_count']??''); ?></span>
                    <span class="stat-label">Total Transactions</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">₦<?php echo number_format($status['total_spent'] ??'', 2); ?></span>
                    <span class="stat-label">Total Spent</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">₦<?php echo number_format($status['total_bonus'] ??'', 2); ?></span>
                    <span class="stat-label">Bonus Earned</span>
                </div>
            </div>

            <hr>

            <div class="links">
                <a href="account-management.php" class="link-item">
                    <i class="fas fa-user-cog"></i> Account Management
                </a>
                <a href="transaction-history.php" class="link-item">
                    <i class="fas fa-history"></i> Transaction History
                </a>
                <a href="bonuses.php" class="link-item">
                    <i class="fas fa-gift"></i> Bonus & Rewards
                </a>
                <a href="payment-methods.php" class="link-item">
                    <i class="fas fa-credit-card"></i> Payment Methods
                </a>
                <a href="security.php" class="link-item">
                    <i class="fas fa-shield-alt"></i> Security Settings
                </a>
                <a href="legal.php" class="link-item">
                    <i class="fas fa-file-contract"></i> Legal Documentation                
                </a>
                <a href="about.php" class="link-item">
                    <i class="fas fa-info-circle"></i> About atPay
                </a>
                <a href="support.php" class="link-item">
                    <i class="fas fa-headset"></i> Customer Support
                </a>
            </div>

            <hr>

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

            <a href="../../logout.php" class="logout-btn" onclick="return confirm('Are you sure you want to logout')">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
<br>
                    <footer>
                         <!--?php include '../../include/footer.php'?-->

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
                overlay.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }
        });
    </script>
</body>
</html>