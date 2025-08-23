<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management - atPay</title>
           <link rel="icon" type="image/png" href="../../images/logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
       <?php include '../../include/user_top_navbar.php';?>
<br>
        <!-- Account Management Section -->
        <div class="account-section">
            <h2 class="section-title">Manage Your Account</h2>
            <ul class="account-options">
                <li class="option-item" onclick="window.location.href='../../Auth/forgetpassword'">
                    <i class="fas fa-lock option-icon"></i>
                    <span class="option-name">change password</span>
                </li>
                <li class="option-item" onclick="window.location.href='../../Auth/changepin'">
                    <i class="fas fa-shield-alt option-icon"></i>
                    <span class="option-name">change transaction pin</span>
                </li>
                <li class="option-item" onclick="window.location.href='#'">
                    <i class="fas fa-check-circle option-icon"></i>
                    <span class="option-name">account verification</span>
                </li>
                <li class="option-item" onclick="window.location.href='#'">
                    <i class="fas fa-file-invoice option-icon"></i>
                    <span class="option-name">account statement</span>
                </li>
                <li class="option-item" onclick="window.location.href='#'">
                    <i class="fas fa-money-bill-wave option-icon"></i>
                    <span class="option-name">account limit</span>
                </li>
                <li class="option-item" onclick="window.location.href='#'">
                    <i class="fas fa-trash option-icon"></i>
                    <span class="option-name">delete account</span>
                </li>
            </ul>
        </div>
    </div>

       <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>
</body>
</html>