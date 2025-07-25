<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>atPay Business - Register</title>
<link rel="stylesheet" href="register_style.css">
</head>
<body>
    
    <div class="register-container">
        <!-- Left Side - Image Section -->
        <div class="image-section">
            <div class="content-wrapper">
                <div class="security-badge">
                    <div class="security-icon"></div>
                    Secure Every Aspect of Your Business
                </div>
                
                <h1 class="main-heading">Join atPay Wallet Today</h1>
                
                <p class="description">
                    Start your journey with our comprehensive payment solution. Simple setup, powerful features, and dedicated support for your business growth.
                </p>
                
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">5min</div>
                        <div class="stat-label">Quick Setup Process</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Customer Support Available</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="register-section">
            <div class="logo-section">
               <div class="logo"><img src="../images/logo.png" style=" width: 50px; height: 50px;" alt="atPay Logo"></div>
                <span class="brand-name">atPay Wallet</span>
            </div>

            <h2 class="register-title">Create Account</h2>

            <form id="registerForm">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">First Name *</label>
                        <input 
                            type="text" 
                            class="form-input" 
                            placeholder="Enter your first name"
                            id="firstName"
                            required
                        >
                        <div class="validation-message" id="firstNameError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name *</label>
                        <input 
                            type="text" 
                            class="form-input" 
                            placeholder="Enter your last name"
                            id="lastName"
                            required
                        >
                        <div class="validation-message" id="lastNameError"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Business Name *</label>
                    <input 
                        type="text" 
                        class="form-input" 
                        placeholder="Enter your business name"
                        id="businessName"
                        required
                    >
                    <div class="validation-message" id="businessNameError"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input 
                            type="email" 
                            class="form-input" 
                            placeholder="Enter your email address"
                            id="email"
                            required
                        >
                        <div class="validation-message" id="emailError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number *</label>
                        <input 
                            type="tel" 
                            class="form-input" 
                            placeholder="Enter your phone number"
                            id="phone"
                            required
                        >
                        <div class="validation-message" id="phoneError"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Business Type *</label>
                        <select class="form-select" id="businessType" required>
                            <option value="">Select business type</option>
                            <option value="retail">Retail</option>
                            <option value="restaurant">Restaurant</option>
                            <option value="service">Service Provider</option>
                            <option value="ecommerce">E-commerce</option>
                            <option value="healthcare">Healthcare</option>
                            <option value="education">Education</option>
                            <option value="other">Other</option>
                        </select>
                        <div class="validation-message" id="businessTypeError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Country *</label>
                        <select class="form-select" id="country" required>
                            <option value="">Select country</option>
                            <option value="NG">Nigeria</option>
                            <option value="GH">Ghana</option>
                            <option value="KE">Kenya</option>
                            <option value="ZA">South Africa</option>
                            <option value="EG">Egypt</option>
                            <option value="other">Other</option>
                        </select>
                        <div class="validation-message" id="countryError"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            class="form-input" 
                            placeholder="Create a strong password"
                            id="password"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            👁️
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthBar"></div>
                        </div>
                        <span id="strengthText">Password strength</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password *</label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            class="form-input" 
                            placeholder="Confirm your password"
                            id="confirmPassword"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                            👁️
                        </button>
                    </div>
                    <div class="validation-message" id="confirmPasswordError"></div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input" id="terms" required>
                    <label class="checkbox-label" for="terms">
                        I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>
                    </label>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input" id="newsletter">
                    <label class="checkbox-label" for="newsletter">
                        I would like to receive updates and promotional emails about atPay services
                    </label>
                </div>

                <button type="submit" class="register-button" id="submitBtn">
                    Create Account
                </button>

                <div class="login-section">
                    <span>Already have an account?</span>
                    <a href="#" class="login-link">Sign in</a>
                </div>
            </form>

            <div class="copyright">
                © 2025 atPay. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleButton = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            let text = '';
            let className = '';

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    text = 'Weak password';
                    className = 'strength-weak';
                    break;
                case 2:
                    text = 'Fair password';
                    className = 'strength-fair';
                    break;
                case 3:
                case 4:
                    text = 'Good password';
                    className = 'strength-good';
                    break;
                case 5:
                    text = 'Strong password';
                    className = 'strength-strong';
                    break;
            }

            return { strength, text, className };
        }

        function validateField(fieldId, validator, errorId) {
            const field = document.getElementById(fieldId);
            const errorDiv = document.getElementById(errorId);
            const result = validator(field.value);
            
            if (result.isValid) {
                field.style.borderColor = 'var(--success-green)';
                errorDiv.textContent = '';
                errorDiv.style.display = 'none';
            } else {
                field.style.borderColor = 'var(--error-red)';
                errorDiv.textContent = result.message;
                errorDiv.className = 'validation-message error';
                errorDiv.style.display = 'block';
            }
            
            return result.isValid;
        }

        // Validation functions
        const validators = {
            firstName: (value) => ({
                isValid: value.trim().length >= 2,
                message: 'First name must be at least 2 characters'
            }),
            lastName: (value) => ({
                isValid: value.trim().length >= 2,
                message: 'Last name must be at least 2 characters'
            }),
            businessName: (value) => ({
                isValid: value.trim().length >= 2,
                message: 'Business name must be at least 2 characters'
            }),
            email: (value) => ({
                isValid: /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                message: 'Please enter a valid email address'
            }),
            phone: (value) => ({
                isValid: /^[\+]?[0-9\s\-\(\)]{10,}$/.test(value),
                message: 'Please enter a valid phone number'
            }),
            businessType: (value) => ({
                isValid: value !== '',
                message: 'Please select a business type'
            }),
            country: (value) => ({
                isValid: value !== '',
                message: 'Please select a country'
            })
        };

        // Real-time validation
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const result = checkPasswordStrength(password);
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            strengthBar.className = 'strength-fill ' + result.className;
            strengthText.textContent = result.text;
        });

        document.getElementById('confirmPassword').addEventListener('blur', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = e.target.value;
            const errorDiv = document.getElementById('confirmPasswordError');
            
            if (confirmPassword && password !== confirmPassword) {
                e.target.style.borderColor = 'var(--error-red)';
                errorDiv.textContent = 'Passwords do not match';
                errorDiv.className = 'validation-message error';
                errorDiv.style.display = 'block';
            } else if (confirmPassword) {
                e.target.style.borderColor = 'var(--success-green)';
                errorDiv.style.display = 'none';
            }
        });

        // Add blur event listeners for real-time validation
        Object.keys(validators).forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', () => {
                    validateField(fieldId, validators[fieldId], fieldId + 'Error');
                });
            }
        });

        // Form submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            
            // Validate all fields
            Object.keys(validators).forEach(fieldId => {
                if (!validateField(fieldId, validators[fieldId], fieldId + 'Error')) {
                    isValid = false;
                }
            });
            
            // Check password confirmation
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                isValid = false;
                const errorDiv = document.getElementById('confirmPasswordError');
                errorDiv.textContent = 'Passwords do not match';
                errorDiv.className = 'validation-message error';
                errorDiv.style.display = 'block';
            }
            
            // Check terms agreement
            if (!document.getElementById('terms').checked) {
                isValid = false;
                alert('Please agree to the Terms of Service and Privacy Policy');
            }
            
            if (isValid) {
                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.textContent = 'Creating Account...';
                submitBtn.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    alert('Account created successfully! Welcome to atPay Wallet.');
                    submitBtn.textContent = 'Create Account';
                    submitBtn.disabled = false;
                }, 2000);
            }
        });
    </script>
</body>
</html>