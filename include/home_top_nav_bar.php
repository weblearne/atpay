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
 /* Header */
    header {
      background: var(--white);
      box-shadow: var(--shadow-sm);
      position: sticky;
      top: 0;
      z-index: 1000;
      padding: 1rem 0;
    }

    header > div {
      max-width: var(--max-width);
      margin: 0 auto;
      padding: 0 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--dark-purple);
      display: flex;
      align-items: center;
    }

    .logo::before {
      content: '';
      margin-right: 8px;
      width: 24px;
      height: 24px;
      background: var(--dark-purple);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hamburger {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--text-dark);
      padding: 0.5rem;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 2rem;
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
      padding: 0.5rem 0;
      position: relative;
    }

    nav a:hover {
      color: var(--primary-purple);
    }
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
    flex-direction: column;
    background: var(--white);
    padding: 1rem;
    box-shadow: var(--shadow-md);
  }

  nav ul.active {
    display: flex;
  }

  nav a {
    width: 100%;
    text-align: center;
    padding: 1rem;
  }
}
.login-btn {
  background: var(--dark-purple);
  color: var(--white);
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: 600;
  transition: var(--transition);
}

.login-btn:hover {
  background: var(--primary-purple);
  color: #ffffff;
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
@media (max-width: 768px) {
  .hamburger {
    display: block;
  }

  nav ul {
    display: none;
    flex-direction: column;
    position: absolute;
    background: var(--white);
    width: 100%;
    top: 100%;
    left: 0;
    box-shadow: var(--shadow-md);
    z-index: 1000;
  }

  nav ul.active {
    display: flex;
  }

  nav a {
    padding: 1rem;
    width: 100%;
    text-align: center;
  }
}

.login-btn {
  background: var(--dark-purple);
  color: var(--white);
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: 600;
  transition: var(--transition);
}

.login-btn:hover {
  background: var(--primary-purple);
  color: #ffffff;
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

 </style>
 
 <header>
    <div>
      
      <div class="logo"><img src="images/logo.png" alt="" style="width:50px; height:50px;">atPay</div>
      <nav>
        <div class="hamburger">☰</div>
        <ul>
          <li><a href="#">Personal</a></li>
          <li><a href="#">Business</a></li>
          <li><a href="#">Company</a></li>
          <li><a href="#">Developers</a></li>
          <li><a href="#">Pricing</a></li>
     <a href="login/index.php" class="login-btn">Log In</a>
          <li><a href="register/index.php" class="login-btn">Register Free</a></li>
        </ul>
      </nav>
    </div>
  </header>

  
  <script>
    // Toggle hamburger menu
    document.querySelector('.hamburger').addEventListener('click', () => {
      document.querySelector('nav ul').classList.toggle('active');
    });

    // Add smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth'
          });
          // Close menu on mobile after clicking a link
          if (window.innerWidth <= 768) {
            document.querySelector('nav ul').classList.remove('active');
          }
        }
      });
    });

    // Add intersection observer for animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
        }
      });
    }, observerOptions);

    document.querySelectorAll('.graphic-item, .column').forEach(el => {
      observer.observe(el);
    });
    entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';

  </script>