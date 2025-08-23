<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['atpay_auth_token_key'])) {
    header("Location: ../../../Auth/login/");
    exit();
}
$user = $_SESSION['user'];

// ✅ Get POST data
$network   = $_POST['network']   ?? '';
$networkid = $_POST['networkid'] ?? '';
$plan      = $_POST['PlanName']      ?? '';
$planid    = $_POST['planId']    ?? '';
// $price     = $_POST['price']     ?? '';
$price = is_numeric($_POST['price'] ?? '') ? (float)$_POST['price'] : 0;

// $price = is_numeric($price) ? (float)$price : 0;

$networks = [
    1 => "MTN",
    2 => "Glo",
    3 => "9mobile",
    4 => "Airtel"
];

// Default to empty if ID not found
$networkName = $networks[$networkid] ?? '';




// ✅ Network logos
$network_images = [
    'MTN'     => 'mtn.png',
    'Glo'     => 'glo.png',
    '9mobile' => '9mobile.png',
    'Airtel'  => 'airtel.jpg'
];

// ✅ Make network uppercase and safe
$network_key = strtoupper(trim((string)$network));
$network_image = isset($network_images[$networkName]) ? $network_images[$networkName] : 'mtn';





?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>atPay - Buy Data</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="index.css">
      <link rel="icon" type="image/png" href="../../../images/logo.png">

</head>
<body>
  <?php include "../../../include/user_top_navbar.php"; ?>
  <main class="main-content">
    <div class="buy-data-section">
      <h2 class="section-title">Buy Data - <?= htmlspecialchars($networkName) ?></h2>
      <img src="<?= htmlspecialchars($network_image) ?>" alt="<?= htmlspecialchars($networkName) ?> logo" class="service-image">

      <?php if (!empty($message)): ?>
      <div class="message <?= $status === 'success' ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
      <?php endif; ?>

      <div class="plan-card">
<center>        <div class="plan-name"><?= htmlspecialchars($plan) ?></div></center>
        <center>
          <div class="plan-price">₦<?= number_format($price, 2) ?></div>
        </center>


  
        <!-- ✅ Added form id -->
        <form id="buyDataForm" method="post" action="process_buydata/">
            <input type="hidden" name="buyDataForm" value="encrypted">
          <input type="hidden" name="networkid" value="<?= htmlspecialchars($networkid) ?>">
          <input type="hidden" name="planid" value="<?= htmlspecialchars($planid) ?>">
          <input type="hidden" name="price" value="<?= htmlspecialchars($price) ?>">
 
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="number" id="phone"  name="phone" class="form-input" placeholder="Enter phone number" required 
  oninput="if(this.value.length > 11) this.value = this.value.slice(0,11);">
          </div>

          <button type="submit" class="btn">Purchase Data</button>
        </form>
      </div>
    </div>
  </main>

  <footer>
    © 2025 atPay || Powered by SKAN FIN TECH SERVICES. All rights reserved.
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

      // ✅ SweetAlert on API response
      <?php if (!empty($message)): ?>
        Swal.fire({
          title: "<?= $status === 'success' ? ' Purchase Successful!' : ' Purchase Failed!' ?>",
          html: `
            <p><strong>Plan:</strong> <?= htmlspecialchars($plan) ?></p>
            <p><strong>Number:</strong> <?= htmlspecialchars($phone) ?></p>
            <p><strong>Message:</strong> <?= htmlspecialchars($message) ?></p>
          `,
          icon: "<?= $status === 'success' ? 'success' : 'error' ?>",
          confirmButtonText: "OK"
        });
      <?php endif; ?>
    });
  </script>
</body>
</html>
