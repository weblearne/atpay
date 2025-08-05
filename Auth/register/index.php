<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>atPay Wallet Register</title>
<link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- <nav class="top-nav">
        <div class="nav-left">
            <a href="#" class="back-btn">← Back</a>
        </div>
        <div class="nav-brand">atPay Wallet</div>
    </nav> -->
    <!--?php include '../include/navbar.php'?-->

    <div class="main-container">
        <div class="login-container">
            <div class="logo">
                <img src="../../images/logo.png" alt="atPay Wallet Logo">
            </div>
            <h2>Register</h2>

            <div id="messageContainer"></div>

            <form id="registerForm" method="POST" action="#">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                </div>
                <button type="submit">Register</button>
                <div class="login-link">Already have an account? <a href="../login/">Login</a></div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirmPassword').value.trim();
            const messageContainer = document.getElementById('messageContainer');

            // Clear previous messages
            messageContainer.innerHTML = '';

            let errorMessage = '';

            if (fullName === '' || email === '' || phone === '' || password === '' || confirmPassword === '') {
                errorMessage = 'Please fill in all fields.';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errorMessage = 'Invalid email format.';
            } else if (!/^\d{3,}$/.test(phone)) {
                errorMessage = 'Phone number must be at least 3 digits.';
            } else if (password.length < 4) {
                errorMessage = 'Password must be at least 4 characters.';
            } else if (password !== confirmPassword) {
                errorMessage = 'Passwords do not match.';
            }

            if (errorMessage) {
                messageContainer.innerHTML = `<div class="message error">${errorMessage}</div>`;
                messageContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                return;
            }

            // Simulate successful registration
            messageContainer.innerHTML = '<div class="message success">Registration successful! Redirecting...</div>';
            messageContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            // Simulate redirect after 2 seconds
            setTimeout(() => {
                // window.location.href = 'login.php';
                console.log('Would redirect to login.php');
            }, 2000);
        });

        // Add back button functionality
        document.querySelector('.back-btn').addEventListener('click', function(e) {
            e.preventDefault();
            // window.history.back();
            console.log('Back button clicked');
        });
    </script>
</body>
</html>