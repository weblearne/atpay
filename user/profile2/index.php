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
            justify-content: flex-start;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-radius: 12px;
            margin-bottom: 1.5rem;
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

        .profile-container {
            background: var(--secondary-color);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 2rem;
            text-align: center;
            flex: 1;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color);
            margin-bottom: 1rem;
        }

        .user-name {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .user-phone {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .section {
            background-color: var(--secondary-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .upgrade-btn {
            background-color: var(--accent-color);
            color: var(--secondary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
        }

        .upgrade-btn:hover {
            background-color: #4f46e5;
            transform: translateY(-1px);
        }

        .section-details {
            background-color: var(--alternate-bg);
            border-radius: 8px;
            padding: 1rem;
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }

        .detail-label {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .detail-value {
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1rem;
        }

        .action-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s;
            flex: 1;
            max-width: 200px;
            text-decoration: none;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .call-btn {
            background-color: var(--success-color);
        }

        .call-btn:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }

        .group-btn {
            background-color: var(--error-color);
        }

        .group-btn:hover {
            background-color: #dc2626;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 0.75rem;
            }

            .profile-container {
                padding: 1.5rem;
            }

            .profile-img {
                width: 100px;
                height: 100px;
            }

            .user-name {
                font-size: 1.5rem;
            }

            .section {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }

            .action-btn {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .profile-img {
                width: 80px;
                height: 80px;
            }

            .user-name {
                font-size: 1.25rem;
            }

            .user-phone {
                font-size: 0.875rem;
            }

            .section-title {
                font-size: 1rem;
            }

            .upgrade-btn {
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .section-details {
                font-size: 0.75rem;
            }
        }
    </style>
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
                <a href="tel:+1234567890" class="action-btn call-btn">
                    <i class="fas fa-phone"></i> Call
                </a>
                <a href="/group" class="action-btn group-btn">
                    <i class="fas fa-users"></i> Group
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <!--?php include '../../include/footer.php'; ?-->
</body>
</html>