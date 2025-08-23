<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance - atPay</title>
<link rel="stylesheet" href="index.css">
      <link rel="icon" type="image/png" href="../../images/logo.png">

</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <?php include '../../include/user_top_navbar.php';?>
        <br>
        <!-- Balance Section -->
        <div class="balance-section">
            <h2 class="section-title">Balance</h2>
            <p class="subtitle">Simple way to check you data, airtime balance</p>
            <ul class="balance-options">
                <li class="balance-item" onclick="window.location.href='tel:*310#'">
                    <span class="icon">📞</span>
                    <span class="text">Account Balance</span>
                    <span class="code">Code: *310#</span>
                    <span class="call-icon">📞</span>
                </li>
                <li class="balance-item" onclick="window.location.href='tel:*323#'">
                    <span class="icon">📞</span>
                    <span class="text">Data Balance</span>
                    <span class="code">Code: *323#</span>
                    <span class="call-icon">📞</span>
                </li>
                <li class="balance-item" onclick="window.location.href='tel:*312#'">
                    <span class="icon">📞</span>
                    <span class="text">Data Plans</span>
                    <span class="code">Code: *312#</span>
                    <span class="call-icon">📞</span>
                </li>
                <li class="balance-item" onclick="window.location.href='tel:*321#'">
                    <span class="icon">📞</span>
                    <span class="text">Share Services</span>
                    <span class="code">Code: *321#</span>
                    <span class="call-icon">📞</span>
                </li>
                <li class="balance-item" onclick="window.location.href='tel:*303#'">
                    <span class="icon">📞</span>
                    <span class="text">Borrowing Services</span>
                    <span class="code">Code: *303#</span>
                    <span class="call-icon">📞</span>
                </li>
                <li class="balance-item" onclick="window.location.href='tel:*996#'">
                    <span class="icon">📞</span>
                    <span class="text">NIN</span>
                    <span class="code">Code: *996#</span>
                    <span class="call-icon">📞</span>
                </li>
                <li class="balance-item" onclick="window.location.href='tel:*305#'">
                    <span class="icon">📞</span>
                    <span class="text">VAS</span>
                    <span class="code">Code: *305#</span>
                    <span class="call-icon">📞</span>
                </li>
            </ul>
        </div>
    </div>

    <?php include '../../include/app_settings.php'; ?>
    <footer style="text-align: center; font-size: 14px; color: var(--secondary-color); background-color: var(--primary-color); padding: 20px 0;">
        <?php echo APP_NAME_FOOTER; ?>
    </footer>
</body>
</html>