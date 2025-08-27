<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['atpay_auth_token_key'])) {
    header("Location: ../../../Auth/login/");
    exit();
}
$user = $_SESSION['atpay_auth_token_key'];

// ✅ Get POST data
$network   = $_POST['network']   ?? '';
$networkid = $_POST['networkid'] ?? '';
$plan      = $_POST['PlanName']  ?? '';
$planid    = $_POST['planId']    ?? '';
$price     = is_numeric($_POST['price'] ?? '') ? (float)$_POST['price'] : 0;

// ✅ Map of network IDs to names
$networks = [
    1 => "MTN",
    2 => "Glo",
    3 => "9mobile",
    4 => "Airtel",
    "smile" => "Smile"
];

// Default to empty if ID not found
$networkName = $networks[$networkid] ?? 'Unknown';

// ✅ Network logos
$network_images = [
    'MTN'      => 'mtn.png',
    'Glo'      => 'glo.png',
    '9mobile'  => '9mobile.png',
    'Airtel'   => 'airtel.jpg',
    'Smile'    => 'smile.jpeg'
];

$network_image = $network_images[$networkName] ?? 'smile.jpeg';

// ✅ Change field labels dynamically
$fieldLabel   = ($networkid === "smile") ? "Smile Number" : "Phone Number";
$formAction   = ($networkid === "smile") ? "process_buysmile/" : "process_buydata/";
$buttonLabel  = ($networkid === "smile") ? "Purchase Smile Plan" : "Purchase Data";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>atPay - Buy <?= htmlspecialchars($networkName) ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="index.css">
  <link rel="icon" type="image/png" href="../../../images/logo.png">
</head>
<body>
  <?php include "../../../include/user_top_navbar.php"; ?>
  <main class="main-content">
    <div class="buy-data-section">
      <h2 class="section-title">Buy <?= htmlspecialchars($networkName) ?> Plan</h2>
      <img src="<?= htmlspecialchars($network_image) ?>" alt="<?= htmlspecialchars($networkName) ?> logo" class="service-image">

      <?php if (!empty($message)): ?>
      <div class="message <?= $status === 'success' ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
      <?php endif; ?>

      <div class="plan-card">
        <center><div class="plan-name"><?= htmlspecialchars($plan) ?></div></center>
        <center><div class="plan-price">₦<?= number_format($price, 2) ?></div></center>

        <!-- ✅ Dynamic form -->
        <form id="buyDataForm" method="post" action="<?= $formAction ?>">
          <input type="hidden" name="networkid" value="<?= htmlspecialchars($networkid) ?>">
          <input type="hidden" name="planid" value="<?= htmlspecialchars($planid) ?>">
          <input type="hidden" name="price" value="<?= htmlspecialchars($price) ?>">
          <input type="hidden" name="planName" value="<?= htmlspecialchars($plan) ?>">

          <div class="form-group">
            <label for="phone"><?= $fieldLabel ?></label>
            <input type="number" id="phone" name="phone" class="form-input" 
                   placeholder="Enter <?= strtolower($fieldLabel) ?>" required 
                   oninput="if(this.value.length > 10) this.value = this.value.slice(0,10);">
          </div>

          <button type="submit" class="btn"><?= $buttonLabel ?></button>
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
        const phoneRegex = /^[0-9]{10}$/;
        if (!phoneRegex.test(phoneInput.value)) {
          e.preventDefault();
          Swal.fire({
            title: 'Invalid <?= $fieldLabel ?>',
            text: 'Please enter a valid 9-digit number.',
            icon: 'error',
            confirmButtonColor: '#2563eb'
          });
        }
      });

      <?php if (!empty($message)): ?>
        Swal.fire({
          title: "<?= $status === 'success' ? 'Purchase Successful!' : 'Purchase Failed!' ?>",
          html: `
            <p><strong>Plan:</strong> <?= htmlspecialchars($plan) ?></p>
            <p><strong><?= $fieldLabel ?>:</strong> <?= htmlspecialchars($phone) ?></p>
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
