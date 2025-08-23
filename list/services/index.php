<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Services - atPay</title>
       <link rel="icon" type="image/png" href="../../images/logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="index.css">
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