<?php
session_start();

$responseMessage = '';
$responseColor = 'error'; // default for SweetAlert

if (!isset($_SESSION['reset_phone'])) {
    header("Location: ../step1/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $OTP            = trim($_POST['OTP']);
    $NewPassword    = trim($_POST['NewPassword']);
    $ConfirmPassword= trim($_POST['ConfirmPassword']);

    if ($OTP === '' || $NewPassword === '' || $ConfirmPassword === '') {
        $responseMessage = "All fields are required!";
    } elseif ($NewPassword !== $ConfirmPassword) {
        $responseMessage = "Passwords do not match!";
    } else {
        $payload = json_encode([
            "PhoneNumber" => $_SESSION['reset_phone'],
            "Password"    => $NewPassword,
            "Cpassword"   => $ConfirmPassword,
            "Otp"         => $OTP
        ]);

        $ch = curl_init("https://atpay.ng/authen/changePassword.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            $responseMessage = "Connection error: " . curl_error($ch);
        } else {
            $apiResponse = json_decode($result, true);

            // Debug line (uncomment if you want to see raw API reply)
            // var_dump($apiResponse);

            if (isset($apiResponse['error']) && $apiResponse['error'] === false) {
                $responseMessage = "Password reset successful!";
                $responseColor = 'success';
                unset($_SESSION['reset_phone']);
                echo "<script>
                    setTimeout(function(){
                        window.location.href='../../../Auth/login/';
                    }, 2000);
                </script>";
            } else {
                $responseMessage = $apiResponse['message'] ?? "Failed to reset password!";
            }
        }
        curl_close($ch);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>atPay Wallet Reset Password</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="index.css">
      <link rel="icon" type="image/png" href="../../../../images/logo.png">

</head>
<body>
<?php include '../../include/navbar.php'; ?>

<div class="main-container">
    <div class="login-container">
        <div class="logo">
            <img src="../../../images/logo.png" alt="atPay Wallet Logo">
        </div>
        <h2>Reset Password</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="otp">OTP</label>
                <input type="text" id="otp" name="OTP" placeholder="Enter OTP" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="NewPassword" placeholder="Enter new password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="ConfirmPassword" placeholder="Confirm new password" required>
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

<?php if ($responseMessage): ?>
<script>
Swal.fire({
    icon: '<?php echo $responseColor; ?>',
    text: '<?php echo $responseMessage; ?>',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>
</body>
</html>
