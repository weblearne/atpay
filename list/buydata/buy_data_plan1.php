<?php
// session_start();

// if (!isset($_SESSION['user'])) {
//     header("Location: index.php");
//     exit();
// }

$user = $_SESSION['user'];
$authToken = $user['AthuKey'];
$apiUrl = "https://gtopup.site/api_admin/request/plans.php";

// Make API request
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Token $authToken",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));
$response = curl_exec($ch);
file_put_contents("getPlan.txt", $response);
curl_close($ch);

// Decode JSON
$data = json_decode($response, true);

// Final structure
$networks = [];

// Validate response
if (isset($data['Plans']) && is_array($data['Plans'])) {
    foreach ($data['Plans'] as $plan) {
        if (!isset($plan['planName'], $plan['UserPrice'], $plan['Duration']) || $plan['UserPrice'] <= 0) {
            continue; // skip invalid or inactive plans
        }

        // Extract network from first word of the plan name
        $parts = explode(' ', trim($plan['planName']));
        $network = strtoupper($parts[0]);

        // Clean name - extract size and frequency if possible
        $pattern = '/(\d+\.?\d*)([MG]B)/i'; // Match 500MB, 1.0GB etc.
        $matched = [];
        preg_match($pattern, $plan['planName'], $matched);

        $size = isset($matched[0]) ? strtoupper($matched[0]) : 'DATA';
        $validity = ucwords(strtolower($plan['Duration']));

        // Try to guess frequency from name (optional logic)
        if (stripos($plan['planName'], 'daily') !== false) {
            $label = "$size Daily";
        } elseif (stripos($plan['planName'], 'weekly') !== false) {
            $label = "$size Weekly";
        } elseif (stripos($plan['planName'], 'monthly') !== false) {
            $label = "$size Monthly";
        } else {
            $label = "$size - $validity";
        }

        // Add to final array
        $networks[$network][] = [
            // 'name' => $label,
            'name' => $plan['planName'],
            'price' => (int)$plan['UserPrice'],
            'validity' => $validity,
            'planID' => $plan['planID'],
        ];
    }
}

// Output result
// echo "<pre>";
// print_r($networks);
// echo "</pre>";
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNG DATA API - Data Plans</title>
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

        .menu-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background 0.3s ease;
            display: none;
        }

        .menu-toggle:hover {
            background: #f3f4f6;
        }

        .menu-toggle span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--text);
            margin: 5px 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            border-radius: 1px;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        .sidebar {
            position: fixed;
            top: 60px;
            left: -100%;
            width: clamp(200px, 60vw, 250px);
            height: calc(100vh - 60px);
            background: var(--primary);
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 999;
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 60px;
            left: 0;
            width: 100%;
            height: calc(100vh - 60px);
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 998;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .nav-menu {
            padding: 16px 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.2s ease;
            border-right: 3px solid transparent;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: clamp(14px, 3.5vw, 15px);
            font-weight: 500;
        }

        .nav-item:hover {
            background: var(--secondary);
            transform: scale(1.02);
        }

        .nav-item.active {
            background: var(--secondary);
            border-right-color: var(--accent);
        }

        .nav-item i {
            font-size: clamp(16px, 4vw, 18px);
            width: 24px;
            text-align: center;
        }

        .nav-item a {
            color: inherit;
            text-decoration: none;
            display: block;
            width: 100%;
        }

        .logout-btn {
            position: absolute;
            bottom: 16px;
            left: 16px;
            right: 16px;
            padding: 12px;
            background: linear-gradient(135deg, var(--danger), var(--danger-light));
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: clamp(13px, 3vw, 14px);
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .main-content {
            margin-top: 60px;
            padding: clamp(16px, 4vw, 24px);
            transition: margin-left 0.3s ease;
            flex: 1;
        }

        .networks-section {
            margin-bottom: clamp(16px, 4vw, 24px);
        }

        .section-title {
            font-size: clamp(18px, 4.5vw, 20px);
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 16px;
        }

        .network-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: clamp(8px, 2vw, 12px);
            margin-bottom: 20px;
        }

        .network-tab {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: clamp(10px, 2.5vw, 12px);
            font-size: clamp(14px, 3.5vw, 16px);
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            text-align: center;
            min-width: clamp(80px, 20vw, 100px);
        }

        .network-tab:hover {
            background: var(--accent);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .network-tab.active {
            background: var(--secondary);
            color: #ffffff;
            border-color: var(--accent);
        }

        .plans-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: clamp(12px, 3vw, 16px);
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .plans-container.active {
            opacity: 1;
            transform: translateY(0);
        }

        .plan-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: clamp(12px, 3vw, 16px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .plan-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
        }

        .plan-name {
            font-size: clamp(16px, 4vw, 18px);
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .plan-price {
            font-size: clamp(18px, 4.5vw, 20px);
            font-weight: bold;
            color: var(--secondary);
            margin-bottom: 8px;
        }

        .plan-validity {
            font-size: clamp(12px, 3vw, 14px);
            color: var(--text-light);
        }

        footer {
            background: var(--primary);
            color: #ffffff;
            text-align: center;
            padding: clamp(10px, 2.5vw, 12px) 16px;
            font-size: clamp(12px, 3vw, 13px);
            margin-top: auto;
        }

        @media (min-width: 1024px) {
            .sidebar {
                left: 0;
            }

            .main-content {
                margin-left: 250px;
            }

            .sidebar-overlay {
                display: none;
            }

            .menu-toggle {
                display: none;
            }
        }

        @media (max-width: 1024px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                left: -100%;
            }

            .sidebar.active {
                left: 0;
            }

            .plans-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 16px 12px;
            }

            .network-tabs {
                display: flex;
                flex-wrap: wrap;
                gap: clamp(8px, 2vw, 12px);
                margin-bottom: 10px;
                /* flex-direction: column; */
                /* align-items: stretch; */
            }

            .network-tab {
                min-width: 20%;
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

            .plan-card {
                padding: 12px;
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
        <button class="menu-toggle" aria-label="Toggle Sidebar" aria-expanded="false" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="logo-container">
            <img src="LOGO.JPG" alt="mng data logo" style="width: clamp(32px, 8vw, 40px); height: clamp(32px, 8vw, 40px); border-radius: 50px;">
            <div class="logo-text"><a href="user.php" class="logo-text">MNG DATA API</a></div>
        </div>
    </div>

    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="sidebar" id="sidebar">
        <nav class="nav-menu">
            <button class="nav-item"><i class="fas fa-tachometer-alt"></i> <a href="user.php">Dashboard</a></button>
            <button class="nav-item active"><i class="fas fa-star"></i> <a href="plans.php">Plans</a></button>
            <button class="nav-item"><i class="fas fa-sliders-h"></i> <a href="profile.php">Settings</a></button>
            <button class="nav-item"><i class="fas fa-credit-card"></i> <a href="transactions.php">Transactions</a></button>
            <button class="nav-item"><i class="fas fa-book"></i> <a href="documentation.php">Documentation</a></button>
            <button class="nav-item"><i class="fas fa-user"></i> <a href="profile.php">Profile</a></button>
        </nav>
        <button class="logout-btn" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>

    <main class="main-content">
        <div class="networks-section">
            <h2 class="section-title">Select Network</h2>
            <div class="network-tabs">
                <?php foreach (array_keys($networks) as $network): ?>
                    <button class="network-tab" data-network="<?= htmlspecialchars($network) ?>">
                        <?= htmlspecialchars($network) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <?php foreach ($networks as $network => $plans): ?>
                <div class="plans-container" id="<?= htmlspecialchars($network) ?>" style="display: none;">
                    <?php foreach ($plans as $plan): ?>
                        <div class="plan-card" onclick="redirectToBuy('<?= htmlspecialchars($network) ?>', '<?= htmlspecialchars($plan['name']) ?>', <?= $plan['price'] ?>, <?= $plan['planID'] ?>)">

                            <div class="plan-name"><?= htmlspecialchars($plan['name']) ?></div>
                            <div class="plan-price">₦<?= number_format($plan['price'], 2) ?></div>
                            <div class="plan-validity"><?= htmlspecialchars($plan['validity']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        © 2025 MNG DATA API.|| Powered by SKAN FIN TECH SERVICES. All rights reserved.
    </footer>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const toggleBtn = document.querySelector('.menu-toggle');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            const isExpanded = sidebar.classList.contains('active');
            toggleBtn.setAttribute('aria-expanded', isExpanded);
        }

        function navigateTo(event) {
            const navItem = event.currentTarget;
            const link = navItem.querySelector('a');
            if (link) {
                document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
                navItem.classList.add('active');
                
                if (window.innerWidth <= 1024) {
                    toggleSidebar();
                }
                
                window.location.href = link.href;
            }
        }

        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out of your account.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Logging out...', '', 'success');
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1500);
                }
            });
        }

        function redirectToBuy(network, planName, price, planID) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'buydata.php';

    const fields = [
        { name: 'network', value: network },
        { name: 'plan', value: planName },
        { name: 'price', value: price },
        { name: 'plan_id', value: planID }
    ];

    fields.forEach(field => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = field.name;
        input.value = field.value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}


        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.network-tab');
            const containers = document.querySelectorAll('.plans-container');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const network = tab.dataset.network;

                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    // Show selected plans
                    containers.forEach(c => {
                        c.style.display = 'none';
                        c.classList.remove('active');
                    });
                    const activeContainer = document.getElementById(network);
                    activeContainer.style.display = 'grid';
                    setTimeout(() => {
                        activeContainer.classList.add('active');
                    }, 10); // Slight delay for animation
                });
            });

            // Activate first tab by default
            if (tabs.length > 0) {
                tabs[0].click();
            }

            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', navigateTo);
            });

            document.addEventListener('click', (event) => {
                const sidebar = document.getElementById('sidebar');
                const menuToggle = document.querySelector('.menu-toggle');
                
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target) && window.innerWidth <= 1024) {
                    if (sidebar.classList.contains('active')) {
                        toggleSidebar();
                    }
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 1024) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.querySelector('.sidebar-overlay');
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>