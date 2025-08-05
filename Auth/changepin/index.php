<?php
session_start();
$resetMessage = "";
$messageClass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPin = trim($_POST['currentPin'] ?? '');
    $newPin = trim($_POST['newPin'] ?? '');

    if (empty($currentPin) || empty($newPin)) {
        $resetMessage = "Please enter both current and new PIN.";
        $messageClass = "error";
    } elseif (!preg_match('/^\d{4}$/', $currentPin) || !preg_match('/^\d{4}$/', $newPin)) {
        $resetMessage = "PIN must be exactly 4 digits.";
        $messageClass = "error";
    } else {
        // Simulate checking current PIN (replace with actual database check)
        $validPins = ['1234', '5678', '9012']; // Example valid PINs
        if (in_array($currentPin, $validPins)) {
            // Simulate updating PIN (replace with actual database update)
            $_SESSION['transactionPin'] = $newPin;
            $resetMessage = "Transaction PIN updated successfully.";
            $messageClass = "success";
            // Redirect to login after 2 seconds
            header("refresh:2;url=../../user/acc_man");
        } else {
            $resetMessage = "Current PIN is incorrect.";
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
    <title>Change Transaction PIN</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="index.css">
</head>
<body>
    <?php include '../include/navbar.php'?>
    <div class="main-container">
        <div class="login-container">
            <div class="logo">
                <img src="../../images/logo.png" alt="atPay Wallet Logo">
            </div>
            <h2>Change Transaction PIN</h2>
            <p style="text-align: center; color: var(--text-color); margin-bottom: 25px; font-size: 16px;">
                Enter your current and new transaction PIN below to update.
            </p>

            <?php if ($resetMessage): ?>
                <div class="message <?php echo $messageClass; ?>"><?php echo $resetMessage; ?></div>
            <?php endif; ?>

            <form method="POST" id="resetPinForm">
                <div class="form-group">
                    <label for="currentPin">Current PIN</label>
                    <input type="password" id="currentPin" name="currentPin" placeholder="Enter your current PIN" required pattern="\d{4}" maxlength="4">
                </div>
                <div class="form-group">
                    <label for="newPin">New PIN</label>
                    <input type="password" id="newPin" name="newPin" placeholder="Enter your new PIN" required pattern="\d{4}" maxlength="4">
                </div>
                <button type="submit">Proceed</button>
            </form>
            <div class="login-link">Remember your PIN? <a href="../login">Login</a></div>
        </div>
    </div>

    <?php include '../../include/app_settings.php'; ?>
    <footer style="text-align: center; font-size: 14px; color: var(--secondary-color); background-color: var(--primary-color); padding: 20px 0;">
        <?php echo APP_NAME_FOOTER; ?>
    </footer>

    <script>
        document.getElementById('resetPinForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const currentPin = document.getElementById('currentPin').value.trim();
            const newPin = document.getElementById('newPin').value.trim();

            if (!/^\d{4}$/.test(currentPin) || !/^\d{4}$/.test(newPin)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid PIN',
                    text: 'PIN must be exactly 4 digits.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            if (currentPin === newPin) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid PIN',
                    text: 'New PIN cannot be the same as the current PIN.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            this.submit();
        });
    </script>
</body>
</html>