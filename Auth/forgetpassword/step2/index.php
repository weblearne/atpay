<?php
// session_start();
$resetMessage = "";
$messageClass = "";

// if (!isset($_SESSION['phone'])) {
//     header("Location: ../");
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp'] ?? '');
    $newPassword = trim($_POST['newPassword'] ?? '');
    $confirmPassword = trim($_POST['confirmPassword'] ?? '');

    if (empty($otp) || empty($newPassword) || empty($confirmPassword)) {
        $resetMessage = "Please fill in all fields.";
        $messageClass = "error";
    } elseif ($otp != $_SESSION['otp']) {
        $resetMessage = "Invalid OTP.";
        $messageClass = "error";
    } elseif (strlen($newPassword) < 4) {
        $resetMessage = "Password must be at least 4 characters.";
        $messageClass = "error";
    } elseif ($newPassword !== $confirmPassword) {
        $resetMessage = "Passwords do not match.";
        $messageClass = "error";
    } else {
        // Simulate password reset
        unset($_SESSION['otp']);
        unset($_SESSION['phone']);
        $resetMessage = "Password reset successful! Redirecting to login...";
        $messageClass = "success";
        header("refresh:2;url=../../login");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>atPay Wallet Reset Password</title>
<link rel="stylesheet" href="index.css">
</head>
<body>
<?php include '../../include/navbar.php'?>

    <div class="main-container">
        <div class="login-container">
            <div class="logo">
                <img src="../../../images/logo.png" alt="atPay Wallet Logo">
            </div>
            <h2>Reset Password</h2>

            <?php if ($resetMessage): ?>
                <div class="message <?php echo $messageClass; ?>"><?php echo $resetMessage; ?></div>
            <?php endif; ?>

            <form id="resetForm" method="POST" action="#">
                <div class="form-group">
                    <label for="otp">OTP</label>
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required>
                </div>
                <button type="submit">Proceed</button>
            </form>
            <div class="login-link">Need to register? <a href="../../register">Register</a></div>
        </div>
    </div>

   <?php include '../../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>
    <script>
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const otp = document.getElementById('otp').value.trim();
            const newPassword = document.getElementById('newPassword').value.trim();
            const confirmPassword = document.getElementById('confirmPassword').value.trim();

            if (newPassword.length < 4) {
                const messageContainer = document.querySelector('.message');
                if (messageContainer) messageContainer.remove();
                document.querySelector('.login-container').insertAdjacentHTML('afterbegin', '<div class="message error">Password must be at least 4 characters.</div>');
                return;
            }
            if (newPassword !== confirmPassword) {
                const messageContainer = document.querySelector('.message');
                if (messageContainer) messageContainer.remove();
                document.querySelector('.login-container').insertAdjacentHTML('afterbegin', '<div class="message error">Passwords do not match.</div>');
                return;
            }
            this.submit();
        });
    </script>
</body>
</html>