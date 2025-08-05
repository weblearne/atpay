<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Services - atPay</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

        .services-section {
            background-color: var(--secondary-color);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            flex: 1;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .service-card {
            background-color: var(--alternate-bg);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .service-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .service-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .service-name {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
            text-transform: capitalize;
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

            .services-section {
                padding: 1rem;
            }

            .section-title {
                font-size: 1.125rem;
            }

            .services-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .service-card {
                padding: 0.75rem;
            }

            .service-icon {
                font-size: 1.25rem;
            }

            .service-name {
                font-size: 0.75rem;
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
                font-size: 1rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .service-card {
                padding: 0.5rem;
            }

            .service-icon {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
         <?php include '../../include/user_top_navbar.php';?>
         <br>
            <div class="nav-title">All Services</div>
            <div style="width: 1.5rem;"></div> <!-- Spacer for alignment -->
       

        <!-- Services Section -->
        <div class="services-section">
            <h2 class="section-title">Our Services</h2>
            <div class="services-grid">
                <div class="service-card" onclick="window.location.href='../electricity/'">
                    <i class="fas fa-bolt service-icon"></i>
                    <div class="service-name">electric</div>
                </div>
                <div class="service-card" onclick="window.location.href='../cabletv/'">
                    <i class="fas fa-tv service-icon"></i>
                    <div class="service-name">tv</div>
                </div>
                <div class="service-card" onclick="window.location.href='../buydata/'">
                    <i class="fas fa-signal service-icon"></i>
                    <div class="service-name">data</div>
                </div>
                <div class="service-card" onclick="window.location.href='../buyairtime/'">
                    <i class="fas fa-phone service-icon"></i>
                    <div class="service-name">airtime</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-sim-card service-icon"></i>
                    <div class="service-name">eSIM</div>
                </div>
                <div class="service-card" onclick="window.location.href='../smile/'">
                    <i class="fas fa-signal service-icon"></i>
                    <div class="service-name">smile</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-pen service-icon"></i>
                    <div class="service-name">exam pin</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-solar-panel service-icon"></i>
                    <div class="service-name">solar</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-signal service-icon"></i>
                    <div class="service-name">data card</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-ticket service-icon"></i>
                    <div class="service-name">airtime pin</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-money-bill-wave service-icon"></i>
                    <div class="service-name">eNaira</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-cash-register service-icon"></i>
                    <div class="service-name">POS</div>
                </div>
                <div class="service-card" onclick="window.location.href='../invite/'">
                    <i class="fas fa-users service-icon"></i>
                    <div class="service-name">refer & earn</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-gift service-icon"></i>
                    <div class="service-name">giveaway</div>
                </div>
                <div class="service-card" onclick="window.location.href='../invite/'">
                    <i class="fas fa-user-plus service-icon"></i>
                    <div class="service-name">invite</div>
                </div>
                <div class="service-card" onclick="window.location.href='../../include/coming_soon.php'">
                    <i class="fas fa-trophy service-icon"></i>
                    <div class="service-name">winbig</div>
                </div>
            </div>
        </div>
    </div>

         <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>
</body>
</html>