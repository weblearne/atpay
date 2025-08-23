<?php
// Start the session
session_start();

// Check if token exists in session
if (!isset($_SESSION['atpay_auth_token_key'])) {
    header("Location: ../Auth/login");
    exit();
}

$response = "";

// Fetch user info function
function fetchUserInfo($token) {
    $endpoint = "https://atpay.ng/api/user/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Token $token"
    ]);

    // Explicitly set the request method
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

    // If API needs POST body (even if empty)
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    }

    curl_close($ch); 

    return json_decode($result, true);
}

// Get user info from API
$response = fetchUserInfo($_SESSION['atpay_auth_token_key']);

// Check API response
if (isset($response['error']) && $response['error'] === false) {
    // Wallet info
    $wallet = $response['wallets'][0] ?? [];
    $user_balance   = $wallet['AccountBalance'] ?? "N0.0";
    $user_bonus     = $wallet['AccountBonus'] ?? "N0.0";
    $user_debt      = $wallet['AccountDeft'] ?? "N0.0";

    // Accounts (first one as default)
    $account = $response['accounts'][0] ?? [];
    $bank_name      = $account['BnakName'] ?? "N/A";
    $account_name   = $account['AccName'] ?? "N/A";
    $account_number = $account['AccNumber'] ?? "N/A";

} else {
    $user_balance   = "N0.0";
    $user_bonus     = "N0.0";
    $user_debt      = "N0.0";
    $bank_name      = "N/A";
    $account_name   = "N/A";
    $account_number = "N/A";

    // If token invalid, logout
    if (isset($response['message']) && stripos($response['message'], 'unauthorized') !== false) {
        session_destroy();
        header("Location: ../Auth/login/?error=SessionExpired");
        exit();
    }
}

// Include navbar
include 'user_top_nav_bar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
   <link rel="icon" type="image/png" href="../images/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="user_style.css" />
   

</head>
<body>


<!-- Balance Modal -->
<div id="balanceModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Fund Your Wallet</h3>
      <button class="close" onclick="toggleBalanceModal()">&times;</button>
    </div>
    
    <div class="account-container">
      <?php if (!empty($response['accounts'])): ?>
        <div class="bank-accounts">
          <?php foreach ($response['accounts'] as $acc): ?>
            <div class="account-item">
              <strong>Bank Transfer</strong><br>
              <small>Account: <?php echo htmlspecialchars($acc['AccNumber']); ?></small><br>
              <small>Account Name: <?php echo htmlspecialchars($acc['AccName']); ?></small><br>
              <small>Bank: <?php echo htmlspecialchars($acc['BnakName']); ?></small>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="account-item">
          <strong>No Bank Accounts Available</strong>
        </div>
      <?php endif; ?>
      
      <!-- div class="account-item ussd-section">
        <strong>USSD</strong><br>
        <small>not available</small>
      </div> -->
    </div>
  </div>
</div>


<!-- Banner Slider -->
<div class="relative overflow-hidden" style="border-radius: 0px; height:140px; margin: 3px">
  <div id="banner-slider" class="banner-slider flex transition-transform duration-300" style="border-radius: 0px; height: 140px;">
    
    <div class="banner-slide" style="border-radius: 0px; height:140px;">
      <img src="../images/bg2.png" alt="Ad Banner 1" class="w-full h-full object-cover" style="border-radius: 0px;" />
    </div>

    <!-- Second banner (optional) -->
    <!--
    <div class="banner-slide" style="border-radius: 0px; height:140px;">
      <img src="../images/atpay.png" alt="Ad Banner 2" class="w-full h-full object-cover" style="border-radius: 0px;" />
    </div>
    -->

    <div class="banner-slide" style="border-radius: 0px; height:140px;">
      <img src="https://atpay.ng/web/control/assets/images/banner833_9014.png" alt="Ad Banner 3" class="w-full h-full object-cover" style="border-radius: 0px;" />
    </div>
  </div>

  <button id="prev-banner" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-purple-600 text-white p-2 rounded-full">
    <i class="fas fa-chevron-left"></i>
  </button>
  <button id="next-banner" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-purple-600 text-white p-2 rounded-full">
    <i class="fas fa-chevron-right"></i>
  </button>
</div>


<main style="margin: 9px;">
  <!-- Other Actions Section -->
  <section>
    <!--<h2 class="section-header">Other Actions</h2>-->
    <div class="grid-4">
      <div class="grid-item" onclick="addMore()" role="button" >
     <i class="fa-solid fa-plus" ></i>
        <div class="grid-item-title">Add Money</div>
      </div>
      <!--<div class="grid-item" onclick="sendGift()" role="button">-->
      <!--  <i class="fas fa-gift"></i>-->
      <!--  <div class="grid-item-title">Send Gift</div>-->
      <!--</div>-->
   <!--   <div class="grid-item" onclick="upgrade()" role="button">-->
   <!--<i class="fa-solid fa-arrow-up"></i>-->
   <!--     <div class="grid-item-title">Upgrade</div>-->
   <!--   </div>-->
      <div class="grid-item" onclick="invite()" role="button">
<i class="fa-solid fa-share-nodes"></i>
        <div class="grid-item-title">Invite</div>
      </div>
    </div>
  </section>

  <!-- Quick Access Section -->
  <!-- <section>
    <h2 class="section-header">Quick Access</h2>
    <div class="grid-3">
      <div class="grid-item" onclick="goToBalance()" role="button">
        <div class="grid-item-icon"><i class="fas fa-wallet"></i></div>
        <div class="grid-item-title">Balance</div>
      </div>
      <div class="grid-item" onclick="openContacts()" role="button">
        <div class="grid-item-icon"><i class="fas fa-address-book"></i></div>
        <div class="grid-item-title">Contacts</div>
      </div>
      <div class="grid-item" onclick="voiceCall()" role="button">
        <div class="grid-item-icon"><i class="fas fa-phone"></i></div>
        <div class="grid-item-title">Voice Call</div>
      </div>
    </div>
  </section> -->

  <!-- Recharge and Pay Bills Section -->
  <section>
    <h2 class="section-header">Recharge and Pay Bills</h2>
    <div class="grid-4">
      <div class="grid-item" onclick="payElectricity()" role="button">
        <div class="grid-item-icon"><i class="fas fa-bolt"></i></div>
        <div class="grid-item-title">Electricity</div>
      </div>
      <div class="grid-item" onclick="payCable()" role="button">
        <div class="grid-item-icon"><i class="fas fa-tv"></i></div>
        <div class="grid-item-title">Cable TV</div>
      </div>
      <div class="grid-item" onclick="buyData()" role="button">
        <div class="grid-item-icon"><i class="fas fa-signal"></i></div>
        <div class="grid-item-title">Data</div>
      </div>
      <div class="grid-item" onclick="buyAirtime()" role="button">
        <div class="grid-item-icon"><i class="fas fa-phone"></i></div>
        <div class="grid-item-title">Airtime</div>
      </div>
      <div class="grid-item" onclick="buyEsim()" role="button">
        <div class="grid-item-icon"><i class="fas fa-sim-card"></i></div>
        <div class="grid-item-title">eSIM</div>
      </div>
      <div class="grid-item" onclick="buySmile()" role="button">
        <div class="grid-item-icon"><i class="fas fa-signal"></i></div>
        <div class="grid-item-title">Smile</div>
      </div>
      <div class="grid-item" onclick="buyExamPin()" role="button">
        <div class="grid-item-icon"><i class="fas fa-pen"></i></div>
        <div class="grid-item-title">Exam Pin</div>
      </div>
      <div class="grid-item" onclick="showMore()" role="button">
        <div class="grid-item-icon"><i class="fas fa-ellipsis-h"></i></div>
        <div class="grid-item-title">More</div>
      </div>
    </div>
  </section>

  <!-- Floating Chat Button -->
  <!-- Chat Button -->
<button class="chat-btn" id="chat-btn" onclick="toggleChatOptions()" aria-label="Open chat options" aria-expanded="false">
        <i class="fas fa-comment-dots"></i>
        <span class="sr-only">Open chat options</span>
    </button>

    <!-- Dropdown Chat Options -->
    <div id="chat-options" class="chat-options">
        <ul>
            <li onclick="redirectTo('whatsapp')" role="button" tabindex="0" aria-label="Chat via WhatsApp">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </li>
            <li onclick="redirectTo('inapp')" role="button" tabindex="0" aria-label="Open in-app chat">
                <i class="fas fa-comments"></i> In-App Chat
            </li>
            <li onclick="redirectTo('email')" role="button" tabindex="0" aria-label="Send an email">
                <i class="fas fa-envelope"></i> Email
            </li>
        </ul>
    </div>

</main>
<br><br><br>
    <footer>
     <?php include '../include/footer.php'?>
    </footer>

<!-- Scripts -->
<script>
   // Balance Modal Functions
function toggleBalanceModal() {
  const modal = document.getElementById('balanceModal');
  
  if (modal.style.display === 'block' || modal.classList.contains('show')) {
    // Hide modal
    modal.classList.remove('show');
    setTimeout(() => {
      modal.style.display = 'none';
    }, 300); // Wait for animation to complete
  } else {
    // Show modal
    modal.style.display = 'block';
    setTimeout(() => {
      modal.classList.add('show');
    }, 10); // Small delay to trigger animation
    
    // Ensure modal content is properly positioned
    adjustModalPosition();
  }
}

function adjustModalPosition() {
  const modal = document.getElementById('balanceModal');
  const modalContent = modal.querySelector('.modal-content');
  
  // Reset any inline styles that might interfere
  modalContent.style.marginTop = '';
  
  // Calculate proper positioning
  const viewportHeight = window.innerHeight;
  const modalHeight = modalContent.offsetHeight;
  
  // If modal is taller than viewport, position at top with scroll
  if (modalHeight > viewportHeight * 0.9) {
    modalContent.style.top = '5%';
    modalContent.style.transform = 'translateY(0)';
    modalContent.style.maxHeight = '90vh';
  } else {
    // Center the modal vertically
    modalContent.style.top = '50%';
    modalContent.style.transform = 'translateY(-50%)';
  }
}

// Close modal when clicking outside of it
document.addEventListener('click', function(event) {
  const modal = document.getElementById('balanceModal');
  const modalContent = modal.querySelector('.modal-content');
  
  if (event.target === modal) {
    toggleBalanceModal();
  }
});

// Handle window resize to adjust modal position
window.addEventListener('resize', function() {
  const modal = document.getElementById('balanceModal');
  if (modal.style.display === 'block' || modal.classList.contains('show')) {
    adjustModalPosition();
  }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    const modal = document.getElementById('balanceModal');
    if (modal.style.display === 'block' || modal.classList.contains('show')) {
      toggleBalanceModal();
    }
  }
});

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
      slider.style.transform = translateX(-${index * 100}%);
      currentSlide = index;
    }

    prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
    nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));

    // Auto-slide every 5 seconds
    setInterval(() => showSlide(currentSlide + 1), 5000);

        // Navigation Functions
      

        function openChat() {
            alert('Opening in-app chat with customer care...');
        }

        // Other Actions Functions
        function addMore() {
            window.location.href="../list/addmoney/";
        }

        function sendGift() {
          window.location.href = '../list/sendgift/';
        }

        function upgrade() {
           window.location.href = '../list/upgrade/';
        }

        function invite() {
           window.location.href = '../list/invite/';
        }

        // Quick Access Functions
        function goToBalance() {
            // alert('Redirecting to balance page...');
            // Simulate page redirect
              window.location.href = '../list/balance/';
        }

        function openContacts() {
           window.location.href = '../include/coming_soon.php';
        }

        function voiceCall() {
       window.location.href = '../include/coming_soon.php';
        }

        // Bill Payment Functions
        function payElectricity() {
            window.location.href = '../list/electricity/';
        }

        function payCable() {
           window.location.href = '../list/cabletv/';
        }

        function buyData() {
          window.location.href = '../list/buydata/';
        }

        function buyAirtime() {
                window.location.href = '../list/buyairtime/';
        }

        function buyEsim() {
          window.location.href = '../include/coming_soon.php';
        }

        function buySmile() {
            window.location.href = '../list/smile/';
        }

        function buyExamPin() {
            window.location.href = '../include/coming_soon.php';
        }
        

        function showMore() {
            window.location.href='../list/services/'
        }

        // Bottom Navigation
        // document.querySelectorAll('.nav-item').forEach(item => {
        //     item.addEventListener('click', function(e) {
        //         e.preventDefault();
        //         document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
        //         this.classList.add('active');
        //     });
        // });

     
        let currentBanner = 0;
        setInterval(() => {
            currentBanner = (currentBanner + 1) % banners.length;
            const banner = banners[currentBanner];
            document.querySelector('.ad-content h2').textContent = banner.title;
            document.querySelector('.ad-content p').textContent = banner.subtitle;
        }, 5000);



        //chat button 
      //         function toggleChatOptions() {
      //   const options = document.getElementById('chat-options');
      //   options.style.display = options.style.display === 'block' ? 'none' : 'block';
      // }

      // function redirectTo(option) {
      //   let url = '#';

      //   if (option === 'whatsapp') {
      //     url = 'https://wa.me/2348012345678'; // Replace with your WhatsApp number
      //   } else if (option === 'inapp') {
      //     url = '/in-app-chat'; // Replace with your in-app chat page URL
      //   } else if (option === 'email') {
      //     url = 'mailto:support@example.com'; // Replace with your email
      //   }

      //   window.location.href = url;
      // }

      const chatBtn = document.getElementById('chat-btn');
        const chatOptions = document.getElementById('chat-options');

        // Toggle chat options
        function toggleChatOptions() {
            const isOpen = chatOptions.classList.contains('active');
            chatOptions.classList.toggle('active', !isOpen);
            chatBtn.classList.toggle('active', !isOpen);
            chatBtn.setAttribute('aria-expanded', !isOpen);

            if (!isOpen) {
                // Focus on first option for accessibility
                chatOptions.querySelector('li').focus();
            }
        }

        // Redirect to chat platform
        function redirectTo(option) {
            let url = '#';
            switch (option) {
                case 'whatsapp':
                    url = 'https://wa.me/2347043527649'; 
                    break;
                case 'inapp':
                    url = 'chat/'; 
                    break;
                case 'email':
                     url = 'mailto:saifullah.khmisu@gmail.com';
                    break;
            }
            window.location.href = url;
            toggleChatOptions(); 
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!chatBtn.contains(e.target) && !chatOptions.contains(e.target)) {
                chatOptions.classList.remove('active');
                chatBtn.classList.remove('active');
                chatBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Keyboard navigation for accessibility
        chatOptions.querySelectorAll('li').forEach(item => {
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    item.click();
                }
            });
        });

        // Prevent zoom on mobile inputs
        chatBtn.addEventListener('focus', () => {
            if (window.innerWidth <= 768) {
                document.querySelector('meta[name="viewport"]').setAttribute('content', 
                    'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
            }
        });

        chatBtn.addEventListener('blur', () => {
            document.querySelector('meta[name="viewport"]').setAttribute('content', 
                'width=device-width, initial-scale=1.0');
        });
</script>

</body>
</html>