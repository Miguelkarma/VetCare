<!-- Main Navbar -->
<nav id="cs-navigation">
  <div class="cs-container">
    <!-- Logo -->
    <a href="./" class="cs-logo" aria-label="back to home">
      <img class="brand-logo" src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Site Logo">
      <span class="name ml-2"><?= $_settings->info('short_name') ?></span>
    </a>
    
    <!-- Navigation -->
    <div class="cs-nav" role="navigation">
      <!-- Mobile Nav Toggle -->
      <button class="cs-toggle" aria-label="mobile menu toggle">
        <div class="cs-box" aria-hidden="true">
          <span class="cs-line cs-line1" aria-hidden="true"></span>
          <span class="cs-line cs-line2" aria-hidden="true"></span>
          <span class="cs-line cs-line3" aria-hidden="true"></span>
            <span class="cs-line cs-line3" aria-hidden="true"></span>
        </div>
      </button>
      
      <!-- Navigation List -->
      <div class="cs-ul-wrapper">
        <ul id="cs-expanded" class="cs-ul" aria-expanded="false">
          <li class="cs-li">
            <a href="./" class="cs-li-link <?= isset($page) && $page == 'home' ? 'cs-active' : '' ?>">Home</a>
          </li>
          <li class="cs-li">
            <a href="./?page=appointment" class="cs-li-link <?= isset($page) && $page == 'appointment' ? 'cs-active' : '' ?>">Appointment</a>
          </li>
          <li class="cs-li">
            <a href="./?page=services" class="cs-li-link <?= isset($page) && $page == 'services' ? 'cs-active' : '' ?>">Services</a>
          </li>
          <li class="cs-li">
            <a href="./?page=about" class="cs-li-link <?= isset($page) && $page == 'about' ? 'cs-active' : '' ?>">About Us</a>
          </li>
          <li class="cs-li">
            <a href="./?page=contact_us" class="cs-li-link <?= isset($page) && $page == 'contact_us' ? 'cs-active' : '' ?>">Contacts</a>
          </li>
          <?php if ($_settings->userdata('id') > 0 && $_settings->userdata('login_type') != 1): ?>
            <li class="cs-li">
              <a href="./?page=profile" class="cs-li-link <?= isset($page) && $page == 'profile' ? 'cs-active' : '' ?>">Profile</a>
            </li>
          <?php endif; ?>
        
        </ul>
      </div>
    </div>
    
    <!-- Contact Group -->
    <div class="cs-contact-group">
      <!-- <a href="tel:<?= $_settings->info('contact') ?>" class="cs-phone">
        <img class="cs-phone-icon" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/phone-1a.svg" alt="phone" width="24" height="24" aria-hidden="true" decoding="async">
        <span class="phone-number"><?= $_settings->info('contact') ?></span>
      </a> -->
      
      <!-- User Section -->
      <?php if ($_settings->userdata('id') > 0): ?>
        <div class="user-info">
          <span class="d-flex align-items-center">
            <img src="<?= validate_image($_settings->userdata('avatar')) ?>" alt="User Avatar" class="user-img mr-1">
            <span class="username d-none d-md-inline"><?= !empty($_settings->userdata('username')) ? $_settings->userdata('username') : $_settings->userdata('email') ?></span>
          </span>
          <a href="./admin" class="btn btn-icon text-dark"><i class="fas fa-home"></i></a>
          <a href="<?= base_url . 'classes/Login.php?f=logout' ?>" class="btn btn-icon text-danger"><i class="fa fa-power-off"></i></a>
        </div>
      <?php else: ?>
        <button class="login-btn" onClick="window.location.href='./admin'">
          <span class="text">Login</span><span>Now!</span>
        </button>
      <?php endif; ?>
    </div>
  </div>
</nav>

<style>
/* Integrating styles from both navbars */

/* Base Styles */
:root {
  --primary: #5C4033;
  --headerColor: #1a1a1a;
  --bodyTextColorWhite: #fff;
}

.brand-logo{
  border-radius: 50%;
}

/* User Styles */
.user-img {
  height: 30px;
  width: 30px;
  object-fit: cover;
  border-radius: 50%;
}

.user-info {
  color: #5C4033;
  display: flex;
  align-items: center;
  gap: 5px!important;
}

.user-info a {
  text-decoration: none;
}

.login-btn {
 position: relative;
 overflow: hidden;
 border: 1px solid #18181a;
 color: #18181a;
 display: inline-block;
 font-size: 15px;
 line-height: 15px;
 padding: 0.8em;
 text-decoration: none;
 cursor: pointer;
 background: transparent;
 user-select: none;
 -webkit-user-select: none;
 touch-action: manipulation;
 border-radius:1em;
}

.login-btn span:first-child {
 position: relative;
 transition: color 600ms cubic-bezier(0.48, 0, 0.12, 1);
 z-index: 10;
}

.login-btn span:last-child {
  color:black;
 display: block;
 position: absolute;
 bottom: 0;
 transition: all 500ms cubic-bezier(0.48, 0, 0.12, 1);
 z-index: 100;
 opacity: 0;
 top: 50%;
 left: 50%;
 transform: translateY(225%) translateX(-50%);
 height: 14px;
 line-height: 13px;
}

.login-btn:after {
 content: "";
 position: absolute;
 bottom: -50%;
 left: 0;
 width: 100%;
 height: 100%;
 background-color: antiquewhite;
 transform-origin: bottom center;
 transition: transform 600ms cubic-bezier(0.48, 0, 0.12, 1);
 transform: skewY(9.3deg) scaleY(0);
 z-index: 50;
 color:black;
}

.login-btn:hover:after {
 transform-origin: bottom center;
 transform: skewY(9.3deg) scaleY(2);
}

.login-btn:hover span:last-child {
 transform: translateX(-50%) translateY(-50%);
 opacity: 1;
 transition: all 900ms cubic-bezier(0.48, 0, 0.12, 1);
}
/* Responsive improvements */
@media only screen and (max-width: 63.9375rem) {
  .cs-phone .phone-number {
    display: none;
  }
  
  .user-info {
    margin-left: auto;
  }
  
  .user-info .username {
    display: none;
  }
}

/* Bootstrap-like utilities */
.d-flex {
  display: flex;
}

.align-items-center {
  align-items: center;
}

.d-none {
  display: none;
}

@media (min-width: 768px) {
  .d-md-inline {
    display: inline !important;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Mobile menu toggle
  const toggle = document.querySelector('.cs-toggle');
  const nav = document.querySelector('#cs-navigation');
  
  if(toggle && nav) {
    toggle.addEventListener('click', function() {
      nav.classList.toggle('cs-active');
      document.body.classList.toggle('cs-open');
    });
  }
  
  // Handle dropdown on mobile
  const dropdowns = document.querySelectorAll('.cs-dropdown');
  
  dropdowns.forEach(dropdown => {
    dropdown.addEventListener('click', function(e) {
      if(window.innerWidth <= 1023) {
        e.preventDefault();
        this.classList.toggle('cs-active');
      }
    });
  });
  
 
</script>