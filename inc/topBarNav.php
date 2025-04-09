<!-- Main Navbar -->
<nav id="cs-navigation">
  <div class="cs-container">
    <!-- Logo -->
    <a href="./" class="cs-logo" aria-label="back to home">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Site Logo">
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
        <button onClick="window.location.href='./admin'" class="button">
          Login
          <div class="hoverEffect">
            <div></div>
          </div>
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

.btn-icon {
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
  transition: background-color 0.3s;
}

.btn-icon:hover {
  background-color: rgba(0,0,0,0.05);
}

/* Button Styles */
.button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5em 2em;
  border: 0;
  position: relative;
  overflow: hidden;
  border-radius: 10rem;
  transition: all 0.2s;
  font-weight: bold;
  cursor: pointer;
  color: rgb(29, 15, 9)!important;
  z-index: 0;
  box-shadow: 0 0px 7px -5px rgba(0, 0, 0, 0.5);
}

.button:hover {
  background: rgb(228, 209, 163);
  color: #5C4033;
}

.button:active {
  transform: scale(0.97);
}

.hoverEffect {
  position: absolute;
  bottom: 0;
  top: 0;
  left: 0;
  right: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: -1;
}

.hoverEffect div {
  background: linear-gradient(
    90deg,
    rgb(92, 77, 10) 0%,
    rgb(235, 214, 146) 49%,
    rgb(111, 97, 7) 100%
  );
  border-radius: 40rem;
  width: 10rem;
  height: 10rem;
  transition: 0.4s;
  filter: blur(20px);
  animation: effect infinite 3s linear;
  opacity: 0.5;
}

.button:hover .hoverEffect div {
  width: 8rem;
  height: 8rem;
}

@keyframes effect {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
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