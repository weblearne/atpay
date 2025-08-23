<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" >
  <title>atPay | Quality Data & Airtime</title>
<meta name="title" content="atPay | Quality Data & Airtime" />
<meta name="description" content="Buy data, airtime, and manage your wallet easily with atPay. Fast, reliable, and affordable services at your fingertips." />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="https://atpay.ng/" />
<meta property="og:title" content="atPay | Quality Data & Airtime" />
<meta property="og:description" content="Buy data, airtime, and manage your wallet easily with atPay." />
<meta property="og:image" content="https://www.gtopup.site/invite/assets/images/atpay%20new%20logo_write.png" /> <!-- Banner for preview -->

<!-- Twitter -->
<meta property="twitter:card" content="summary" />
<meta property="twitter:url" content="https://atpay.ng/" />
<meta property="twitter:title" content="atPay | Quality Data & Airtime" />
<meta property="twitter:description" content="Buy data, airtime, and manage your wallet easily with atPay." />
<meta property="twitter:image" content="https://www.gtopup.site/invite/assets/images/atpay%20new%20logo_write.png" /> <!-- Banner for preview -->
<meta name="twitter:image:width" content="70" />
  <meta name="twitter:image:height" content="70" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/png" href="images/logo.png">
  <style>
    :root {
      --primary-purple: #4c1d95;
      --secondary-purple: #ffffff;
      --dark-purple: #4c1d95;
      --light-purple: #f3f4f6;
      --text-dark: #1f2937;
      --text-gray: #6b7280;
      --text-light: #9ca3af;
      --white: #ffffff;
      --green: #10b981;
      --orange: #f59e0b;
      --gradient-primary: linear-gradient(135deg, #4c1d95 0%, #4c1d95 100%);
      --gradient-hero: linear-gradient(135deg, #4c1d95 0%, #4c1d95 100%);
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --border-radius: 12px;
      --transition: all 0.3s ease;
      --max-width: 1200px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
      line-height: 1.6;
      color: var(--text-dark);
      overflow-x: hidden;
    }

    /* Splash Screen Styles */
    .splash-screen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: var(--gradient-primary);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      opacity: 1;
      transition: opacity 0.8s ease-out;
    }

    .splash-screen.hidden {
      opacity: 0;
      pointer-events: none;
    }

    .logo-container {
      background: var(--primary-purple);
      width: 150px;
      height: 150px;
      border-radius: 70%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      animation: logoFloat 2s ease-in-out infinite alternate;
    }

    /* .logo {
      font-size: 3rem;
      font-weight: 900;
      color: var(--primary-purple);
    } */

    .company-name {
      margin-top: 2rem;
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--white);
      text-align: center;
      animation: fadeInUp 1s ease-out 0.5s both;
    }

    .splash-tagline {
      margin-top: 1rem;
      font-size: 1.1rem;
      color: rgba(255, 255, 255, 0.9);
      text-align: center;
      animation: fadeInUp 1s ease-out 1s both;
    }

    .loading-spinner {
      margin-top: 3rem;
      width: 40px;
      height: 40px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: var(--white);
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes logoFloat {
      0% { transform: translateY(0px); }
      100% { transform: translateY(-10px); }
    }

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

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Main Content Styles */
    .main-content {
      opacity: 0;
      transition: opacity 0.8s ease-in;
    }

    .main-content.visible {
      opacity: 1;
    }

    /* Header Styles */
    header {
      position: sticky;
      top: 0;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      z-index: 1000;
      box-shadow: var(--shadow-sm);
    }

    header > div {
      max-width: var(--max-width);
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
    }

    .header-logo {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--dark-purple);
      text-decoration: none;
    }

    nav ul {
      display: flex;
      list-style: none;
      gap: 2rem;
      align-items: center;
    }

    nav a {
      text-decoration: none;
      color: var(--text-dark);
      font-weight: 500;
      transition: var(--transition);
      padding: 0.5rem 1rem;
      border-radius: 6px;
    }

    nav a:hover {
      color: var(--white);
      background: var(--primary-purple);
    }

    .login-btn {
      background: var(--dark-purple);
      color: var(--white) !important;
      padding: 0.75rem 1.5rem !important;
      border-radius: 8px;
      font-weight: 600;
    }

    .login-btn:hover {
      background-color: var(--primary-purple);
      color: var(--white) !important;
    }

    .hamburger {
      display: none;
      flex-direction: column;
      cursor: pointer;
      gap: 4px;
    }

    .hamburger span {
      width: 25px;
      height: 3px;
      background: var(--text-dark);
      transition: var(--transition);
    }

    /* Hero Section */
    .hero {
      background: var(--dark-purple);
      color: var(--white);
      text-align: center;
      padding: 6rem 2rem;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: var(--dark-purple);
    }

    .hero > * {
      position: relative;
      z-index: 2;
    }

    .hero h1 {
      font-size: 4rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      line-height: 1.1;
    }

    .hero h1 span {
      color: var(--orange);
    }

    .hero > p {
      font-size: 1.25rem;
      max-width: 600px;
      margin: 0 auto 3rem;
      opacity: 0.95;
      line-height: 1.6;
    }

    .buttons {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-bottom: 3rem;
      flex-wrap: wrap;
    }

    .google-play, .app-store {
      background: var(--white);
      color: var(--text-dark);
      text-decoration: none;
      padding: 1rem 2rem;
      border-radius: var(--border-radius);
      font-weight: 600;
      transition: var(--transition);
      box-shadow: var(--shadow-md);
    }

    .google-play:hover, .app-store:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-lg);
    }

    /* Do More Section */
    .do-more-section {
      padding: 6rem 2rem;
      text-align: center;
      background: var(--white);
    }

    .do-more-section h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: var(--text-dark);
    }

    .do-more-section > p {
      font-size: 1.1rem;
      color: var(--text-gray);
      max-width: 600px;
      margin: 0 auto 3rem;
      line-height: 1.6;
    }

    .do-more-graphics {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      max-width: var(--max-width);
      margin: 0 auto;
    }

    .graphic-item {
      width: 100%;
      height: 350px;
      border-radius: var(--border-radius);
      position: relative;
      overflow: hidden;
      transition: var(--transition);
      box-shadow: var(--shadow-md);
      background: var(--light-purple);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--text-gray);
    }

    .graphic-item:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }

    /* Accessible Section */
    .accessible-section {
      padding: 6rem 2rem;
      background: var(--light-purple);
      text-align: center;
    }

    .accessible-section h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: var(--text-dark);
    }

    .accessible-section > p {
      font-size: 1.1rem;
      color: var(--text-gray);
      max-width: 600px;
      margin: 0 auto 3rem;
      line-height: 1.6;
    }

    .accessible-graphics {
      max-width: var(--max-width);
      margin: 0 auto;
    }

    .accessible-graphics .graphic-item {
      margin: 0 auto;
      height: 400px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-md);
      background: var(--gradient-primary);
    }

    /* Join Section */
    .join-section {
      padding: 6rem 2rem;
      background: var(--text-dark);
      color: var(--white);
      text-align: center;
    }

    .join-section h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 2rem;
    }

    .footer-columns {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      max-width: var(--max-width);
      margin: 4rem auto;
      text-align: left;
    }

    .column h3 {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: var(--white);
    }

    .column ul {
      list-style: none;
    }

    .column li {
      margin-bottom: 0.5rem;
      color: var(--text-light);
      cursor: pointer;
      transition: var(--transition);
    }

    .column li:hover {
      color: var(--white);
    }

    .social-icons {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin: 3rem 0;
    }

    .social-icons a {
      width: 50px;
      height: 50px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      transition: var(--transition);
      font-weight: 600;
      color: var(--white);
    }

    .social-icons a:hover {
      background: var(--primary-purple);
      transform: translateY(-3px);
    }

    .copyright {
      font-size: 0.9rem;
      color: var(--text-light);
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 2rem;
      margin-top: 2rem;
    }

    /* Footer */
    footer {
      background: var(--text-dark);
      color: var(--text-light);
      text-align: center;
      padding: 2rem;
      font-size: 0.9rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
      .hamburger {
        display: flex;
      }

      nav ul {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--white);
        flex-direction: column;
        padding: 1rem;
        box-shadow: var(--shadow-md);
      }

      nav ul.active {
        display: flex;
      }

      nav a {
        padding: 1rem;
        width: 100%;
        text-align: center;
      }

      header > div {
        padding: 0 1rem;
      }

      .hero {
        padding: 4rem 1rem;
      }

      .hero h1 {
        font-size: 2.5rem;
      }

      .hero > p {
        font-size: 1.1rem;
      }

      .buttons {
        flex-direction: column;
        align-items: center;
      }

      .google-play, .app-store {
        width: 100%;
        max-width: 300px;
        justify-content: center;
      }

      .do-more-section, .accessible-section, .join-section {
        padding: 4rem 1rem;
      }

      .do-more-section h2, .accessible-section h2, .join-section h2 {
        font-size: 2rem;
      }

      .footer-columns {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin: 3rem auto;
      }

      .do-more-graphics {
        grid-template-columns: repeat(2, 1fr);
      }

      .company-name {
        font-size: 2rem;
      }

      .logo-container {
        width: 120px;
        height: 120px;
      }

      .logo {
        font-size: 2.5rem;
      }
    }

    @media (max-width: 480px) {
      .footer-columns {
        grid-template-columns: 1fr;
      }

      .hero h1 {
        font-size: 2rem;
      }

      .do-more-graphics {
        grid-template-columns: 1fr;
      }

      .company-name {
        font-size: 1.8rem;
      }

      .logo-container {
        width: 100px;
        height: 100px;
      }

      .logo {
        font-size: 2rem;
      }
    }

    /* Content Animations */
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero > *, .do-more-section > *, .accessible-section > *, .join-section > * {
      animation: slideInUp 0.8s ease-out forwards;
    }

    .graphic-item {
      animation: slideInUp 0.8s ease-out forwards;
    }

    .graphic-item:nth-child(2) {
      animation-delay: 0.2s;
    }

    .graphic-item:nth-child(3) {
      animation-delay: 0.4s;
    }
    img{
      width:100%;
      height:100%;
      border-radius:50px;
    }
   .home-logo {
  width: 70px;
  height: 70px;
  border-radius: 100px;
  object-fit: cover; /* ensures image is not stretched */
  margin-right: 10px;
}

.header-logo {
  font-size: 24px;
  font-weight: bold;
  text-decoration: none;
  color: var(--primary-purple);
  vertical-align: middle;
}

.header-brand {
  display: flex;
  align-items: center;
}
.network-logo {
  width: 50px;
  height: 50px;
  object-fit: contain;
  margin: 5px;
  transition: transform 0.2s ease;
}

.network-logo:hover {
  transform: scale(1.1);
}

.social-icons {
  display: flex;
  gap: 10px;
  justify-content: center;
  align-items: center;
}


 .do-more-graphics {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      max-width: var(--max-width);
      margin: 0 auto;
    }

    .graphic-item {
      width: 100%; /* Fit left and right */
      height: 350px; /* Consistent height */
      border-radius: var(--border-radius);
      position: relative;
      overflow: hidden;
      transition: var(--transition);
      box-shadow: var(--shadow-md);
    }

    .graphic-item img {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Ensures image covers the container */
    }

    .graphic-item:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }
      @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .hero > *, .do-more-section > *, .accessible-section > *, .join-section > * {
      animation: fadeInUp 0.8s ease-out forwards;
    }

    .graphic-item {
      animation: slideIn 0.8s ease-out forwards;
    }

    .graphic-item:nth-child(2) {
      animation-delay: 0.2s;
    }

    .graphic-item:nth-child(3) {
      animation-delay: 0.4s;
    }
  </style>
</head>
<body>
  <!-- Splash Screen -->
  <div class="splash-screen" id="splashScreen">
    <div class="logo-container">
      <div class="logo">
        <img src="images/logo.png" alt="">
      </div>
    </div><br><br>
    <h1 class="company-name">atPay</h1>
    <p class="splash-tagline">Making Bills Payments Simpler</p>
    <div class="loading-spinner"></div>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    <!-- Header -->
    <header>
      <div>
        <div class="header-brand">
      <img class="home-logo" src="images/logo.png" alt="atPay Logo">
      <a href="/atpay/" class="header-logo">atPay</a>
    </div>

        <nav>
          <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
          </div>
          <ul id="navMenu">
            <li><a href="#home">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="Auth/login/" class="login-btn">Login</a></li>
            <li><a href="Auth/register/" class="login-btn">Register Free</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
      <h1>Making Bills payments <span>Simpler</span></h1>
      <!-- <p>Seamless, Fast, Secure & Reliable Payments for Airtime, Data & Bills Making Everyday Transactions Effortless, Anywhere, Anytime!</p> -->
      <p>atPay is a fast and secure platform that allows users to conveniently purchase data, airtime, and other digital services.!</p>
      <div class="buttons">
          <a href="Auth/login/" class="app-store">Login here</a>
          <a href="Auth/register/" class="app-store">Register Free</a>
        <a href="https://play.google.com/store/apps/details?id=com.data.bluepay&pli=1" class="google-play" style="background-color: black; color: #fff">Download it on Google Play</a>
        

      </div>
    </section>

    <!-- Do More Section -->
    <section class="do-more-section" id="services">
      <h2>Do more with your money</h2>
      <p>More Seamless, Fast, Secure & Reliable Payments for Airtime, Data & Bills Making Everyday Transactions Effortless, Anywhere, Anytime!.</p>
    <div class="do-more-graphics">
      <div class="graphic-item"><img src="images/mtn.png" alt=""></div>
      <div class="graphic-item"><img src="images/img3.jpg" alt=""></div>
      <div class="graphic-item"><img src="images/airtel.jpg" alt=""></div>

     
    </div>
    </section>

    <!-- Accessible Section -->
    <section class="accessible-section">
      <h2>Make financial service accessible</h2>
      <p>We've designed an app that complements your unique lifestyle, simplifying cashless payments and unlocking accessible financial services for all.</p>
      <div class="accessible-graphics">
      
    </section>

    <!-- Join Section -->
    <section class="join-section" id="about">
      <h2>Join 35+ million users who love atPay</h2>
      <div class="buttons">
        <a href="https://play.google.com/store/apps/details?id=com.data.bluepay&pli=1" class="google-play">Download it on Google Play</a>
        <a href="#" class="app-store">Download on the App Store</a>
      </div>
      <div class="footer-columns">
        <div class="column">
          <h3>Personal</h3>
          <ul>
            <li>atPay App</li>
            <li>Send and Receive Money</li>
            <li>Bill Payment</li>
            <li>Buy and Shop</li>
          </ul>
        </div>
        <div class="column">
          <h3>Our services</h3>
          <ul>
            <li>Airtime & Data</li>
            <li>Bills Payment</li>
            <li>Wallet funding</li>
            <li>Pay with Transfer</li>
            <li>E-Commerce Payments</li>
          </ul>
        </div>
        <div class="column">
          <h3>Company</h3>
          <ul>
            <li>About</li>
            <li>Blog</li>
            <li>Press and Media</li>
            <li>Contact</li>
          </ul>
        </div>
        <div class="column">
          <h3>Legal</h3>
          <ul>
            <li>Privacy Policy</li>
            <li>Terms & Conditions</li>
            <li>Complaints</li>
          </ul>
        </div>
      </div>
  <div class="social-icons">
  <a href="#" class="social-link">
    <img src="images/mtn.png" alt="MTN" class="network-logo">
  </a>
  <a href="#" class="social-link">
    <img src="images/airtel.jpg" alt="Airtel" class="network-logo">
  </a>
  <a href="#" class="social-link">
    <img src="images/glo.jpg" alt="GLO" class="network-logo">
  </a>
  <a href="#" class="social-link">
    <img src="images/9mobile.png" alt="9mobile" class="network-logo">
  </a>
</div>

     
      <p>atPay is a Data bundle app provided by atPay Limited, Seamless, Fast, Secure & Reliable Payments for Airtime, Data & Bills.</p>
    </section>

    <!-- Footer -->
    <footer id="contact">
      <?php include 'include/app_settings.php'?>
     <?php echo APP_NAME_FOOTER; ?>
    </footer>
  </div>

  <script>
    // Splash screen functionality
    document.addEventListener('DOMContentLoaded', function() {
      const splashScreen = document.getElementById('splashScreen');
      const mainContent = document.getElementById('mainContent');
      
      // Check if user has seen splash screen before (using sessionStorage)
      const hasSeenSplash = sessionStorage.getItem('hasSeenSplash');
      
      if (hasSeenSplash) {
        // If user has seen splash, show main content immediately
        splashScreen.classList.add('hidden');
        mainContent.classList.add('visible');
      } else {
        // Show splash screen for 3 seconds, then show main content
        setTimeout(() => {
          splashScreen.classList.add('hidden');
          mainContent.classList.add('visible');
          sessionStorage.setItem('hasSeenSplash', 'true');
        }, 3000);
      }
      
      // Mobile navigation toggle
      const hamburger = document.getElementById('hamburger');
      const navMenu = document.getElementById('navMenu');
      
      hamburger.addEventListener('click', function() {
        navMenu.classList.toggle('active');
      });
      
      // Smooth scrolling for navigation links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
          // Close mobile menu if open
          navMenu.classList.remove('active');
        });
      });
      
      // Add scroll effect to header
      window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 100) {
          header.style.background = 'rgba(255, 255, 255, 0.98)';
        } else {
          header.style.background = 'rgba(255, 255, 255, 0.95)';
        }
      });
    });
  </script>
</body>
</html>