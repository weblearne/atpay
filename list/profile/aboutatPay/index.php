<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About atPay</title>
    <style>
        :root {
            --primary-color: #4c1d95;
            --secondary-color: #ffffff;
            --accent-color: #6366f1;
            --success-color: #10b981;
            --error-color: #ef4444;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --hover-bg: #f3f4f6;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --alternate-bg: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-nav {
            background-color: var(--secondary-color);
            padding: 1rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .nav-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .back-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-primary);
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .back-btn:hover {
            background-color: var(--hover-bg);
        }

        .about-section {
            background-color: var(--secondary-color);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            flex: 1;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .content-text {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .key-features ul {
            list-style-type: none;
            padding-left: 0;
        }

        .key-features ul li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.75rem;
            color: var(--accent-color);
        }

        .key-features ul li:before {
            content: "✔";
            position: absolute;
            left: 0;
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .container {
                padding: 0.75rem;
            }

            .top-nav {
                padding: 0.75rem;
            }

            .nav-title {
                font-size: 1rem;
            }

            .back-btn {
                font-size: 1.25rem;
            }

            .about-section {
                padding: 1rem;
            }

            .section-title {
                font-size: 1.25rem;
            }

            .content-text {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 480px) {
            .nav-title {
                font-size: 0.875rem;
            }

            .back-btn {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.125rem;
            }

            .content-text {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <?php include '../../../include/user_top_navbar.php';?>
        <br>
        <!-- About Section -->
        <div class="about-section">
            <h2 class="section-title">Welcome to atPay</h2>
            <p class="content-text">atPay is a fast and secure platform that allows users to conveniently purchase data, airtime, and other digital services.</p>

            <h2 class="section-title">Key Features:</h2>
            <div class="key-features">
                <ul>
                    <li>Seamless data and airtime purchase</li>
                    <li>Secure transactions with encryption</li>
                    <li>Fast customer support</li>
                    <li>User-friendly interface</li>
                </ul>
            </div>

            <h2 class="section-title">Meet the atPay Team:</h2>
            <p class="content-text">Our dedicated team is committed to providing the best digital payment solutions. With expertise in technology and finance, we strive to make transactions easy, fast, and secure for all our users.</p>
            <p class="content-text">For more details, visit our website or contact support.</p>
        </div>
    </div>

    <?php include '../../../include/app_settings.php'; ?>
    <footer style="text-align: center; font-size: 14px; color: var(--secondary-color); background-color: var(--primary-color); padding: 20px 0;">
        <?php echo APP_NAME_FOOTER; ?>
    </footer>
</body>
</html>