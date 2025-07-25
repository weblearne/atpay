<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --primary-color: #4c1d95;
      --secondary-color: #ffffff;
    }

    .balance-dropdown {
      display: none;
    }

    .balance-dropdown.active {
      display: block;
    }

    .banner-slider {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .banner-slide {
      min-width: 100%;
      transition: opacity 0.5s ease-in-out;
    }

    .chat-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 50;
    }

    @media (max-width: 640px) {
      .grid-cols-4 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">
  <!-- Top Navigation Bar -->
  <nav class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 flex items-center justify-between shadow-md">
    <div class="text-2xl font-bold">Logo</div>
    <div class="flex items-center space-x-4">
      <div class="relative">
        <button id="balance-btn" class="flex items-center space-x-2">
          <span>Balance: $0.00</span>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <div id="balance-dropdown" class="balance-dropdown absolute bg-[var(--secondary-color)] text-gray-800 shadow-lg rounded-lg mt-2 p-4 w-64">
          <p class="font-semibold">Fund Wallet</p>
          <p>Account: 1234567890 (Bank A)</p>
          <p>Account: 0987654321 (Bank B)</p>
        </div>
      </div>
      <button>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
        </svg>
      </button>
      <button>
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
      </button>
    </div>
  </nav>

  <!-- Banner Slider -->
  <div class="relative overflow-hidden">
    <div id="banner-slider" class="banner-slider">
      <div class="banner-slide">
        <img src="https://via.placeholder.com/1200x300?text=Ad+Banner+1" alt="Ad Banner 1" class="w-full h-48 object-cover">
      </div>
      <div class="banner-slide">
        <img src="https://via.placeholder.com/1200x300?text=Ad+Banner+2" alt="Ad Banner 2" class="w-full h-48 object-cover">
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

  <!-- Other Actions Section -->
  <section class="p-4">
    <h2 class="text-xl font-semibold mb-4 text-[var(--primary-color)]">Other Actions</h2>
    <div class="grid grid-cols-4 gap-4">
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Add看法: Add More
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Send Gift
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Upgrade
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Invite
      </button>
    </div>
  </section>

  <!-- Quick Actions Section -->
  <section class="p-4">
    <h2 class="text-xl font-semibold mb-4 text-[var(--primary-color)]">Quick Actions</h2>
    <div class="grid grid-cols-4 gap-4">
      <a href="/balance" class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Balance
      </a>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Contacts
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Voice Call
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        More
      </button>
    </div>
  </section>

  <!-- Recharge and Pay Bills Section -->
  <section class="p-4">
    <h2 class="text-xl font-semibold mb-4 text-[var(--primary-color)]">Recharge and Pay Bills</h2>
    <div class="grid grid-cols-4 gap-4">
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Electricity
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Cable TV
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Data
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Airtime
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        eSIM
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Smile
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        Exam Pin
      </button>
      <button class="bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-lg text-center hover:bg-opacity-90">
        More
      </button>
    </div>
  </section>

  <!-- Floating Chat Button -->
  <button class="chat-button bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 rounded-full shadow-lg hover:bg-opacity-90">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5v-4h-.01M3 16h.01M21 16V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2z"></path>
    </svg>
  </button>

  <!-- Bottom Navigation -->
  <nav class="fixed bottom-0 w-full bg-[var(--primary-color)] text-[var(--secondary-color)] p-4 flex justify-around shadow-md">
    <button class="flex flex-col items-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7 7v6"></path>
      </svg>
      <span>Home</span>
    </button>
    <button class="flex flex-col items-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-3.313 0-6-2.687-6-6s2.687-6 6-6 6 2.687 6 6-2.687 6-6 6z"></path>
      </svg>
      <span>Services</span>
    </button>
    <button class="flex flex-col items-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
      </svg>
      <span>Wallet</span>
    </button>
    <button class="flex flex-col items-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <span>History</span>
    </button>
    <button class="flex flex-col items-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
      </svg>
      <span>Me</span>
    </button>
  </nav>

  <script>
    // Balance Dropdown Toggle
    const balanceBtn = document.getElementById('balance-btn');
    const balanceDropdown = document.getElementById('balance-dropdown');
    balanceBtn.addEventListener('click', () => {
      balanceDropdown.classList.toggle('active');
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
      slider.style.transform = `translateX(-${index * 100}%)`;
      currentSlide = index;
    }

    prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
    nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));

    // Auto-slide every 5 seconds
    setInterval(() => showSlide(currentSlide + 1), 5000);
  </script>
</body>
</html>