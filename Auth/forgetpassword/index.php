<?php
session_start();
$resetMessage = "";
$messageClass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone'] ?? '');

    if (empty($phone)) {
        $resetMessage = "Please enter your phone number.";
        $messageClass = "error";
    } elseif (!preg_match('/^\d{3,}$/', $phone)) {
        $resetMessage = "Phone number must be at least 3 digits.";
        $messageClass = "error";
    } else {
        // Simulate checking if phone is registered
        $validPhones = ['123', '456', '789'];
        if (in_array($phone, $validPhones)) {
            // Generate OTP (for demo purposes)
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['phone'] = $phone;

            // Simulate sending OTP to email (replace with actual email service)
            $resetMessage = "OTP has been sent to your registered email. Redirecting...";
            $messageClass = "success";

            // Redirect to OTP page after 2 seconds
            header("refresh:2;url=step2");
            exit;
        } else {
            $resetMessage = "Phone number not registered.";
            $messageClass = "error";
        }
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
   
<?php include '../include/navbar.php'?>
    <div class="main-container">
        <div class="login-container">
            <div class="logo">
                <img src="../../images/logo.png" alt="atPay Wallet Logo">
            </div>
            <h2>Reset Password</h2>

            <?php if ($resetMessage): ?>
                <div class="message <?php echo $messageClass; ?>"><?php echo $resetMessage; ?></div>
            <?php endif; ?>

            <form id="resetForm" method="POST">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <button type="submit">Proceed</button>
            </form>
            <div class="login-link">Remember your password? <a href="../login">Login</a></div>
        </div>
    </div>

       <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>
    <script>
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const phone = document.getElementById('phone').value.trim();
            if (!/^\d{3,}$/.test(phone)) {
                const messageContainer = document.querySelector('.message');
                if (messageContainer) messageContainer.remove();
                document.querySelector('.login-container').insertAdjacentHTML('afterbegin', '<div class="message error">Phone number must be at least 3 digits.</div>');
                return;
            }
            this.submit();
        });
    </script>
</body>
</html>