    <style>
          .bottom-nav {
    display: flex;
    justify-content: space-around;
    background-color: #fff;
    border-top: 1px solid #ddd;
    position: fixed;
    bottom: 0;
    width: 100%;
    padding: 10px 0;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: #333;
    font-size: 12px;
}

.nav-item i {
    font-size: 18px;
    margin-bottom: 4px;
}
  .banner-slider img{
    border-radius: 20px;
 }
    </style>
    
    <!-- Bottom Navigation -->
<nav class="bottom-nav">
  <a href="../user/" class="nav-item active">
    <i class="fas fa-house"></i>
    <span>Home</span>
  </a>
  <a href="../list/services/" class="nav-item">
    <i class="fas fa-gear"></i>
    <span>Services</span>
  </a>
  <a href="../list/addmoney/" class="nav-item">
    <i class="fas fa-wallet"></i>
    <span>Wallet</span>
  </a>
  <a href="../list/history/" class="nav-item">
    <i class="fas fa-clock-rotate-left"></i>
    <span>History</span>
  </a>
  <a href="../list/profile/" class="nav-item">
    <i class="fas fa-user"></i>
    <span>Me</span>
  </a>
</nav>