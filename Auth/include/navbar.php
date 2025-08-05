<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Navbar - atPay Wallet</title>
    <style>
        :root {
            --primary-color: #4c1d95;
            --secondary-color: #ffffff;
            --text-color: #333;
            --border-color: #e5e7eb;
            --background-color: #f8fafc;
            --hover-color: #f1f5f9;
            --accent-color: #6366f1;
            --shadow-light: rgba(0, 0, 0, 0.1);
            --shadow-medium: rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color) 100%);
            min-height: 100vh;
            padding-top: 80px;
        }

        .top-nav {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color) 100%);
            backdrop-filter: blur(10px);
            color: var(--primary-color);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 20px var(--shadow-light);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .top-nav:hover {
            box-shadow: 0 6px 30px var(--shadow-medium);
        }

        .nav-left {
            display: flex;
            align-items: center;
        }

        .back-btn {
            background: linear-gradient(135deg, var(--background-color) 0%, var(--hover-color) 100%);
            border: 2px solid transparent;
            color: var(--primary-color);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            padding: 10px 16px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            min-width: 90px;
            justify-content: center;
        }

        .back-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .back-btn:hover::before {
            left: 100%;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 29, 149, 0.3);
            border-color: var(--primary-color);
        }

        .back-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(76, 29, 149, 0.2);
        }

        .back-btn .back-icon {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .back-btn:hover .back-icon {
            transform: translateX(-3px);
        }

        .nav-brand {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            letter-spacing: -0.5px;
        }

        .nav-brand::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .nav-brand:hover::after {
            width: 100%;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .top-nav {
                padding: 12px 16px;
            }

            .nav-brand {
                font-size: 22px;
                font-weight: 700;
            }

            .back-btn {
                font-size: 14px;
                padding: 8px 12px;
                min-width: 80px;
                gap: 6px;
            }

            .back-btn .back-icon {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .top-nav {
                padding: 10px 12px;
            }

            .nav-brand {
                font-size: 20px;
            }

            .back-btn {
                font-size: 13px;
                padding: 8px 10px;
                min-width: 70px;
                gap: 4px;
            }
        }

        @media (max-width: 360px) {
            .nav-brand {
                font-size: 18px;
            }

            .back-btn {
                padding: 6px 8px;
                min-width: 65px;
            }
        }

        /* Accessibility improvements */
        .back-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 29, 149, 0.3);
        }

        @media (prefers-reduced-motion: reduce) {
            .back-btn,
            .nav-brand::after,
            .back-btn::before,
            .back-btn .back-icon {
                transition: none;
            }
        }

        /* Demo content */
        .demo-content {
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .demo-content h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .demo-content p {
            font-size: 1.2rem;
            opacity: 0.8;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .demo-content h1 {
                font-size: 2rem;
            }

            .demo-content p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="nav-left">
            <a class="back-btn" onclick="history.back();">
                <span class="back-icon">←</span>
                <span>Back</span>
            </a>
        </div>
        <div class="nav-brand">atPay Wallet</div>
    </nav>

    <script>
        // Enhanced back button functionality
        // document.querySelector('.back-btn').addEventListener('click', function(e) {
        //     e.preventDefault();
            
        //     // Check if there's browser history
        //     if (window.history.length > 1) {
        //         window.history.back();
        //     } else {
        //         // Fallback: redirect to home page or login
        //         console.log('No history available, redirecting to home');
        //         // window.location.href = '/';
        //     }
        // });

        // Add scroll effect to navbar
        // let lastScrollTop = 0;
        // const navbar = document.querySelector('.top-nav');

        // window.addEventListener('scroll', function() {
        //     let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
        //     if (scrollTop > 50) {
        //         navbar.style.background = 'linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(254,254,254,0.95) 100%)';
        //         navbar.style.backdropFilter = 'blur(15px)';
        //     } else {
        //         navbar.style.background = 'linear-gradient(135deg, var(--secondary-color) 0%, #fefefe 100%)';
        //         navbar.style.backdropFilter = 'blur(10px)';
        //     }
            
        //     lastScrollTop = scrollTop;
        // });

        // // Add ripple effect to back button
        // document.querySelector('.back-btn').addEventListener('click', function(e) {
        //     const ripple = document.createElement('span');
        //     const rect = this.getBoundingClientRect();
        //     const size = Math.max(rect.width, rect.height);
        //     const x = e.clientX - rect.left - size / 2;
        //     const y = e.clientY - rect.top - size / 2;
            
        //     ripple.style.cssText = `
        //         position: absolute;
        //         width: ${size}px;
        //         height: ${size}px;
        //         left: ${x}px;
        //         top: ${y}px;
        //         background: rgba(255, 255, 255, 0.3);
        //         border-radius: 50%;
        //         transform: scale(0);
        //         animation: ripple 0.6s linear;
        //         pointer-events: none;
        //     `;
            
        //     this.appendChild(ripple);
            
        //     setTimeout(() => {
        //         ripple.remove();
        //     }, 600);
        // });

        // Add CSS animation for ripple effect
        // const style = document.createElement('style');
        // style.textContent = `
        //     @keyframes ripple {
        //         to {
        //             transform: scale(2);
        //             opacity: 0;
        //         }
        //     }
        // `;
        // document.head.appendChild(style);
    </script>
</body>
</html>