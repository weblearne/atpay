<?php
session_start();

$loginMessage = "";
$responseMessage = "";
$responseColor = "red";
$shouldRedirect = false; // Add flag for redirect control

// Check if user is already logged in
if (isset($_SESSION['atpay_auth_token_key'])) {
    echo "<p style='color:red;'>Unauthorized: Please log in first.</p>";
    header("Location: login/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $PhoneNumber = trim($_POST['PhoneNumber']);
    $Password = trim($_POST['Password']);

    if (!is_numeric($PhoneNumber) || strlen($PhoneNumber) !== 11) {
        $responseMessage = "Phone number must be 11 digits!";
    } elseif (strlen($Password) < 6) {
        $responseMessage = "Password must be at least 6 characters!";
    } else {
        // Prepare data for API
        $data = json_encode([
            "PhoneNumber" => $PhoneNumber,
            "Password" => $Password
        ]);

        $ch = curl_init('https://atpay.ng/authen/loginAuth.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        if (isset($response['error']) && $response['error'] === false) {
            $responseMessage = "Login successful. Welcome, " . htmlspecialchars($response['Name']) . "!";
            $responseColor = "green";
            $shouldRedirect = true; // Set flag instead of immediate redirect

            // Save user data and token in session
            $_SESSION['user'] = $response; // Save full user data
            if (isset($response['token'])) {
                $_SESSION['atpay_auth_token_key'] = $response['token']; // Save token separately
            }

            // DON'T redirect immediately - let SweetAlert handle it
            // header("Location: ../../user/");
            // exit();
        } else {
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
        <a href="#" class="forgot-password">Forgot password?</a>
      </div>
      <button type="submit">Login</button>
      <div class="signup-link" style="text-align:center; margin-top: 10px;">Don't have an account? <a href="../register/">Sign up</a></div>
      <div class="signup-link" style="text-align:center; margin-top: 10px; font-size:15px;">Forget Your Password? <a href="../forgetpassword/">click here to reset</a></div>
    </form>
  </div>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <script>
    // Display SweetAlert2 based on PHP response
    <?php if (!empty($responseMessage)): ?>
      document.addEventListener('DOMContentLoaded', function() {
        console.log('SweetAlert2 triggered with message: <?= addslashes($responseMessage) ?>');
        
        // Check if SweetAlert2 is loaded
        if (typeof Swal === 'undefined') {
          console.error('SweetAlert2 is not loaded!');
          alert('<?= addslashes($responseMessage) ?>'); // Fallback to regular alert
          <?php if ($shouldRedirect): ?>
            window.location.href = '../../user/';
          <?php endif; ?>
          return;
        }

        <?php if ($shouldRedirect): ?>
          // Success case - auto redirect after showing success message
          Swal.fire({
            icon: 'success',
            title: 'Login Successful!',
            text: '<?= addslashes($responseMessage) ?>',
            timer: 2000, // Auto close after 2 seconds
            timerProgressBar: true,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
              // Optional: Add countdown in the title
              let timerInterval;
              const timer = Swal.getPopup().querySelector('b');
              timerInterval = setInterval(() => {
                const timerLeft = Swal.getTimerLeft();
                if (timer) {
                  timer.textContent = Math.ceil(timerLeft / 1000);
                }
              }, 100);
            }
          }).then(() => {
            console.log('Auto-redirecting to user dashboard');
            window.location.href = '../../user/';
          });
        <?php else: ?>
          // Error case - require user interaction
          Swal.fire({
            icon: 'error',
            title: 'Login Failed!',
            text: '<?= addslashes($responseMessage) ?>',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            allowEscapeKey: false
          });
        <?php endif; ?>
      });
    <?php endif; ?>

    // Add form submission loading state
    document.getElementById('loginForm').addEventListener('submit', function() {
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Logging in...';
      submitBtn.disabled = true;
      
      // Re-enable button after 5 seconds as fallback (in case of network issues)
      setTimeout(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }, 5000);
    });

    // Optional: Add client-side validation with SweetAlert
    function validateForm() {
      const phone = document.getElementById('phone').value.trim();
      const password = document.getElementById('password').value.trim();

      if (phone === '' || password === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Missing Information',
          text: 'Please fill in all fields.',
          confirmButtonText: 'OK'
        });
        return false;
      }

      if (!/^\d{11}$/.test(phone)) {
        Swal.fire({
          icon: 'warning',
          title: 'Invalid Phone Number',
          text: 'Phone number must be exactly 11 digits.',
          confirmButtonText: 'OK'
        });
        return false;
      }

      if (password.length < 6) {
        Swal.fire({
          icon: 'warning',
          title: 'Invalid Password',
          text: 'Password must be at least 6 characters.',
          confirmButtonText: 'OK'
        });
        return false;
      }

      return true;
    }

    // Attach validation to form submission
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      if (!validateForm()) {
        e.preventDefault();
        // Re-enable the submit button if validation fails
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.textContent = 'Login';
        submitBtn.disabled = false;
      }
    });
  </script>
</body>
</html>