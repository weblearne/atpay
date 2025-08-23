<?php
session_start();

// ✅ Validate session token
if (empty($_SESSION['atpay_auth_token_key'])) {
    echo json_encode([
        "status"  => "failed",
        "message" => "Authentication token is missing. Please log in again."
    ]);
    exit;
}

$networkId = $_POST['network'] ?? null;

$response = null; // Default

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ✅ Read input safely (support both JSON and form POST)
$networkId = $_POST['network'] ?? null;
$phone     = $_POST['phone']   ?? null;
$amount    = $_POST['amount']  ?? null;





$payload = [
    "network"     => $networkId,
    "PhoneNumber" => $phone,
    "amount"      => $amount
];

$token = $_SESSION['atpay_auth_token_key'];

// ✅ Send request to API
$ch = curl_init("https://www.atpay.ng/api/airtime/");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_HTTPHEADER     => [
        "Authorization: Token $token",
        "Content-Type: application/json",
    ],
    CURLOPT_TIMEOUT        => 30,
]);

$respons = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode([
        "status"  => "failed",
        "message" => "cURL Error: " . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

curl_close($ch);
// echo json_encode($result);
 /// response = {"error":true,"Status":"Fail","status":"fail","message":"Authorization token not found","msg":"Authorization token not found"}

$result = json_decode($respons, true);

$response = $result;

$get_erro_msg = $result['message']??'';
if($get_erro_msg =="Authorization token not found"){
    // kin s
session_unset();
session_destroy();
header("location: ../../Auth/login/");
 exit();

}


}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Airtime</title>
<link rel="stylesheet" href="index.css">
      <link rel="icon" type="image/png" href="../../images/logo.png">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
 

    <!-- Top Navigation -->
    <?php include '../../include/user_top_navbar.php';?>

    <!-- Main Container -->
    <div class="container">
        <div id="alert-container"></div>

       <!-- Networks Dropdown -->
<!-- <select name="network" required>
    <option value="">Select Network</option>

        <option > MTN</option>
        <option> AIRTEL</option>
        <option> 9MOBILE</option>
        <option> GLO</option>
    
</select> -->
    <form action="" method="post">
    <div class="networks-section">
        <br>
        <h2 class="section-title"><i class="fas fa-network-wired"></i> Select Network</h2>
        <div class="network-tabs">
            <!-- Hidden field for network -->
            <input type="hidden" name="network" id="networkInput" value="<?= $networkId ?>">

            <a href="javascript:void(0)" 
               class="network-tab <?= $networkId == 2 ? 'active' : '' ?>" 
               onclick="setNetwork(2, this)">Glo</a>

            <a href="javascript:void(0)" 
               class="network-tab <?= $networkId == 3 ? 'active' : '' ?>" 
               onclick="setNetwork(3, this)">9mobile</a>

            <a href="javascript:void(0)" 
               class="network-tab <?= $networkId == 4 ? 'active' : '' ?>" 
               onclick="setNetwork(4, this)">Airtel</a>

            <a href="javascript:void(0)" 
               class="network-tab <?= $networkId == 1 ? 'active' : '' ?>" 
               onclick="setNetwork(1, this)">MTN</a>
        </div>
    </div>

    <!-- Phone Number Input -->
    <div class="phone-section">
        <fieldset class="phone-fieldset">
            <legend class="phone-legend">Phone Number</legend>
            <input type="tel" name="phone" id="phone-input" class="phone-input" placeholder="Enter phone number" maxlength="11" required>
        </fieldset>
    </div>

    <!-- Amount Input -->
    <div class="amount-input-section">
        <fieldset class="amount-fieldset">
            <legend class="amount-legend">Amount</legend>
            <input type="number" name="amount" id="amount-input" class="amount-input" placeholder="Enter amount (min ₦50)" min="50" required>
        </fieldset>
    </div>

    <!-- Pay Button -->
    <div class="section">
        <button type="submit" id="pay-btn" class="pay-btn">Pay</button>
    </div>
</form>



          <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>

        
    <script>
        

    function setNetwork(id, el) {
    // update hidden input
    document.getElementById("networkInput").value = id;
    // remove active from all tabs
    document.querySelectorAll(".network-tab").forEach(tab => tab.classList.remove("active"));
    // add active to clicked one
    el.classList.add("active");
}

        // Detect network from phone number
     

        // Validate pay button state
        function validatePayButton() {
            if (!phoneInput.value || phoneInput.value.length !== 11 || !selectedNetwork || !selectedAmount || selectedAmount < 50) {
                payBtn.disabled = true;
                payBtn.textContent = 'Pay';
            } else {
                payBtn.disabled = false;
                payBtn.textContent = `Pay ₦${Number(selectedAmount).toLocaleString()}`;
            }
        }

        // Purchase airtime function
        function purchaseAirtime() {
            if (!selectedNetwork || !phoneInput.value || phoneInput.value.length !== 11 || !selectedAmount || selectedAmount < 50) {
                showAlert('Please select a network, enter a valid phone number, and select an amount', 'error');
                return;
            }

            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="loading"><span class="spinner"></span> Processing...</span>';

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=purchase_airtime&phone=${encodeURIComponent(phoneInput.value)}&network=${encodeURIComponent(selectedNetwork)}&amount=${encodeURIComponent(selectedAmount)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(`Airtime purchase successful! Transaction ID: ${data.transaction_id}`, 'success');
                    phoneInput.value = '';
                    amountInput.value = '';
                    selectedNetwork = '';
                    selectedAmount = null;
                    document.querySelectorAll('.network-card').forEach(c => c.classList.remove('selected'));
                    document.querySelectorAll('.amount-card').forEach(c => c.classList.remove('selected'));
                } else {
                    showAlert(data.message || 'Purchase failed. Please try again.', 'error');
                }
                validatePayButton();
            })
            .catch(error => {
                console.error('Error purchasing airtime:', error);
                showAlert('An error occurred. Please try again.', 'error');
                validatePayButton();
            });
        }

//       function showAlert(message, type) {
//     if (type === 'success') {
//         Swal.fire({
//             icon: 'success',
//             title: 'Airtime Purchased',
//             text: message,
//             confirmButtonColor: '#3085d6'
//         });
//     } else {
//         Swal.fire({
//             icon: 'error',
//             title: 'Transaction Failed',
//             text: message,
//             confirmButtonColor: '#d33'
//         });
//     }
// }


        // Initialize
        // document.addEventListener('DOMContentLoaded', function() {
        //     payBtn.addEventListener('click', purchaseAirtime);
        // });

        document.addEventListener('DOMContentLoaded', () => {
  <?php if ($response): ?>
   Swal.fire({
    title: "<?= 
        (($response['Status'] ?? '') === 'success' || ($response['error'] ?? true) === false) 
        ? 'Purchase Successful!' 
        : 'Transaction Failed!' 
    ?>",
    text: "<?= htmlspecialchars($response['message'] ?? '') ?>",
    icon: "<?= 
        (($response['Status'] ?? '') === 'success' || ($response['error'] ?? true) === false) 
        ? 'success' 
        : 'error' 
    ?>",
    confirmButtonColor: "<?= 
        (($response['Status'] ?? '') === 'success' || ($response['error'] ?? true) === false) 
        ? '#3085d6' 
        : '#d33' 
    ?>"
    });

  <?php endif; ?>
});


    </script>
</body>
</html>