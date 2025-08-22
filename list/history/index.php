<?php
session_start();

// ✅ Get token from session
$token = $_SESSION['atpay_auth_token_key'] ?? '';
if (!$token) {
    die("No authentication token found. Please login again.");
}

// API Endpoints
$apiHistory = "https://www.atpay.ng/List/history/";
$apiFunding = "https://www.atpay.ng/List/funding/";

// 🔹 Generic fetch function
function fetchFromApi($token, $url) {
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [], // API requires POST
        CURLOPT_HTTPHEADER => [
            "Authorization: Token $token",
            "Accept: application/json"
        ]
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        return [];
    }
    curl_close($ch);

    return json_decode($response, true) ?? [];
}

// 🔹 Fetch Transactions (buydata, airtime, etc)
$historyResponse = fetchFromApi($token, $apiHistory);
$all_transactions = $historyResponse['order'] ?? []; 

// 🔹 Fetch Funding (wallet top-ups)
$fundingResponse = fetchFromApi($token, $apiFunding);
$funding_transactions = $fundingResponse['order'] ?? [];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - atPay</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <?php include '../../user/notification/navbar.php';?>
        <center>
            <div class="nav-title">Transaction History</div>
            <div style="width: 1.5rem;"></div>
        </center>

    <!-- History Container -->
<div class="history-container">
    <div class="tabs">
        <div class="tab active" id="transactions-tab" onclick="showTransactions()">Transactions</div>
        <div class="tab" id="funding-tab" onclick="showFunding()">Funding</div>
    </div>

    <!-- Transactions -->
    <div class="transaction-list" id="transactions-list">
        <?php if (empty($all_transactions)): ?>
            <div class="no-transactions">No transactions found</div>
        <?php else: ?>
            <?php foreach ($all_transactions as $transaction): ?>
                <div class="transaction-item">
                    <div class="transaction-details">
                        <div class="transaction-type"><?= htmlspecialchars($transaction['Product'] ?? ''); ?></div>
                        <div class="transaction-amount">₦<?= number_format($transaction['Amount'] ?? 0, 0); ?></div>
                        <div class="transaction-date"><?= htmlspecialchars($transaction['Date'] ?? ''); ?></div>
                        <div class="transaction-desc"><?= htmlspecialchars($transaction['Description'] ?? ''); ?></div>
                    </div>
                    <div class="transaction-status status-<?= ($transaction['Status'] == 200 ? 'success' : 'failed'); ?>">
                        <?= $transaction['Status'] == 200 ? 'Success' : 'Failed'; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Funding -->
    <div class="transaction-list" id="funding-list" style="display: none;">
        <?php if (empty($funding_transactions)): ?>
            <div class="no-transactions">No funding transactions found</div>
        <?php else: ?>
            <?php foreach ($funding_transactions as $transaction): ?>
                <div class="transaction-item">
                    <div class="transaction-details">
                        <div class="transaction-type"><?= htmlspecialchars($transaction['Product'] ?? ''); ?></div>
                        <div class="transaction-amount">₦<?= number_format($transaction['Amount'] ?? 0, 0); ?></div>
                        <div class="transaction-date"><?= htmlspecialchars($transaction['Date'] ?? ''); ?></div>
                        <div class="transaction-desc"><?= htmlspecialchars($transaction['Description'] ?? ''); ?></div>
                    </div>
                    <div class="transaction-status status-<?= ($transaction['Status'] == 200 ? 'success' : 'failed'); ?>">
                        <?= $transaction['Status'] == 200 ? 'Success' : 'Failed'; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
    </div>

    <?php include '../../include/app_settings.php'; ?>
    <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
        <?= APP_NAME_FOOTER; ?>
    </footer>

    <script>
       function showTransactions() {
    document.getElementById('transactions-list').style.display = 'block';
    document.getElementById('funding-list').style.display = 'none';
    document.getElementById('transactions-tab').classList.add('active');
    document.getElementById('funding-tab').classList.remove('active');
}

function showFunding() {
    document.getElementById('transactions-list').style.display = 'none';
    document.getElementById('funding-list').style.display = 'block';
    document.getElementById('transactions-tab').classList.remove('active');
    document.getElementById('funding-tab').classList.add('active');
}

showTransactions();

    </script>
</body>
</html>
