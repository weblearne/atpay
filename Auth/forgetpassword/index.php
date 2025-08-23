<?php
session_start();
$responseMessage = "";
$responseType = ""; // 'success' or 'error'
$redirectUrl = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $PhoneNumber = trim($_POST['PhoneNumber']);

    if (!is_numeric($PhoneNumber) || strlen($PhoneNumber) !== 11) {
        $responseMessage = "Phone number must be 11 digits!";
        $responseType = "error";
    } else {
        $data = json_encode(["PhoneNumber" => $PhoneNumber]);

        $ch = curl_init('https://atpay.ng/authen/forgotPassword.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            $responseMessage = "Connection error: " . curl_error($ch);
            $responseType = "error";
        } else {
            $response = json_decode($result, true);
            if (isset($response['error']) && $response['error'] === false) {
                $_SESSION['reset_phone'] = $PhoneNumber;
                $responseMessage = $response['message'] ?? "OTP sent successfully!";
                $responseType = "success";
                $redirectUrl = "step2/";
            } else {
                $responseMessage = $response['message'] ?? "Failed to send OTP!";
                $responseType = "error";
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
      <link rel="icon" type="image/png" href="../../images/logo.png">
</head>
<body>
   
<?php include '../include/navbar.php'?>
    <div class="main-container">
        <div class="login-container">
            <div class="logo">
                <img src="../../images/logo.png" alt="atPay Wallet Logo">
            </div>
            <h2>Reset Password</h2>

       

            <form id="resetForm" method="POST">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="PhoneNumber" placeholder="Enter your phone number" required>
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
    <?php if ($responseMessage): ?>
    <script>
        Swal.fire({
            icon: '<?= $responseType ?>',
            title: '<?= ucfirst($responseType) ?>',
            text: '<?= $responseMessage ?>',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            <?php if ($redirectUrl): ?>
                window.location.href = '<?= $redirectUrl ?>';
            <?php endif; ?>
        });
    </script>
    <?php endif; ?>
</body>
</html>