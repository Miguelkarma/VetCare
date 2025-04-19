<?php require_once('./config.php'); ?>
 <!DOCTYPE html>
 
<html lang="en" class="" >
<style>
.layout-top-nav{
   background-color:#F5EFE7!important;  
}
  .content-wrapper{
    margin-top:10em;
  }
</style>
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

 <link rel="stylesheet"  href="./components/css/button.css">
 <link rel="stylesheet"  href="./css/index.css">
<?php require_once('components/header.php') ?>
  <body class="layout-top-nav  mb-5" style="height: auto; ">
    <div class="wrapper">
     <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>
     <?php require_once('components/topBarNav.php') ?>
          
     <?php if($_settings->chk_flashdata('success')): ?>
      <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
      </script>
      <?php endif;?>    
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper " style="">
        <?php if($page == "home" || $page == "about_us"): ?>
      
        <?php endif; ?>
        <!-- Main content -->
         
        <section class="main-content">
          <div class="container">
            <?php 
              if(!file_exists($page.".php") && !is_dir($page)){
                  include '404.html';
              }else{
                if(is_dir($page))
                  include $page.'/index.php';
                else
                  include $page.'.php';

              }
            ?>
            
          </div>
       
        </section>
        <div class="floating-contact-card">
      <h4>Contact Us</h4>
      <div class="contact-number">
        <i class="fas fa-phone-alt"></i>
        <a href="tel:+12345678901">(123) 456-7890</a>
      </div>
      <div class="contact-number">
        <i class="fas fa-mobile-alt"></i>
        <a href="tel:+19876543210">(987) 654-3210</a>
      </div>
    </div>
        <!-- /.content -->
  <div class="modal fade rounded-0" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header rounded-0">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body rounded-0">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade rounded-0" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered rounded-0" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header rounded-0">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body rounded-0">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade rounded-0" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header rounded-0">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body rounded-0">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
           
      </div>
    </div>
  </div>
      </div>
      <!-- /.content-wrapper -->
       <div class="all-footer">
     <?php require_once('components/footer.php') ?> 
     </div> 
  </body>
  <style>
     body{
        font-family: "Abel", sans-serif;
  font-style: normal;
  }
    html{
      background-color:#F5EFE7!important;

    }
       .content-wrapper{
        background-color:#F5EFE7!important;
    }
    .wrapper{
        background-color:#F5EFE7!important;
    }
   
  </style>
  <script src="../../ovas/components/js/nav.js"></script>
</html>