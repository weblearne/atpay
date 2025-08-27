<?php
// ---------------- Fetch Plans from API ----------------
session_start();
if (!isset($_SESSION['atpay_auth_token_key'])) {
    header("Location:../../Auth/login/");
    exit();
}
$planId = $_POST['planId'] ?? 0;
$PlanName = $_POST['PlanName'] ?? '';
$User = $_POST['User'] ?? '';
$number = $_POST['number'] ?? '';

function fetchPlans($token, $payload) {
    $url = "https://www.atpay.ng/List/data/";
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            "Authorization: Token $token",
            "Accept: application/json",
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception("cURL error: " . curl_error($ch));
    }

    curl_close($ch);

    return json_decode($response, true);
}

// ---------------- Load Plans by Network ----------------
try {
    $token = $_SESSION['atpay_auth_token_key']; // API token
    $networkId = isset($_GET['network']) ? intval($_GET['network']) : 1;
    $payload = ["NetworkId" => $networkId];
    $result = fetchPlans($token, $payload);

    $plans   = $result['plans'] ?? [];
    $Service = $result['Service'] ?? [];
    $error_  = $result['error'] ?? [];

    $message = "";

    if ($error_ == true) {
        $message = $result['message'] ?? [];
        include "../../logout.php";
    }

    // ✅ Step 1: collect only active services
    $activeServices = [];
    foreach ($Service as $srv) {
        if (isset($srv['DataType'], $srv['DataStatus']) && strtolower($srv['DataStatus']) === 'on') {
            $activeServices[] = strtolower($srv['DataType']);
        }
    }

    // ✅ Step 2: filter plans to keep only those whose DataType is active
    $plans = array_filter($plans, function($plan) use ($activeServices) {
        return isset($plan['DataType']) && in_array(strtolower($plan['DataType']), $activeServices);
    });

    $networkNames = ["1" => "MTN", "2" => "Airtel", "3" => "Glo", "4" => "9mobile"];
    $networkName  = $networkNames[$networkId] ?? "Unknown";

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>atPay Wallet - Data Plans</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="index.css">
      <link rel="icon" type="image/png" href="../../images/logo.png">

</head>
<body>
<?php include "../../include/user_top_navbar.php" ?>

<main class="main-content">
    <div class="page-header">
        <h1 class="page-title">Choose Your Data Plan</h1>
        <p class="page-subtitle">Select your preferred network and choose from our affordable data plans</p>
    </div>

    <div class="networks-section">
        <h2 class="section-title"><i class="fas fa-network-wired"></i> Select Network</h2>
       <div class="network-tabs">
            <a href="?network=2" class="network-tab <?= $networkId == 2 ? 'active' : '' ?>">Glo</a>
            <a href="?network=3" class="network-tab <?= $networkId == 3 ? 'active' : '' ?>">9mobile</a>
            <a href="?network=4" class="network-tab <?= $networkId == 4 ? 'active' : '' ?>">Airtel</a>
            <a href="?network=1" class="network-tab <?= $networkId == 1 ? 'active' : '' ?>">MTN</a>

        </div>
    </div>

    <!-- Show message -->
    <?php if (!empty($message)): ?>
        <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <div class="plans-container active">
        <?php if (!empty($plans)) : ?>
            <?php foreach ($plans as $plan): ?>
                <div class="plan-card">
                    <div class="plan-name"><?= htmlspecialchars($plan['PlanName']??'') ?></div>
                    <div class="plan-price">₦<?= htmlspecialchars($plan['User']??'') ?></div>
                    <div class="plan-validity">Validity: <?= htmlspecialchars($plan['Validity'] ?? 'N/A') ?></div>

                    <!-- Buy Now form -->
                    <form method="post" action="buydata/">
                        <input type="hidden" name="planId" value="<?= htmlspecialchars($plan['PlanId']) ?>">
                        <input type="hidden" name="PlanName" value="<?= htmlspecialchars($plan['PlanName']) ?>">
                        <input type="hidden" name="price" value="<?= htmlspecialchars($plan['User']) ?>">
                        <input type="hidden" name="networkid" value="<?= htmlspecialchars($plan['NetworkId']) ?>">
                       
                        <button type="submit" class="buy-btn">Buy Now</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No plans found for <?= htmlspecialchars($networkName) ?>.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
