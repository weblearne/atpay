<?php
session_start();
if (!isset($_SESSION['atpay_auth_token_key'])) {
    header("Location: .././../Auth/login/");
    exit();
}

$response = null; // Default

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['phone']) || empty($_POST['planid']) || empty($_POST['networkid'])) {
        $response = [
            "status"  => "failed",
            "message" => "Missing required fields."
        ];
    } else {
        function buyDataPlan($token, $payload) {
            $url = "https://atpay.ng/api/data/";
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

        try {
            $token = $_SESSION['atpay_auth_token_key'] ?? "";

            if (empty($token)) {
                $response = [
                    "status"  => "failed",
                    "message" => "Authorization token missing. Please log in again."
                ];
            } else {
                $planid   = $_POST['planid'];
                $network  = $_POST['networkid'];
                $phone    = $_POST['phone'];

                $payload = [
                    "network"        => $network,
                    "ported_number"  => true,
                    "phone"          => $phone,
                    "plan"           => $planid
                ];

                $result = buyDataPlan($token, $payload);
                $response = $result;
            }
        } catch (Exception $e) {
            $response = [
                "status"  => "failed",
                "message" => $e->getMessage()
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>atPay - Transaction Receipt</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
   :root {
      --primary: #4c1d95;
      --secondary: #ffffff;
      --accent: #2563eb;
      --success: #059669;
      --error: #dc2626;
      --background: #f7fafc;
      --card-bg: #ffffff;
      --text: #1a202c;
      --text-light: #4a5568;
      --text-muted: #718096;
      --border: #e2e8f0;
      --border-dark: #cbd5e0;
      --receipt-bg: #fefefe;
      --shadow-light: 0 1px 3px rgba(0, 0, 0, 0.1);
      --shadow-medium: 0 2px 4px rgba(0, 0, 0, 0.07);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      width: 100vw;
      height: 100vh;
      overflow: hidden;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--background);
      color: var(--text);
      line-height: 1.4;
      font-size: 14px; /* Reduced base font size */
    }

    .header {
      background-color: var(--secondary);
      border-bottom: 1px solid var(--border);
      padding: 0 1rem;
      height: 3rem; /* Reduced header height */
      display: flex;
      align-items: center;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 100;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .logo-icon {
      width: 1.5rem; /* Smaller logo */
      height: 1.5rem;
      background-color: var(--primary);
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--secondary);
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .logo-text {
      font-size: 1rem; /* Smaller logo text */
      font-weight: 700;
      color: var(--primary);
      text-decoration: none;
      letter-spacing: -0.5px;
    }

    .main-container {
      width: 100%;
      max-width: 36rem; /* Reduced max-width for compactness */
      margin: 3.5rem auto 0; /* Adjusted for fixed header */
      padding: 0.5rem;
      height: calc(100vh - 3rem); /* Full height minus header */
      overflow-y: auto;
      margin-top: 10px;
    }

    .receipt {
      background-color: var(--receipt-bg);
      border: 1px solid var(--border);
      border-radius: 6px;
      box-shadow: var(--shadow-medium);
      overflow: hidden;
      font-family: 'Courier New', monospace;
    }

    .receipt-header {
      background-color: var(--card-bg);
      border-bottom: 1px dashed var(--border-dark);
      padding: 1rem;
      text-align: center;
    }

    .company-name {
      font-size: 1.2rem; /* Smaller font */
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 0.2rem;
      font-family: 'Segoe UI', sans-serif;
      letter-spacing: -0.5px;
    }

    .company-subtitle {
      font-size: 0.75rem; /* Smaller subtitle */
      color: var(--text-muted);
      margin-bottom: 0.5rem;
      font-family: 'Segoe UI', sans-serif;
    }

    .receipt-title {
      font-size: 0.9rem; /* Smaller title */
      font-weight: 600;
      color: var(--text);
      margin-bottom: 0.5rem;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      font-family: 'Segoe UI', sans-serif;
    }

    .transaction-id {
      font-size: 0.7rem; /* Smaller transaction ID */
      color: var(--text-light);
      background-color: var(--background);
      padding: 0.3rem 0.6rem;
      border-radius: 3px;
      display: inline-block;
      border: 1px solid var(--border);
    }

    .receipt-body {
      padding: 1rem;
    }

    .status-section {
      text-align: center;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
      border-bottom: 1px dashed var(--border-dark);
    }

    .status-icon {
      font-size: 2rem; /* Smaller icon */
      margin-bottom: 0.5rem;
    }

    .status-icon.success {
      color: var(--success);
    }

    .status-icon.error {
      color: var(--error);
    }

    .status-message {
      font-size: 0.9rem; /* Smaller status message */
      font-weight: 600;
      margin-bottom: 0.3rem;
      font-family: 'Segoe UI', sans-serif;
    }

    .status-message.success {
      color: var(--success);
    }

    .status-message.error {
      color: var(--error);
    }

    .status-description {
      font-size: 0.7rem; /* Smaller description */
      color: var(--text-light);
      font-family: 'Segoe UI', sans-serif;
    }

    .details-section {
      margin-bottom: 1rem;
    }

    .section-title {
      font-size: 0.75rem; /* Smaller section title */
      font-weight: 600;
      color: var(--text-light);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 0.5rem;
      font-family: 'Segoe UI', sans-serif;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      padding: 0.5rem 0;
      border-bottom: 1px dotted var(--border-dark);
      font-size: 0.8rem; /* Smaller detail text */
    }

    .detail-row:last-child {
      border-bottom: none;
    }

    .detail-label {
      color: var(--text-light);
      font-weight: 500;
      min-width: 6rem; /* Reduced min-width */
    }

    .detail-value {
      color: var(--text);
      font-weight: 600;
      text-align: right;
      word-break: break-all;
    }

    .amount-row {
      background-color: var(--background);
      margin: 0 -1rem;
      padding: 0.75rem 1rem;
      border-top: 1px dashed var(--border-dark);
      border-bottom: 1px dashed var(--border-dark);
    }

    .amount-row .detail-row {
      border-bottom: none;
      font-size: 0.9rem; /* Smaller amount text */
      font-weight: 700;
    }

    .amount-row .detail-value {
      color: var(--primary);
      font-size: 1rem; /* Slightly smaller */
    }

    .receipt-footer {
      background-color: var(--background);
      padding: 1rem;
      text-align: center;
      border-top: 1px dashed var(--border-dark);
    }

    .footer-message {
      font-size: 0.7rem; /* Smaller footer message */
      color: var(--text-light);
      margin-bottom: 0.5rem;
      font-family: 'Segoe UI', sans-serif;
    }

    .timestamp {
      font-size: 0.65rem; /* Smaller timestamp */
      color: var(--text-muted);
      margin-bottom: 1rem;
    }

    .action-buttons {
      display: flex;
      gap: 0.5rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      padding: 0.5rem 1rem; /* Smaller buttons */
      border-radius: 4px;
      font-size: 0.75rem; /* Smaller button text */
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s ease;
      font-family: 'Segoe UI', sans-serif;
    }

    .btn-primary {
      background-color: var(--primary);
      color: var(--secondary);
      border: 1px solid var(--primary);
    }

    .btn-primary:hover {
      background-color: var(--accent);
      border-color: var(--accent);
    }

    .btn-secondary {
      background-color: var(--secondary);
      color: var(--text);
      border: 1px solid var(--border-dark);
    }

    .btn-secondary:hover {
      background-color: var(--background);
      border-color: var(--text-light);
    }

    .company-footer {
      text-align: center;
      padding: 1rem 0.5rem;
      color: var(--text-muted);
      font-size: 0.65rem; /* Smaller footer text */
      background-color: var(--card-bg);
      border-top: 1px solid var(--border);
      font-family: 'Segoe UI', sans-serif;
    }

    /* Print Styles */
    @media print {
      body {
        background-color: white;
        font-size: 12px;
      }
      
      .header,
      .action-buttons,
      .company-footer {
        display: none;
      }
      
      .main-container {
        margin: 0;
        padding: 0;
      }
      
      .receipt {
        border: none;
        box-shadow: none;
      }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      body {
        font-size: 12px; /* Even smaller for mobile */
      }
      
      .main-container {
        padding: 0 0.25rem;
        margin: 3rem auto 0;
      }
      
      .receipt-header,
      .receipt-body,
      .receipt-footer {
        padding: 0.75rem 0.5rem;
      }
      
      .detail-row {
        flex-direction: column;
        gap: 0.2rem;
        padding: 0.3rem 0;
      }
      
      .detail-value {
        text-align: left;
      }
      
      .amount-row {
        margin: 0 -0.5rem;
        padding: 0.5rem;
      }
      
      .action-buttons {
        flex-direction: column;
        align-items: stretch;
      }
      
      .btn {
        justify-content: center;
        padding: 0.4rem;
        font-size: 0.7rem;
      }
      
      .logo-icon {
        width: 1.2rem;
        height: 1.2rem;
        font-size: 0.6rem;
      }
      
      .logo-text {
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
<?php  include "../../../../include/user_top_navbar.php" ?>
  <main class="main-container">
    <div class="receipt">
      <div class="receipt-header">
        <div class="company-name">atPay</div>
        <div class="company-subtitle">Digital Financial Services</div>
        <div class="receipt-title">Transaction Receipt</div>

      <div class="receipt-body">
        <div class="status-section">
          <?php if ($response && ($response['status'] ?? 'failed') === 'success'): ?>
            <div class="status-icon success"><i class="fas fa-check-circle"></i></div>
            <div class="status-message success">Transaction Successful</div>
            <div class="status-description">Your purchase was completed successfully.</div>
          <?php else: ?>
            <div class="status-icon error"><i class="fas fa-times-circle"></i></div>
            <div class="status-message error">Transaction Failed</div>
            <div class="status-description"><?= htmlspecialchars($response['message'] ?? 'Unknown error') ?></div>
          <?php endif; ?>
        </div>

        <div class="details-section">
          <div class="section-title">Transaction Details</div>
          <div class="detail-row">
            <span class="detail-label">Service Type:</span>
            <span class="detail-value">Data Purchase</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Network:</span>
            <span class="detail-value"><?= htmlspecialchars($response['network'] ?? 'N/A') ?></span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Plan:</span>
            <span class="detail-value"><?= htmlspecialchars($response['plan_name'] ?? '') ?> (₦<?= htmlspecialchars($response['plan_amount'] ?? '') ?>)</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Mobile Number:</span>
            <span class="detail-value"><?= htmlspecialchars($response['mobile_number'] ?? '') ?></span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Transaction Date:</span>
            <span class="detail-value"><?= htmlspecialchars($response['create_date'] ?? date('M d, Y H:i:s')) ?></span>
          </div>
        </div>

        <div class="amount-row">
          <div class="detail-row">
            <span class="detail-label">Total Amount:</span>
            <span class="detail-value">₦<?= htmlspecialchars($response['plan_amount'] ?? '0.00') ?></span>
          </div>
        </div>

        <div class="details-section">
          <div class="section-title">Account Information</div>
          <div class="detail-row">
            <span class="detail-label">Previous Balance:</span>
            <span class="detail-value">₦<?= htmlspecialchars($response['previous_balance'] ?? '0.00') ?></span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Amount Debited:</span>
            <span class="detail-value">₦<?= htmlspecialchars($response['plan_amount'] ?? '0.00') ?></span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Current Balance:</span>
            <span class="detail-value">₦<?= htmlspecialchars($response['new_balance'] ?? '0.00') ?></span>
          </div>
        </div>
      </div>

      <div class="receipt-footer">
        <div class="footer-message">Thank you for using atPay! Keep this receipt for your records.</div>
        
        <div class="action-buttons">
          <button class="btn btn-secondary" onclick="window.print()">
            <i class="fas fa-print"></i> Print Receipt
          </button>
        </div>
      </div>
    </div>
  </main>

  <footer class="company-footer">
    <div>&copy; 2025 atPay | Powered by SKAN FIN TECH SERVICES. All rights reserved.</div>
    <div style="margin-top: 0.2rem;">Customer Support: support@atpay.ng | +234 700 ATPAY (28729)</div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      <?php if ($response): ?>
        Swal.fire({
          title: "<?= ($response['status'] ?? 'failed') === 'success' ? 'Purchase Successful!' : 'Purchase Failed!' ?>",
          html: `
            <p><strong>Plan:</strong> <?= htmlspecialchars($response['plan_name'] ?? '') ?></p>
            <p><strong>Number:</strong> <?= htmlspecialchars($response['mobile_number'] ?? '') ?></p>
            <p><strong>Message:</strong> <?= htmlspecialchars($response['message'] ?? '') ?></p>
          `,
          icon: "<?= ($response['status'] ?? 'failed') === 'success' ? 'success' : 'error' ?>",
          confirmButtonColor: '#2563eb'
        });
      <?php endif; ?>
    });
  </script>
</body>
</html>