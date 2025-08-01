<?php
// Hard-coded data for coming soon features
$launch_date = "2024-12-31 23:59:59";
$features = [
    [
        'icon' => 'fas fa-university',
        'title' => 'Bank Transfer',
        'description' => 'Instant transfers from all major banks'
    ],
    [
        'icon' => 'fab fa-bitcoin',
        'title' => 'USDT Transfer',
        'description' => 'Cryptocurrency funding made simple'
    ],
    [
        'icon' => 'fas fa-hand-holding-usd',
        'title' => 'Manual Funding',
        'description' => 'Manual verification for large amounts'
    ],
    [
        'icon' => 'fas fa-mobile-alt',
        'title' => 'Airtime to Cash',
        'description' => 'Convert airtime to wallet balance'
    ],
    [
        'icon' => 'fas fa-credit-card',
        'title' => 'Virtual Account',
        'description' => 'Dedicated account for seamless funding'
    ]
];

$email_subscribed = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if ($email) {
        // In a real application, you would save this to a database
        $email_subscribed = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - atPay Wallet</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4c1d95;
            --secondary-color: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --hover-bg: #f3f4f6;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --success-color: #10b981;
            --accent-color: #6366f1;
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --gradient-hero: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 50%, #a5b4fc 100%);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated background particles */
        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 20px; height: 20px; top: 20%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 15px; height: 15px; top: 60%; left: 80%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 25px; height: 25px; top: 40%; left: 20%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 12px; height: 12px; top: 80%; left: 70%; animation-delay: 1s; }
        .particle:nth-child(5) { width: 18px; height: 18px; top: 30%; left: 90%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
        }

        /* Main container */
        .main-container {
            width: 100vw;
            margin: 0;
            padding: 0;
            background-color: var(--secondary-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-lg);
            position: relative;
            z-index: 2;
        }

        /* Top Navigation */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            background-color: var(--secondary-color);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            font-size: 1.2rem;
            color: var(--primary-color);
            text-decoration: none;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(76, 29, 149, 0.1);
        }

        .back-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateX(-2px);
        }

        .nav-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Content wrapper */
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            text-align: center;
            position: relative;
        }

        /* Hero Section */
        .hero-section {
            max-width: 600px;
            margin-bottom: 3rem;
        }

        .logo-container {
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 100px;
            height: 100px;
            background: var(--gradient-primary);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0 auto 1rem;
            box-shadow: var(--shadow-lg);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .main-title {
            font-size: 3rem;
            font-weight: 800;
            background: var( --primary-color);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 1.3rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var( --primary-color);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }

        .status-badge i {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Countdown Timer */
        .countdown-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .countdown-title {
            font-size: 1.2rem;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .time-unit {
            text-align: center;
            min-width: 80px;
        }

        .time-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
            line-height: 1;
        }

        .time-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 0.5rem;
        }

        /* Features Preview */
        .features-section {
            max-width: 900px;
            margin-bottom: 3rem;
        }

        .features-title {
            font-size: 2rem;
            color: var(--text-primary);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .features-subtitle {
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-primary);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .feature-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .feature-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.4;
        }

        /* Email Subscription */
        .subscription-section {
            max-width: 500px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-lg);
        }

        .subscription-title {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .subscription-description {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .email-form {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .email-input {
            flex: 1;
            padding: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .email-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(76, 29, 149, 0.1);
        }

        .notify-btn {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .notify-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .success-message {
            color: var(--success-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 1.5rem 1rem;
            }

            .main-title {
                font-size: 2.2rem;
            }

            .subtitle {
                font-size: 1.1rem;
            }

            .countdown-timer {
                gap: 1rem;
            }

            .time-unit {
                min-width: 60px;
            }

            .time-number {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .email-form {
                flex-direction: column;
            }

            .notify-btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 1rem;
            }

            .main-title {
                font-size: 1.8rem;
            }

            .countdown-container,
            .subscription-section {
                padding: 1.5rem;
            }

            .logo-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .feature-card {
                padding: 1.5rem 1rem;
            }
        }

        /* Loading animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-section,
        .countdown-container,
        .features-section,
        .subscription-section {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .countdown-container { animation-delay: 0.2s; }
        .features-section { animation-delay: 0.4s; }
        .subscription-section { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <!-- Background Particles -->
    <div class="bg-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="main-container">
        <!-- Top Navigation -->
   <?php include 'user_top_navbar.php';?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Hero Section -->
            <div class="hero-section">
                 <div class="wallet-header">
                <div class="logo">
                <img src="../images/logo.png" style="width:150px; height:150px; border-radius:50px;" alt="">
              
            </div>
                
                <h1 class="main-title">Something Amazing is Coming</h1>
                <p class="subtitle">We're working hard to bring you the best wallet funding experience. Stay tuned!</p>
                
                <div class="status-badge">
                    <i class="fas fa-cog"></i>
                    <span>Under Development</span>
                </div>
            </div>

            <!-- Countdown Timer -->
            <div class="countdown-container">
                <h3 class="countdown-title">Expected Launch Date</h3>
                <div class="countdown-timer" id="countdown">
                    <div class="time-unit">
                        <span class="time-number" id="days">00</span>
                        <span class="time-label">Days</span>
                    </div>
                    <div class="time-unit">
                        <span class="time-number" id="hours">00</span>
                        <span class="time-label">Hours</span>
                    </div>
                    <div class="time-unit">
                        <span class="time-number" id="minutes">00</span>
                        <span class="time-label">Minutes</span>
                    </div>
                    <div class="time-unit">
                        <span class="time-number" id="seconds">00</span>
                        <span class="time-label">Seconds</span>
                    </div>
                </div>
            </div>

            <!-- Features Preview -->
            <div class="features-section">
                <h2 class="features-title">What's Coming</h2>
                <p class="features-subtitle">Here's what you can expect from our new funding features</p>
                
                <div class="features-grid">
                    <?php foreach ($features as $feature): ?>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="<?php echo $feature['icon']; ?>"></i>
                        </div>
                        <h4 class="feature-title"><?php echo $feature['title']; ?></h4>
                        <p class="feature-description"><?php echo $feature['description']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Email Subscription -->
            <div class="subscription-section">
                <?php if ($email_subscribed): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        <span>Thank you! We'll notify you when we launch.</span>
                    </div>
                <?php else: ?>
                    <h3 class="subscription-title">Get Notified</h3>
                    <p class="subscription-description">
                        Be the first to know when our new funding features go live. We'll send you an email as soon as they're ready!
                    </p>
                    <form class="email-form" method="POST">
                        <input 
                            type="email" 
                            name="email" 
                            class="email-input" 
                            placeholder="Enter your email address" 
                            required
                        >
                        <button type="submit" class="notify-btn">
                            <i class="fas fa-bell"></i> Notify Me
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

          <?php include 'app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>
    <script>
        // Countdown Timer
        function updateCountdown() {
            const launchDate = new Date('<?php echo $launch_date; ?>').getTime();
            const now = new Date().getTime();
            const distance = launchDate - now;

            if (distance < 0) {
                document.getElementById('countdown').innerHTML = '<div class="time-unit"><span class="time-number">🎉</span><span class="time-label">Launched!</span></div>';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        }

        // Update countdown every second
        setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call

        // Add entrance animations to feature cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.feature-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150 + 800);
            });
        });

        // Enhanced back button functionality
        document.querySelector('.back-btn').addEventListener('click', function(e) {
            e.preventDefault();
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/wallet'; // Fallback URL
            }
        });
    </script>
</body>
</html>