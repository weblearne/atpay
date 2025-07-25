
<?php
  include '../include/home_top_nav_bar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>atPay Business - Login</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
 

    <div class="login-container">
        <!-- Left Side - Image Section -->
        <div class="image-section">
            <div class="content-wrapper">
                <div class="security-badge">
                    <div class="security-icon"></div>
                    Secure Every Aspect of Your Business
                </div>
                
                <h1 class="main-heading">Boost your Business with atPay Wallet</h1>
                
                <p class="description">
                    Our simple, all-in-one solution for payments, banking and operations, helps businesses of all sizes to grow and succeed.
                </p>
                
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">With an impressive Success Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">600k+</div>
                        <div class="stat-label">Cater to the financial need of Merchants</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-section">
            <div class="logo-section">
                <div class="logo"><img src="../images/logo.png" alt="atPay Logo"></div>
                <span class="brand-name">atPay Wallet</span>
            </div>

            <h2 class="login-title">Login</h2>

            <form>
                <div class="form-group">
                    <label class="form-label">Email or Phone Number</label>
                    <input 
                        type="text" 
                        class="form-input" 
                        placeholder="Please enter your email or phone number"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            class="form-input" 
                            placeholder="Please enter your password"
                            id="password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            👁️
                        </button>
                    </div>
                </div>

                <div class="forgot-password">
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="login-button">Login</button>

                <div class="signup-section">
                    <span>Don't have an account?</span>
                    <a href="#" class="signup-link">Sign up</a>
                </div>
            </form>

            <div class="copyright">
                © 2025 atPay. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }

        // Form submission handler
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your login logic here
            console.log('Login attempt');
        });
    </script>
</body>
</html>
