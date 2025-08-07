<?php
// $loginMessage = "";
// $messageClass = "";

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $phone = trim($_POST['phone'] ?? '');
//     $password = trim($_POST['password'] ?? '');

//     // Basic PHP validation
//     if (empty($phone) || empty($password)) {
//         $loginMessage = "Please fill in all fields.";
//         $messageClass = "error";
//     } elseif (!preg_match('/^\d{3,}$/', $phone)) {
//         $loginMessage = "Phone number must be at least 3 digits.";
//         $messageClass = "error";
//     } elseif (strlen($password) < 4) {
//         $loginMessage = "Password must be at least 4 characters.";
//         $messageClass = "error";
//     } else {
//         // Hardcoded credentials
//         $validPhone = '000';
//         $validPassword = '0000';

//         if ($phone === $validPhone && $password === $validPassword) {
//             $loginMessage = "Welcome, login successful!";
//             $messageClass = "success";
      
//             header("Location:../../user/");
//             exit;
//         } else {
//             $loginMessage = "Invalid phone number or password.";
//             $messageClass = "error";
//         }
//     }
// }


// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://atpay.ng/authen/loginAuth.php',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS => json_encode([
//       "PhoneNumber" => "00000000000",
//       "Password" => "000000"
//   ]),
//   CURLOPT_HTTPHEADER => array(
//     'Content-Type: application/json',
//     'User-Agent: Mozilla/5.0'
//   ),
// ));

// $response = curl_exec($curl);

// if(curl_errno($curl)){
//     echo 'Request Error:' . curl_error($curl);
// }

// curl_close($curl);
// echo $response;


// session_start();

// Replace with actual login input if using a form
// $phone = '00000000000';
// $password = '000000';

// // Initialize cURL
// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://atpay.ng/authen/loginAuth.php',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS => json_encode([
//       "PhoneNumber" => $phone,
//       "Password" => $password
//   ]),
//   CURLOPT_HTTPHEADER => array(
//     'Content-Type: application/json',
//     'User-Agent: Mozilla/5.0'
//   ),
// ));

// // Execute the request
// $response = curl_exec($curl);

// // Check for errors
// if(curl_errno($curl)){
//     echo 'Request Error: ' . curl_error($curl);
//     curl_close($curl);
//     exit;
// }

// curl_close($curl);

// // Decode JSON response
// $data = json_decode($response, true);

// // Optional: Uncomment to see raw response
// // echo "<pre>"; print_r($data); echo "</pre>";

// // Check if login is successful
// if ($data && isset($data['AthuKey'])) {
//     // Save user data in session
//     $_SESSION['AthuKey'] = $data['AthuKey'];
//     $_SESSION['UserName'] = $data['Name'];
//     $_SESSION['Mobile'] = $data['Mobile'];
//     $_SESSION['Email'] = $data['Email'];
//     $_SESSION['Balance'] = $data['Balance'];
//     $_SESSION['JoinDate'] = $data['JoinDate'];
//     $_SESSION['LastLogin'] = $data['Lastlog'];

//     // Redirect to user dashboard
//     header("Location: ../../user/");
//     exit;
// } else {
//     // Login failed
//     echo "Login failed. Response: <br>";
//     echo "<pre>" . htmlspecialchars($response) . "</pre>";
// }
$loginMessage = "";
$responseMessage = "";
$responseColor = "green";

if (isset($_SESSION['user'])) {
    echo "<p style='color:red;'>Unauthorized: Please log in first.</p>";
    header("Location: user.php");
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $PhoneNumber = trim($_POST['PhoneNumber']);
    $Password = trim($_POST['Password']);

    if (!is_numeric($PhoneNumber) || strlen($PhoneNumber) !== 11) {
        $responseMessage = "Phone number must be 11 digits!";
    } elseif (strlen($Password) < 6 ) {
        $responseMessage = "Password must be at least 6 characters!";
    } else {
        // Prepare data for API
        $data = json_encode([
            "PhoneNumber" => $PhoneNumber,
            "Password" => $Password
        ]);

        $ch = curl_init('https://atpay.ng/authen/loginAuth.php'); // Change to your actual API URL
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

            // Optionally redirect or store session info
            session_start();
            $_SESSION['user'] = $response;
            header("Location: ../../user/");
        } else {
            $responseMessage = $response['message'] ?? "Login failed!";
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

    <?php if ( $responseMessage): ?>
      <center><div style="color:red;" class="message <?php echo $responseColor; ?>"><?php echo  $responseMessage; ?></div></center>
    <?php endif; ?>

    <form id="loginForm" method="POST" action="#">
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="PhoneNumber" placeholder="Enter your phone number">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="Password" placeholder="Enter your password">
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