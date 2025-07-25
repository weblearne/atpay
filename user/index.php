<?php


$balance = "1,000";
$accountNumber = "0000000000";
$accountName = "Web Learner";
$bankName = "Palmpay";




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

      <script src="https://cdn.tailwindcss.com"></script>
      <link rel="stylesheet" href="user_style.css">

</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="logo"><img src="../images/logo.png" style="width:50px; height:50px; border-radius:50px;" alt=""></div>
        <div class="nav-icons">
            <button class="balance-btn" onclick="toggleBalanceModal()">
                Balance: ₦ <?php echo $balance; ?>
            </button>
    
            <button class="nav-icon" onclick="showNotifications()">
                  <i class="fa-solid fa-house"></i>
                <span class="notification-badge">3</span>
            </button>
            <button class="nav-icon" onclick="openCustomerCare()">
                   <i class="fa-solid fa-house"></i>
            </button>
        </div>
    </nav>

    <!-- Balance Modal -->
    <div id="balanceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Fund Your Wallet</h3>
                <button class="close" onclick="toggleBalanceModal()">&times;</button>
            </div>
            <div class="account-item">
                <strong>Bank Transfer</strong><br>
                <small>Account: <?php echo $accountNumber; ?></small><br>
                <small>Bank:<?php echo $bankName; ?></small>
            </div>
   
            <div class="account-item">
                <strong>USSD</strong><br>
                <small>not available </small>
            </div>
        </div>
    </div>

   <!-- Banner Slider -->
  <div class="relative overflow-hidden">
    <div id="banner-slider" class="banner-slider">
      <div class="banner-slide">
        <img src="../images/bg2.png" alt="Ad Banner 1" class="w-full h-48 object-cover">
      </div>
      <div class="banner-slide">
        <img src="../images/atpay.png" alt="Ad Banner 2" class="w-full h-48 object-cover">
      </div>
      <div class="banner-slide">
        <img src="https://via.placeholder.com/1200x300?text=Ad+Banner+3" alt="Ad Banner 3" class="w-full h-48 object-cover">
      </div>
    </div>
    <button id="prev-banner" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-[var(--primary-color)] text-[var(--secondary-color)] p-2 rounded-full">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
    </button>
    <button id="next-banner" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-[var(--primary-color)] text-[var(--secondary-color)] p-2 rounded-full">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>


      <main>

  <!-- Other Actions Section -->
  <section>
    <h2 class="section-header">Other Actions</h2>
    <div class="grid-4">
      <div class="grid-item" onclick="addMore()" role="button">
        <div class="grid-item-icon">➕</div>
        <div class="grid-item-title">Add More</div>
      </div>
      <div class="grid-item" onclick="sendGift()" role="button">
              <i class="fa-solid fa-house"></i>
        <div class="grid-item-title">Send Gift</div>
      </div>
      <div class="grid-item" onclick="upgrade()" role="button">
        <div class="grid-item-icon">⬆️</div>
        <div class="grid-item-title">Upgrade</div>
      </div>
      <div class="grid-item" onclick="invite()" role="button">
        <div class="grid-item-icon">👥</div>
        <div class="grid-item-title">Invite</div>
      </div>
    </div>
  </section>

  <!-- Quick Access Section -->
  <section>
    <h2 class="section-header">Quick Access</h2>
    <div class="grid-3">
      <div class="grid-item" onclick="goToBalance()" role="button">
        <div class="grid-item-icon">💰</div>
        <div class="grid-item-title">Balance</div>
      </div>
      <div class="grid-item" onclick="openContacts()" role="button">
        <div class="grid-item-icon">📱</div>
        <div class="grid-item-title">Contacts</div>
      </div>
      <div class="grid-item" onclick="voiceCall()" role="button">
        <div class="grid-item-icon">📞</div>
        <div class="grid-item-title">Voice Call</div>
      </div>
    </div>
  </section>

  <!-- Recharge and Pay Bills Section -->
  <section>
    <h2 class="section-header">Recharge and Pay Bills</h2>
    <div class="grid-4">
      <div class="grid-item" onclick="payElectricity()" role="button">
        <div class="grid-item-icon">⚡</div>
        <div class="grid-item-title">Electricity</div>
      </div>
      <div class="grid-item" onclick="payCable()" role="button">
        <div class="grid-item-icon">📺</div>
        <div class="grid-item-title">Cable TV</div>
      </div>
      <div class="grid-item" onclick="buyData()" role="button">
        <div class="grid-item-icon">📊</div>
        <div class="grid-item-title">Data</div>
      </div>
      <div class="grid-item" onclick="buyAirtime()" role="button">
        <div class="grid-item-icon">📲</div>
        <div class="grid-item-title">Airtime</div>
      </div>
      <div class="grid-item" onclick="buyEsim()" role="button">
        <div class="grid-item-icon">📟</div>
        <div class="grid-item-title">eSIM</div>
      </div>
      <div class="grid-item" onclick="buySmile()" role="button">
        <div class="grid-item-icon">😊</div>
        <div class="grid-item-title">Smile</div>
      </div>
      <div class="grid-item" onclick="buyExamPin()" role="button">
        <div class="grid-item-icon">📝</div>
        <div class="grid-item-title">Exam Pin</div>
      </div>
      <div class="grid-item" onclick="showMore()" role="button">
        <div class="grid-item-icon">⋯</div>
        <div class="grid-item-title">More</div>
      </div>
    </div>
  </section>

  <!-- Floating Chat Button -->
  <button class="chat-btn" onclick="openChat()" aria-label="Chat">
        <i class="fa-solid fa-house"></i>
  </button>

</main>


    <!-- Bottom Navigation -->
   <nav class="bottom-nav">
    <a href="#" class="nav-item">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>
    <a href="#" class="nav-item">
        <i class="fa-solid fa-gear"></i>
        <span>Services</span>
    </a>
    <a href="#" class="nav-item">
        <i class="fa-solid fa-wallet"></i>
        <span>Wallet</span>
    </a>
    <a href="#" class="nav-item">
        <i class="fa-solid fa-clock-rotate-left"></i>
        <span>History</span>
    </a>
    <a href="#" class="nav-item">
        <i class="fa-solid fa-user"></i>
        <span>Me</span>
    </a>
</nav>


    <script>
        // Balance Modal Functions
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

        // Banner Slider
    const slider = document.getElementById('banner-slider');
    const prevBtn = document.getElementById('prev-banner');
    const nextBtn = document.getElementById('next-banner');
    let currentSlide = 0;
    const slides = slider.children;
    const totalSlides = slides.length;

    function showSlide(index) {
      if (index < 0) index = totalSlides - 1;
      if (index >= totalSlides) index = 0;
      slider.style.transform = `translateX(-${index * 100}%)`;
      currentSlide = index;
    }

    prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
    nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));

    // Auto-slide every 5 seconds
    setInterval(() => showSlide(currentSlide + 1), 5000);

        // Navigation Functions
        function openScanner() {
            alert('Opening QR/Barcode Scanner...');
        }

        function showNotifications() {
            alert('Showing notifications...');
        }

        function openCustomerCare() {
            alert('Connecting to customer care...');
        }

        function openChat() {
            alert('Opening in-app chat with customer care...');
        }

        // Other Actions Functions
        function addMore() {
            alert('Add more funds to your account...');
        }

        function sendGift() {
            alert('Send gift to friends...');
        }

        function upgrade() {
            alert('Upgrade your account...');
        }

        function invite() {
            alert('Invite friends to join...');
        }

        // Quick Access Functions
        function goToBalance() {
            alert('Redirecting to balance page...');
            // Simulate page redirect
            window.location.href = '#balance-page';
        }

        function openContacts() {
            alert('Opening contacts...');
        }

        function voiceCall() {
            alert('Starting voice call...');
        }

        // Bill Payment Functions
        function payElectricity() {
            alert('Pay electricity bills...');
        }

        function payCable() {
            alert('Pay cable TV bills...');
        }

        function buyData() {
            alert('Buy data bundle...');
        }

        function buyAirtime() {
            alert('Buy airtime...');
        }

        function buyEsim() {
            alert('Buy eSIM...');
        }

        function buySmile() {
            alert('Buy Smile data...');
        }

        function buyExamPin() {
            alert('Buy exam pin...');
        }

        function showMore() {
            alert('Show more services...');
        }

        // Bottom Navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Simple banner rotation
        const banners = [
            { title: '🎉 Special Offer!', subtitle: 'Get 10% bonus on all transactions this week' },
            { title: '💳 New Feature!', subtitle: 'Virtual cards now available for online shopping' },
            { title: '🎯 Cashback!', subtitle: 'Earn 5% cashback on bill payments' }
        ];

        let currentBanner = 0;
        setInterval(() => {
            currentBanner = (currentBanner + 1) % banners.length;
            const banner = banners[currentBanner];
            document.querySelector('.ad-content h2').textContent = banner.title;
            document.querySelector('.ad-content p').textContent = banner.subtitle;
        }, 5000);
    </script>
</body>
</html>