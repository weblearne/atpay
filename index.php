<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>atPay Wallet</title>
  <style>
    :root {
      --primary-purple: #6366f1;
      --secondary-purple: #8b5cf6;
      --dark-purple: #4c1d95;
      --light-purple: #f3f4f6;
      --text-dark: #1f2937;
      --text-gray: #6b7280;
      --text-light: #9ca3af;
      --white: #ffffff;
      --green: #10b981;
      --orange: #f59e0b;
      --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
      --gradient-hero: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

   

    .login-btn {
      background: var( --dark-purple);
      color: var(--white) !important;
      padding: 0.75rem 1.5rem !important;
      border-radius: 8px;
      font-weight: 600;
    }

    .login-btn:hover {
      background-color:var( --dark-purple);
      color:#000000;
    }

    .location {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.9rem;
      color: var(--text-gray);
      cursor: pointer;
    }

    /* Hero Section */
    .hero {
     background-color: var(--dark-purple);
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
      /* background: url('images/logo.png'); */
      background-color:var( --dark-purple);
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

    .footer-text {
      display: flex;
      justify-content: center;
      gap: 2rem;
      font-size: 0.9rem;
      opacity: 0.8;
      flex-wrap: wrap;
    }

    .footer-text span {
      background: #ffffff;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      backdrop-filter: blur(10px);
      color:#000000;
      cursor:pointer;
    }
    .footer-text span:hover{
     background-color:var( --primary-purple); 
     color:#ffffff;
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
          /* background-image:url('images/bg.png'); */
    }
.accessible-graphics .graphic-item {
  background-image: url('images/atpay.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  margin: 0 auto;
  height: 400px;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow-md);
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
        display: block;
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

      .footer-text {
        flex-direction: column;
        gap: 1rem;
      }

      .do-more-graphics {
        grid-template-columns: repeat(2, 1fr); /* 2 columns on small screens */
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
        grid-template-columns: 1fr; /* 1 column on very small screens */
      }
    }

    /* Animations */
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

 <?php include 'include/home_top_nav_bar.php'?>

  <section class="hero">
    <h1>Making Bills payments <span>Simpler</span></h1>
    <p>Seamless, Fast, Secure & Reliable Payments for Airtime, Data & Bills
Making Everyday Transactions Effortless, Anywhere, Anytime!</p>
    <div class="buttons">
      <a href="#" class="google-play">Get it on Google Play</a>
      <a href="#" class="app-store">Download on the App Store</a>
    </div>
    <!-- <div class="footer-text">
      <span>Licensed by CBN as a MMO</span>
      <span>Deposits insured by NDIC</span>
    </div> -->
  </section>

  <section class="do-more-section">
    <h2>Do more with your money</h2>
    <p>More than just transferring money. You can do all kinds of cool stuff - pay your bills, make purchases, save and earn, all financial needs in one atPay app.</p>
    <div class="do-more-graphics">
      <div class="graphic-item"><img src="images/img3.jpg" alt=""></div>
      <div class="graphic-item"><img src="images/img3.jpg" alt=""></div>
      <div class="graphic-item"><img src="images/img3.jpg" alt=""></div>
      <div class="graphic-item"><img src="images/img3.jpg" alt=""></div>
      <div class="graphic-item"><img src="images/img3.jpg" alt=""></div>
      <div class="graphic-item"><img src="images/img3.jpg" alt=""></div>
     
    </div>
  </section>

  <section class="accessible-section">
    <h2>Make financial service accessible</h2>
    <p>We've designed an app that complements your unique lifestyle, simplifying cashless payments and unlocking accessible financial services for all.</p>
    <div class="accessible-graphics">
      <div class="graphic-item"></div>
    </div>
  </section>

  <section class="join-section">
    <h2>Join 35+ million users who love atPay</h2>
    <div class="buttons">
      <a href="#" class="google-play">Get it on Google Play</a>
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
      <a href="#" class="social-link"><img src="images/logo.png" style="width:50px; height:50px; border-radius:25px;" alt=""></a>
      <a href="#" class="social-link"><img src="images/logo.png" style="width:50px; height:50px; border-radius:25px;" alt=""></a>
      <a href="#" class="social-link"><img src="images/logo.png" style="width:50px; height:50px; border-radius:25px;" alt=""></a>
      <a href="#" class="social-link"><img src="images/logo.png" style="width:50px; height:50px; border-radius:25px;" alt=""></a>

    </div>
    <p class="copyright">©2025 atPay. All rights reserved.</p>
  </section>

  <footer>
    <p>atPay is a Data bundle app  provided by atPay Limited, Seamless, Fast, Secure & Reliable Payments for Airtime, Data & Bills.</p>
  </footer>

</body>
</html>