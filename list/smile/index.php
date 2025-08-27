<?php
session_start();
if (!isset($_SESSION['atpay_auth_token_key'])) {
    header("Location: ../../Auth/login/");
    exit();
}

function fetchSmilePlans($token) {
    $url = "https://www.atpay.ng/List/smile/";
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([]), // Smile may not need payload
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

try {
    $token = $_SESSION['atpay_auth_token_key'];
    $result = fetchSmilePlans($token);
    $plans = $result['plans'] ?? [];
    $error_ = $result['error'] ?? [];

    $message = "";
    if ($error_ == true) {
        $message = $result['message'] ?? [];
        include "../../logout.php";
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smile Plans - atPay</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" type="image/png" href="../../images/logo.png">
</head>
<body>
<?php include "../../include/user_top_navbar.php"; ?>

<main class="main-content">
    <div class="page-header">
        <h1 class="page-title">Choose Smile Plan</h1>
        <p class="page-subtitle">Select from available Smile Voice/Data plans</p>
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
                    <div class="plan-price">₦<?= htmlspecialchars($plan['price']??'') ?></div>
                    <div class="plan-validity">Validity: <?= htmlspecialchars($plan['Validity'] ?? 'N/A') ?></div>

                    <!-- Buy Now form -->
                    <form method="post" action="buysmile/">
                        <input type="hidden" name="planId" value="<?= htmlspecialchars($plan['PlanId']) ?>">
                        <input type="hidden" name="PlanName" value="<?= htmlspecialchars($plan['PlanName']) ?>">
                        <input type="hidden" name="price" value="<?= htmlspecialchars($plan['price']) ?>">
                        <input type="hidden" name="networkid" value="smile"> <!-- special identifier -->

                        <button type="submit" class="buy-btn">Buy Now</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No Smile plans found.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
