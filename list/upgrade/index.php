<?php
session_start();

// Define plans
$plans = [
    'basic' => [
        'title' => 'Basic Plan',
        'description' => 'Access the essential features to get started',
        'price' => 5000,
        'duration' => 'Year',
        'features' => ['Essential features access', 'Standard support', 'Basic analytics', 'Monthly updates']
    ],
    'premium' => [
        'title' => 'Premium Plan',
        'description' => 'All features unlocked with priority support',
        'price' => 15000,
        'duration' => 'Year',
        'features' => ['All features unlocked', 'Priority support', 'Advanced analytics', 'Weekly updates', 'Custom integrations'],
        'featured' => true
    ],
    'ultimate' => [
        'title' => 'Ultimate Plan',
        'description' => 'Ultimate access with all features and priority support',
        'price' => 30000,
        'duration' => 'Year',
        'features' => ['Ultimate access', '24/7 dedicated support', 'Premium analytics', 'Real-time updates', 'Custom integrations', 'White-label options']
    ]
];

// Handle AJAX plan selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'select_plan') {
    $selectedPlan = $_POST['plan'] ?? '';
    if (array_key_exists($selectedPlan, $plans)) {
        $_SESSION['selected_plan'] = $plans[$selectedPlan];
        $_SESSION['selected_plan_key'] = $selectedPlan; // Optional: save the key
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Plan selected']);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid plan selected']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Plan</title>
           <link rel="icon" type="image/png" href="../../images/logo.png">

   <link rel="stylesheet" href="index.css">
</head>
<body>
    <!-- Top Navigation -->
   <?php include '../../include/user_top_navbar.php';?>
    <!-- Main Container -->
    <div class="container">
        <div id="alert-container"></div>

        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">Choose Your Perfect Plan</h1>
            <p class="hero-subtitle">Select the plan that best fits your needs and unlock premium features</p>
        </div>

        <!-- Plans Section -->
        <div class="plans-section">
            <h2 class="section-title">Choose Your Plan</h2>
            <div class="plans-grid">
                <?php foreach ($plans as $key => $plan): ?>
                    <div class="plan-card <?= isset($plan['featured']) ? 'featured' : '' ?>" data-plan="<?= $key ?>">
                        <?php if (isset($plan['featured'])): ?>
                            <div class="plan-badge">Most Popular</div>
                        <?php endif; ?>
                        <div class="plan-title"><?= htmlspecialchars($plan['title']) ?></div>
                        <div class="plan-description"><?= htmlspecialchars($plan['description']) ?></div>
                        <div class="plan-price">₦<?= number_format($plan['price']) ?></div>
                        <div class="plan-duration">/ <?= htmlspecialchars($plan['duration']) ?></div>
                        <ul class="plan-features">
                            <?php foreach ($plan['features'] as $feature): ?>
                                <li><?= htmlspecialchars($feature) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
            <button id="continue-btn" class="continue-btn" disabled onclick="showConfirmation()">Continue to Pay</button>
        </div>
    </div>

    <!-- Confirmation Dialog -->
    <div id="confirmation-dialog" class="confirmation-dialog">
        <div class="confirmation-title">Confirm Plan Upgrade</div>
        <div id="confirmation-details" class="confirmation-details"></div>
        <div class="confirmation-buttons">
            <button class="confirm-btn" onclick="confirmUpgrade()">Confirm</button>
            <button class="cancel-btn" onclick="hideConfirmation()">Cancel</button>
        </div>
    </div>

    

 <script>
    const planCards = document.querySelectorAll('.plan-card');
    const continueBtn = document.getElementById('continue-btn');
    const alertContainer = document.getElementById('alert-container');
    const confirmationDialog = document.getElementById('confirmation-dialog');
    const confirmationDetails = document.getElementById('confirmation-details');

    let selectedPlan = null;
    let isLoading = false;

    // Add number formatting function
    function number_format(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Add staggered animation to plan cards
    planCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });

    // Plan selection
    planCards.forEach(card => {
        card.addEventListener('click', function() {
            if (isLoading) return;

            planCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedPlan = this.dataset.plan;
            continueBtn.disabled = false;

            // Add selection feedback
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
    });

    // Show confirmation dialog
    function showConfirmation() {
        if (!selectedPlan) {
            showAlert('Please select a plan', 'error');
            return;
        }

        const plan = <?php echo json_encode($plans); ?>;
        const selectedPlanData = plan[selectedPlan];
        confirmationDetails.innerHTML = `
            You are about to upgrade to the <strong>${selectedPlanData.title}</strong> plan for <strong>₦${number_format(selectedPlanData.price)}</strong> per ${selectedPlanData.duration}.
        `;
        confirmationDialog.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when dialog is open
    }

    // Hide confirmation dialog
    function hideConfirmation() {
        confirmationDialog.classList.remove('active');
        document.body.style.overflow = ''; // Re-enable scrolling
    }

    // Confirm upgrade and proceed to payment
    function confirmUpgrade() {
        if (isLoading) return;

        isLoading = true;
        hideConfirmation();
        continueBtn.innerHTML = '<span class="loading-spinner"></span>Processing...';
        continueBtn.disabled = true;

        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=select_plan&plan=' + encodeURIComponent(selectedPlan)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Upgrade confirmed! Redirecting to payment...', 'success');
                setTimeout(() => {
                    window.location.href = 'payment.php?plan=' + encodeURIComponent(selectedPlan);
                }, 1500);
            } else {
                showAlert(data.message || 'Failed to confirm upgrade', 'error');
                resetButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Network error. Please try again.', 'error');
            resetButton();
        });
    }

    function resetButton() {
        isLoading = false;
        continueBtn.innerHTML = 'Continue to Pay';
        continueBtn.disabled = !selectedPlan;
    }

    // Show alert message
    function showAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <span>${type === 'success' ? '✓' : '⚠'}</span>
                <span>${message}</span>
            </div>
        `;
        alertContainer.innerHTML = '';
        alertContainer.appendChild(alert);
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.animation = 'fadeInUp 0.3s ease-out reverse';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Go back function
    function goBack() {
        if (isLoading) return;
        window.history.back();
    }

    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (isLoading) return;
        
        if (e.key === 'Enter' && selectedPlan) {
            showConfirmation();
        } else if (e.key === 'Escape') {
            if (confirmationDialog.classList.contains('active')) {
                hideConfirmation();
            } else {
                goBack();
            }
        } else if (e.key >= '1' && e.key <= '3') {
            const cardIndex = parseInt(e.key) - 1;
            if (planCards[cardIndex]) {
                planCards[cardIndex].click();
            }
        }
    });

    // Enhanced hover effects
    planCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.classList.contains('selected') && !isLoading) {
                this.style.transform = 'translateY(-5px) scale(1.01)';
            }
        });

        card.addEventListener('mouseleave', function() {
            if (!this.classList.contains('selected') && !isLoading) {
                this.style.transform = 'translateY(0) scale(1)';
            }
        });
    });
</script>
      <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>
</body>
</html>