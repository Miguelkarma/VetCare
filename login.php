<?php require_once('./config.php') ?>
<!DOCTYPE html>

<html lang="en" class="" style="height: auto;">
 <?php require_once('./admin/inc/header.php') ?>
 <link rel="stylesheet"  href="../ovas/admin/css/login.css">
<body class="hold-transition">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script>
    start_loader()
  </script>
  <style>
    html, body{
      height:100% !important;
      width:100% !important;
    }
    body{
      background-color:#F5EFE7!important;
      background-repeat:no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-title{
      text-shadow: 2px 2px black
    }
    #logo-img{
        height:100px;
        width:100px;
        object-fit:scale-down;
        object-position:center center;
        border-radius:100%;
    }

    .btn-floating {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .bg-primary {
      background-color: #0d6efd !important;
    }


    
    section.login-section {
      display: flex;
      align-items: center;
      width: 100%;
      padding: 5rem 0;
      border:1px solid #000;
      position: relative;
      
    }
    .log-section{
      border-radius: 0.5em;
      padding: 2em;
      background-color: #ebe5dd ;
      color:rgb(75, 49, 12) !important;
      
    }
    .container {
      border-radius: 0.5em;
      -webkit-box-shadow: 0px 4px 17px 4px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 4px 17px 4px rgba(0,0,0,0.75);
box-shadow: 0px 4px 17px 4px rgba(0,0,0,0.75);
      position: relative;
      overflow: hidden; /* Prevent blobs from overflowing */
    }
   
   
  </style>

  <section class="login-section vh-100">
    <div class="container position-relative">
    <a href="<?php echo base_url ?>" class="position-absolute top-0 start-0 m-4 text-dark" style="z-index: 10;">
    <i class="fas fa-arrow-circle-left fa-2x"></i>
  </a>

      <!-- Blob shapes -->
      <div class="blob"></div>
      <div class="blob-2"></div>

      <div class="row d-flex justify-content-center align-items-center log-section">
        <div class="col-md-8 col-lg-6 col-xl-5">                                                                                                                                                                                                                                                                                                                                                                  
          <form id="login-frm" action="" method="post" class="">
            <!-- Username input -->         
            <div class="form-outline mb-4">                                                                 
              <center>
                <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" id="logo-img" class="mb-5">
              </center>
              <label class="form-label" for="username">Username</label>
              <input type="text" id="username" name="username" class="form-control form-control-lg" 
                placeholder="Enter your username" autofocus />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
  <label class="form-label" for="password">Password</label>
  <div class="position-relative">
    <input type="password" id="password" name="password" class="form-control form-control-lg"
      placeholder="Enter password" />
    <i class="fas fa-eye position-absolute" id="togglePassword" onclick="togglePassword()" 
      style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
  </div>
</div>

            <div class="d-flex justify-content-between align-items-center">
              <!-- Checkbox -->
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="remember" />
                <label class="form-check-label" for="remember">
                  Remember me
                </label>
              </div>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="button"
              ><span class="">Login</span> </button>

            </div>
            
          </form>
        </div>

        <div class="col-md-9 col-lg-6 col-xl-7">
          <img src="./assets/loginpic.png" class="img-fluid d-none d-lg-block" alt="Sample image">
        </div>
      </div>
      
    </div>
  </section>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader();
  })

  function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.getElementById("togglePassword");

    const isHidden = passwordInput.type === "password";
    passwordInput.type = isHidden ? "text" : "password";

    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
  }
</script>
</body>
</html>
