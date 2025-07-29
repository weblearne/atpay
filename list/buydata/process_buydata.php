<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];

// Get data from POST
$network = isset($_POST['network']) ? htmlspecialchars($_POST['network']) : '';
$plan    = isset($_POST['planid']) ? htmlspecialchars($_POST['planid']) : '';
$price   = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$phone   = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';

if (empty($network) || empty($plan) || empty($phone) || $price <= 0) {
    die("Missing required fields.");
}

$network_map = [
    'MTN' => 1,
    'GLO' => 2,
    'AIRTEL' => 3,
    '9MOBILE' => 4
];



$network_id = $network_map[$network] ?? null;
$data_plan_id = $data_plan_map[$plan] ?? null;

if (!$network_id || !$plan) {
    die("Invalid network or plan selected.".$plan);
}
//  echo $plan;
//  exit();

// $apiUrl = 'https://gtopup.site/api_admin/api/data/';
$apiUrl = 'https://gtopup.site/api_admin/api/data/';
$postData = [
    "network" => $network_id,
    "phone" => $phone,
    "plan" => $plan,
    "ref" => time()
];

$jsonData = json_encode($postData);
$authToken = $_SESSION['user']['AthuKey'];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: ' . $authToken
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    // echo "cURL Error: " . curl_error($ch);
    $transaction_status = 'failed';
    $transaction_message = "cURL Error: " . curl_error($ch);
    
} else {
    $result = json_decode($response, true);
    if($result && $result['status']=='success'){
        $transaction_status = $result['status'];
        $transaction_message = $result['msg']; 
    }else{
        $transaction_status = $result['status'];
        $transaction_message = $result['msg']; 
    }

    // status
    // echo "<h2>API Response</h2>";
    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
}

curl_close($ch);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNG DATA API - Transaction Result</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #1e3a8a;
            --secondary: #2563eb;
            --accent: #3b82f6;
            --danger: #ef4444;
            --danger-light: #f87171;
            --background: #f8fafc;
            --card-bg: #ffffff;
            --text: #374151;
            --text-light: #6b7280;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: var(--card-bg);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 0 clamp(12px, 3vw, 16px);
            height: 60px;
            display: flex;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .logo-text {
            font-size: clamp(16px, 4vw, 18px);
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            font-family: sans-serif;
        }

        .main-content {
            margin-top: 60px;
            padding: clamp(16px, 4vw, 24px);
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .transaction-result {
            max-width: 500px;
            width: 100%;
            background: var(--card-bg);
            border-radius: 12px;
            padding: clamp(16px, 4vw, 24px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.5s ease-out forwards;
            text-align: center;
        }

        .section-title {
            font-size: clamp(18px, 4.5vw, 20px);
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 16px;
        }

        .status-icon {
            font-size: clamp(40px, 10vw, 48px);
            margin-bottom: 16px;
        }

        .status-icon.success {
            color: var(--secondary);
        }

        .status-icon.error {
            color: var(--danger);
        }

        .message {
            font-size: clamp(14px, 3.5vw, 16px);
            color: var(--text);
            margin-bottom: 24px;
        }

        .action-btn {
            display: inline-block;
            padding: clamp(10px, 2.5vw, 12px) clamp(20px, 5vw, 24px);
            background: var(--secondary);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: clamp(14px, 3.5vw, 16px);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: var(--accent);
            transform: translateY(-2px);
        }

        footer {
            background: var(--primary);
            color: #ffffff;
            text-align: center;
            padding: clamp(10px, 2.5vw, 12px) 16px;
            font-size: clamp(12px, 3vw, 13px);
            margin-top: auto;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 16px 12px;
            }

            .transaction-result {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 0 12px;
            }

            .logo-container img {
                width: 32px;
                height: 32px;
            }

            .logo-text {
                font-size: 14px;
            }

            .section-title {
                font-size: 16px;
            }

            .status-icon {
                font-size: 36px;
            }

            .message {
                font-size: 14px;
            }

            .action-btn {
                font-size: 14px;
                padding: 8px 16px;
            }

            footer {
                font-size: 11px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="LOGO.JPG" alt="mng data logo" style="width: clamp(32px, 8vw, 40px); height: clamp(32px, 8vw, 40px); border-radius: 50px;">
            <div class="logo-text"><a href="user.php" class="logo-text">MNG DATA API</a></div>
        </div>
    </div>

    <main class="main-content">
        <div class="transaction-result">
            <h2 class="section-title">Transaction Result</h2>
            <div class="status-icon <?= $transaction_status ?>">
                <i class="fas fa-<?= $transaction_status === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            </div>
            <div class="message"><?= $transaction_message ?></div>
            <a href="<?= $transaction_status === 'success' ? 'user.php' : 'buydata.php' ?>" class="action-btn">
                <?= $transaction_status === 'success' ? 'Back to Dashboard' : 'Try Again' ?>
            </a>
        </div>
    </main>

    <footer>
        © 2025 MNG DATA API.|| Powered by SKAN FIN TECH SERVICES. All rights reserved.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: '<?= $transaction_status === 'success' ? 'Success' : 'Error' ?>',
                html: '<?= addslashes($transaction_message) ?>',
                icon: '<?= $transaction_status ?>',
                confirmButtonColor: '#2563eb',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= $transaction_status === 'success' ? 'user.php' : 'buy_data_plan1.php' ?>';
                }
            });
        });
    </script>
</body>
</html>