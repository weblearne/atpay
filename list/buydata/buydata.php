<?php
session_start();
// Redirect if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];

// Get data from POST (form submission)
$network = isset($_POST['network']) ? htmlspecialchars($_POST['network']) : '';
$plan    = isset($_POST['plan']) ? htmlspecialchars($_POST['plan']) : '';
$planid    = isset($_POST['plan_id']) ? htmlspecialchars($_POST['plan_id']) : '';
$price   = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$phone   = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';

// Validate required fields
// if (empty($network) || empty($plan) || empty($phone) || $price <= 0) {
//     header("Location: buydata.php");
//     exit();
// }

// Map networks to logo images (assuming they are in an 'images' folder)
$network_images = [
    'MTN'     => 'mtn.png',
    'GLO'     => 'glo.png',
    '9MOBILE' => '9mobile.png',
    'AIRTEL'  => 'airtel.jpg'
];
$network_image = $network_images[$network] ?? 'images/default_logo.png';

// You can now use the variables below in your HTML:
// $network, $plan, $price, $phone, $network_image
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNG DATA API - Buy Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="buydata.css">
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="LOGO.JPG" alt="mng data logo" style="width: clamp(32px, 8vw, 40px); height: clamp(32px, 8vw, 40px); border-radius: 50px;">
            <div class="logo-text"><a href="user.php" class="logo-text">MNG DATA API</a></div>
        </div>
    </div>

    <main class="main-content">
        <div class="buy-data-section">
            <h2 class="section-title">Buy Data - <?= htmlspecialchars($network) ?></h2>
            <img src="<?= htmlspecialchars($network_image) ?>" alt="<?= htmlspecialchars($network) ?> logo" class="service-image">
            <div class="plan-details">
                <div class="plan-name"><?= htmlspecialchars($plan) ?></div>
                <div class="plan-price">₦<?= number_format($price, 2) ?></div>
            </div>
       <form action="process_buydata.php" method="POST">
  <input type="hidden" name="network" value="<?= isset($network) ? htmlspecialchars($network) : '' ?>">
  <input type="hidden" name="plan" value="<?= isset($plan) ? htmlspecialchars($plan) : '' ?>">
  <input type="hidden" name="price" value="<?= isset($price) ? htmlspecialchars($price) : '' ?>">
  <input type="hidden" name="planid" value="<?= isset($planid) ? htmlspecialchars($planid) : '' ?>">

  <div class="form-group">
    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" class="form-input" placeholder="Enter phone number" pattern="[0-9]{11}" required>
  </div>

  <button type="submit" class="submit-btn">Purchase Data</button>
</form>

        </div>
    </main>

    <footer>
        © 2025 MNG DATA API.|| Powered by SKAN FIN TECH SERVICES. All rights reserved.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('buyDataForm');
            form.addEventListener('submit', (e) => {
                const phoneInput = document.getElementById('phone');
                const phoneRegex = /^[0-9]{11}$/;
                if (!phoneRegex.test(phoneInput.value)) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Invalid Phone Number',
                        text: 'Please enter a valid 11-digit phone number.',
                        icon: 'error',
                        confirmButtonColor: '#2563eb'
                    });
                }
            });
        });
    </script>
</body>
</html>