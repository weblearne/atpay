<?php
session_start();

$loginMessage = "";
$responseMessage = "";
$responseColor = "red";
$shouldRedirect = false; // Flag for redirect control

// Check if user is already logged in
if (isset($_SESSION['atpay_auth_token_key'])) {
    // If already logged in, go to user dashboard
    header("Location: ../../user/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $PhoneNumber = trim($_POST['PhoneNumber']);
    $Password = trim($_POST['Password']);

    // Basic validation
    if (!is_numeric($PhoneNumber) || strlen($PhoneNumber) !== 11) {
        $responseMessage = "Phone number must be exactly 11 digits!";
    } elseif (strlen($Password) < 6) {
        $responseMessage = "Password must be at least 6 characters!";
    } else {
        // Prepare data for API
        $data = json_encode([
            "PhoneNumber" => $PhoneNumber,
            "Password" => $Password
        ]);

        // Call the API
        $ch = curl_init('https://atpay.ng/authen/loginAuth.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

        // Decode API response
        $response = json_decode($result, true);

        if (isset($response['error']) && $response['error'] === false) {
            // Success
            $responseMessage = "Login successful. Welcome, " . htmlspecialchars($response['Name']) . "!";
            $responseColor = "green";
            $shouldRedirect = true; // Let JavaScript handle redirect

            // Save user data and token in session
            $_SESSION['user'] = $response;
            if (isset($response['AthuKey'])) {
                $_SESSION['atpay_auth_token_key'] = $response['AthuKey']?? "";
                $_SESSION['balance'] = $response['Balance']?? "";
                $_SESSION['Bonus'] = $response['Bonus']?? "";
                $_SESSION['account_number'] = "";
                $_SESSION['account_name'] = "";
                $_SESSION['bank_name'] = "";

                $_SESSION['user_type'] = "";
                $_SESSION['user_status'] = "";
                $_SESSION['JoinDate'] = $response['JoinDate'] ?? "";
                $_SESSION['Lastlog'] = $response['Lastlog'] ?? "";

               
            }
        } else {
            // Error from API
            $responseMessage = $response['message'] ?? "Login failed!";
            $responseColor = "red";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>atPay Wallet Login</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body>
  <div class="login-container">
    <div class="logo" style="text-align:center;">
      <img src="../../images/logo.png" alt="atPay Wallet Logo" style="margin-bottom: 15px;">
    </div>
    <h2 style="text-align:center;">Login</h2>

    <!-- Remove or comment out the PHP message display since we're using SweetAlert -->
    <?php /* if ($responseMessage): ?>
      <center><div style="color:red;" class="message <?php echo $responseColor; ?>"><?php echo $responseMessage; ?></div></center>
    <?php endif; */ ?>

    <form id="loginForm" method="POST" action="#">
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="PhoneNumber" placeholder="Enter your phone number" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="Password" placeholder="Enter your password" required>
        <a href="../forgetpassword/" class="forgot-password">Forgot password?</a>
      </div>
      <button type="submit">Login</button>
      <div class="signup-link" style="text-align:center; margin-top: 10px;">Don't have an account? <a href="../register/">Sign up</a></div>
      <div class="signup-link" style="text-align:center; margin-top: 10px; font-size:15px;">Forget Your Password? <a href="../forgetpassword/">click here to reset</a></div>
    </form>
  </div>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
 <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script>
    <?php if (!empty($responseMessage)): ?>
      document.addEventListener('DOMContentLoaded', function() {
        <?php if ($shouldRedirect): ?>
          Swal.fire({
            icon: 'success',
            title: 'Login Successful!',
            text: '<?= addslashes($responseMessage) ?>',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
          }).then(() => {
            window.location.href = '../../user/';
          });
        <?php else: ?>
          Swal.fire({
            icon: 'error',
            title: 'Login Failed!',
            text: '<?= addslashes($responseMessage) ?>',
            confirmButtonText: 'Try Again'
          });
        <?php endif; ?>
      });
    <?php endif; ?>

    document.getElementById('loginForm').addEventListener('submit', function() {
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Logging in...';
      submitBtn.disabled = true;

      setTimeout(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }, 5000);
    });
  </script>
</body>
</html>