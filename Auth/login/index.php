<?php
$loginMessage = "";
$messageClass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Basic PHP validation
    if (empty($phone) || empty($password)) {
        $loginMessage = "Please fill in all fields.";
        $messageClass = "error";
    } elseif (!preg_match('/^\d{3,}$/', $phone)) {
        $loginMessage = "Phone number must be at least 3 digits.";
        $messageClass = "error";
    } elseif (strlen($password) < 4) {
        $loginMessage = "Password must be at least 4 characters.";
        $messageClass = "error";
    } else {
        // Hardcoded credentials
        $validPhone = '000';
        $validPassword = '0000';

        if ($phone === $validPhone && $password === $validPassword) {
            $loginMessage = "Welcome, login successful!";
            $messageClass = "success";
      
            header("Location:../../user/");
            exit;
        } else {
            $loginMessage = "Invalid phone number or password.";
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
  <title>atPay Wallet Login</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <!-- <nav class="top-nav">
    <div class="nav-brand">atPay Wallet</div>
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav> -->
  <!--?php include '../include/navbar.php'?-->

  <div class="login-container">
    <div class="logo" style="text-align:center;">
      <img src="../../images/logo.png" alt="atPay Wallet Logo" style="margin-bottom: 15px;">
    </div>
    <h2 style="text-align:center;">Login</h2>

    <?php if ($loginMessage): ?>
      <center><div style="color:red;" class="message <?php echo $messageClass; ?>"><?php echo $loginMessage; ?></div></center>
    <?php endif; ?>

    <form id="loginForm" method="POST" action="#">
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password">
        <a href="#" class="forgot-password">Forgot password?</a>
      </div>
      <button type="submit">Login</button>
      <div class="signup-link" style="text-align:center; margin-top: 10px;">Don't have an account? <a href="../register/">Sign up</a></div>
      <div class="signup-link" style="text-align:center; margin-top: 10px; font-size:15px;">Forget Your Password? <a href="../forgetpassword/">click here to reset</a></div>
    </form>
  </div>
 
   
  <script>
    // function validateForm() {
    //   const phone = document.getElementById('phone').value.trim();
    //   const password = document.getElementById('password').value.trim();

    //   if (phone === '' || password === '') {
    //     alert('Please fill in all fields.');
    //     return false;
    //   }

    //   if (!/^\d{3,}$/.test(phone)) {
    //     alert('Phone number must be at least 3 digits and contain only numbers.');
    //     return false;
    //   }

    //   if (password.length < 4) {
    //     alert('Password must be at least 4 characters.');
    //     return false;
    //   }

    //   return true;
    // }
  </script>

</body>
</html>