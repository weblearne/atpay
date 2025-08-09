<?php
session_start();

$responseMessage = "";
$responseColor = "green";
$shouldRedirect = false; // Add flag for redirect control

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $PhoneNumber     = trim($_POST['PhoneNumber']);
    $Password        = trim($_POST['Password']);
    $ConfirmPassword = trim($_POST['ConfirmPassword']);
    $FullName        = trim($_POST['FullName']);
    $Email           = trim($_POST['Email']);
    $Referral        = trim($_POST['Referral']);

    // Basic validations
    if (!is_numeric($PhoneNumber) || strlen($PhoneNumber) !== 11) {
        $responseMessage = "Phone number must be exactly 11 digits!";
        $responseColor = "red";
    } elseif (strlen($Password) < 6) {
        $responseMessage = "Password must be at least 6 characters!";
        $responseColor = "red";
    } elseif ($Password !== $ConfirmPassword) {
        $responseMessage = "Password and confirm password do not match!";
        $responseColor = "red";
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $responseMessage = "Invalid email format!";
        $responseColor = "red";
    } elseif (empty($FullName)) {
        $responseMessage = "Full name is required!";
        $responseColor = "red";
    } else {
        // Prepare API data
        $data = json_encode([
            "PhoneNumber"     => $PhoneNumber,
            "Password"        => $Password,
            "ConfirmPassword" => $ConfirmPassword,
            "FullName"        => $FullName,
            "Email"           => $Email,
            "Referral"        => $Referral
        ]);

        $ch = curl_init('https://atpay.ng/authen/registerAuth.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        if (isset($response['error']) && $response['error'] === false) {
           $responseMessage = "Registration successful. Welcome, " . 
                   (isset($response['FullName']) ? htmlspecialchars($response['FullName']) : '') . "!";

            $responseColor = "green";
            $shouldRedirect = true; // Set flag instead of immediate redirect

            // Save session data if token is returned
            $_SESSION['user'] = $response;
            if (isset($response['token'])) {
                $_SESSION['atpay_auth_token_key'] = $response['token'];
            }

            // DON'T redirect immediately - let SweetAlert handle it
            // header("Location: ../login/");
            // exit();
        } else {
            $responseMessage = $response['message'] ?? "Registration failed!";
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
    <title>atPay Wallet Register</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <div class="main-container">
        <div class="login-container">
            <div class="logo">
                <img src="../../images/logo.png" alt="atPay Wallet Logo">
            </div>
            <h2>Register</h2>

            <div id="messageContainer"></div>
            <!-- Remove or comment out the PHP message display since we're using SweetAlert -->
            <!-- <p style="color:<?= $responseColor; ?>"><?= $responseMessage; ?></p> -->

            <form id="registerForm" method="POST" action="#">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="FullName" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="Email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="PhoneNumber" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="Password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="ConfirmPassword" placeholder="Confirm your password" required>
                </div>
                <div class="form-group">
                    <label for="referral">Referral (Optional)</label>
                    <input type="text" id="referral" name="Referral" placeholder="Referral">
                </div>
                <button type="submit">Register</button>
                <div class="login-link">Already have an account? <a href="../login/">Login</a></div>
            </form>
        </div>
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
                        window.location.href = '../login/';
                    <?php endif; ?>
                    return;
                }

                <?php if ($shouldRedirect): ?>
                    // Success case - auto redirect after showing success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
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
                        console.log('Auto-redirecting to login page');
                        window.location.href = '../login/';
                    });
                <?php else: ?>
                    // Error case - require user interaction
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '<?= addslashes($responseMessage) ?>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                <?php endif; ?>
            });
        <?php endif; ?>

        // Optional: Add form submission loading state
        document.getElementById('registerForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.textContent = 'Registering...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>