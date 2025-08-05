 <?php
    // session_start();

    // Hardcoded user data
    $user = [
        'name' => 'Basiru Lawan',
        'phone' => '07043527649',
        'account_type' => 'Basic',
        'account_name' => 'Smart User',
        'limit' => '20,000',
        'status' => 'Active',
        'kyc_level' => 'Level 1',
        'daily_airtime_limit' => '5,000',
        'daily_data_limit' => '20,000',
        'relationship_manager' => 'atPay'
    ];
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - atPay</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 <link rel="stylesheet" href="index.css">
</head>
<body>
   

    <div class="container">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <button class="back-btn" onclick="window.history.back()" style="color:var(--primary-color);"> 
                <i class="fas fa-arrow-left"></i>    User Profile
            </button>
        </nav>

        <!-- Profile Container -->
        <div class="profile-container">
            <!-- Profile Photo -->
            <img src="https://img.icons8.com/color/120/user-male-circle--v1.png" alt="Cartoon Profile" class="profile-img">

            <!-- User Info -->
            <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
            <div class="user-phone"><?php echo htmlspecialchars($user['phone']); ?></div>

            <!-- Account Type Section -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Account Type</h2>
                    <a href="/upgrade" class="upgrade-btn">Upgrade Now</a>
                </div>
                <div class="section-details">
                    <div class="detail-item">
                        <span class="detail-label">Account Name</span>
                        <span class="detail-value"><?php echo htmlspecialchars($user['account_name']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Limit</span>
                        <span class="detail-value">₦<?php echo htmlspecialchars($user['limit']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status</span>
                        <span class="detail-value"><?php echo htmlspecialchars($user['status']); ?></span>
                    </div>
                </div>
            </div>

            <!-- KYC Level Section -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">KYC Level</h2>
                    <a href="/kyc-upgrade" class="upgrade-btn">Upgrade Now</a>
                </div>
                <div class="section-details">
                    <div class="detail-item">
                        <span class="detail-label">Daily Airtime Limit</span>
                        <span class="detail-value">₦<?php echo htmlspecialchars($user['daily_airtime_limit']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Daily Data Limit</span>
                        <span class="detail-value">₦<?php echo htmlspecialchars($user['daily_data_limit']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Account Relationship Manager Section -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Account Relationship Manager</h2>
                </div>
                <div class="section-details">
                    <div class="detail-item">
                        <span class="detail-label">Name</span>
                        <span class="detail-value"><?php echo htmlspecialchars($user['relationship_manager']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="tel:+2347043527649" class="action-btn call-btn">
                    <i class="fas fa-phone"></i> Call
                </a>
                <a href="https://wa.me/2347043527649" class="action-btn group-btn">
                    <i class="fas fa-users"></i> Group
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
   <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>


</body>
</html>