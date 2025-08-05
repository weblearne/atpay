<style>
     /* Top Navigation */
        .top-nav {
            background: var(--primary-color);
            color: var(--secondary-color);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-icons {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-icon {
            background: none;
            border: none;
            color: var(--secondary-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background-color 0.3s;
            position: relative;
        }

        .nav-icon:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

                    .balance-btn {
                    background: var(--secondary-color);
                    border: none;
                    color: var(--text-primary);
                    padding: 0.5rem 1rem;
                    border-radius: 0.5rem;
                    cursor: pointer;
                    font-weight: 500;
                    transition: background-color 0.3s;
                    /* Removed float: right */
                }

                .balance-btn:hover {
                    background-color: var(--primary-color);
                    color: #ffffff;
                }


        /* Account Numbers Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background: var(--secondary-color);
            margin: 15% auto;
            padding: 2rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-secondary);
        }

        .account-item {
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            background: #f9fafb;
        }
</style>

<!-- Top Navigation -->
<nav class="top-nav" style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 1rem;">
  <!-- Left: Logo and Balance -->
  <div class="logo-balance" style="display: flex; align-items: center; gap: 1rem;">
    <div class="logo" >
      <a href="../list/profile2/">  <img src="../images/logo.png" style="width: 50px; height: 50px; border-radius: 50%;" alt="Logo" ></a>
    
    </div>
    <button class="balance-btn" onclick="toggleBalanceModal()">
      Balance: ₦ <?php echo $balance; ?>
    </button>
  </div>

  <!-- Right: Action Icons -->
  <div class="nav-icons" style="display: flex; align-items: center; gap: 1rem;">
    <button class="nav-icon" onclick="showNotifications()">
      <i class="fas fa-bell"></i>
      <span class="notification-badge">3</span>
    </button>
    <button class="nav-icon" onclick="openCustomerCare()">
      <i class="fas fa-headset"></i>
    </button>
  </div>
</nav>
<script>
          function toggleBalanceModal() {
            const modal = document.getElementById('balanceModal');
            modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('balanceModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
          function openScanner() {
            alert('Opening QR/Barcode Scanner...');
        }

        function showNotifications() {
          window.location.href = 'notification/';
        }

        function openCustomerCare() {
          window.location.href='../user/chat/';
        }
</script>