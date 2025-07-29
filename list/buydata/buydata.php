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

        .buy-data-section {
            max-width: 500px;
            width: 100%;
            background: var(--card-bg);
            border-radius: 12px;
            padding: clamp(16px, 4vw, 24px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .section-title {
            font-size: clamp(18px, 4.5vw, 20px);
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 16px;
            text-align: center;
        }

        .service-image {
            display: block;
            margin: 0 auto 16px;
            width: clamp(60px, 15vw, 80px);
            height: auto;
            animation: pulseImage 2s infinite ease-in-out;
        }

        .plan-details {
            margin-bottom: 20px;
            text-align: center;
        }

        .plan-name {
            font-size: clamp(16px, 4vw, 18px);
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
        }

        .plan-price {
            font-size: clamp(20px, 5vw, 24px);
            font-weight: bold;
            color: var(--secondary);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: clamp(14px, 3.5vw, 16px);
            color: var(--text);
            margin-bottom: 8px;
            text-align: left;
        }

        .form-input {
            width: 100%;
            padding: clamp(10px, 2.5vw, 12px);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: clamp(14px, 3.5vw, 16px);
            color: var(--text);
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: clamp(12px, 3vw, 16px);
            background: var(--secondary);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: clamp(14px, 3.5vw, 16px);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
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

        @keyframes pulseImage {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 16px 12px;
            }

            .buy-data-section {
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

            .service-image {
                width: clamp(50px, 12vw, 60px);
            }

            .plan-name {
                font-size: 14px;
            }

            .plan-price {
                font-size: 18px;
            }

            .form-label, .form-input, .submit-btn {
                font-size: 14px;
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