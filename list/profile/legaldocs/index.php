<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legal Documents - atPay</title>
       <link rel="icon" type="image/png" href="../../../images/logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <?php include '../../../include/user_top_navbar.php';?>
        <br>
        <!-- Legal Documents Section -->
        <div class="legal-section">
            <h2 class="section-title">Legal Documents</h2>
            <ul class="legal-options">
                <li class="option-item" onclick="window.location.href='privacy&policy/'">
                    <i class="fas fa-user-shield option-icon"></i>
                    <span class="option-name">privacy policy</span>
                </li>
                <li class="option-item" onclick="window.location.href='terms&conditions/'">
                    <i class="fas fa-file-contract option-icon"></i>
                    <span class="option-name">terms and conditions</span>
                </li>
                <li class="option-item" onclick="window.location.href='#'">
                    <i class="fas fa-certificate option-icon"></i>
                    <span class="option-name">licenses and registrations</span>
                </li>
            </ul>
        </div>
    </div>

    <?php include '../../../include/app_settings.php'; ?>
    <footer style="text-align: center; font-size: 14px; color: var(--secondary-color); background-color: var(--primary-color); padding: 20px 0;">
        <?php echo APP_NAME_FOOTER; ?>
    </footer>
</body>
</html>