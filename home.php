
<style>
    .content {
        background-color:#F5EFE7!important;
    }
     .content {
        background-color:#F5EFE7!important;
    }
    .car-cover{
        width:10em;
    }
    .car-item .col-auto{
        max-width: calc(100% - 12em) !important;
    }
    .car-item:hover{
        transform:translate(0, -4px);
        background:#a5a5a521;
    }
    .banner-img-holder{
        height:25vh !important;
        width: calc(100%);
        overflow: hidden;
    }
    .banner-img{
        object-fit:scale-down;
        height: calc(100%);
        width: calc(100%);
        transition:transform .3s ease-in;
    }
    .car-item:hover .banner-img{
        transform:scale(1.3)
    }


  body{
        font-family: "Abel", sans-serif;
  font-style: normal;
  }
</style>
 <link rel="stylesheet"  href="./inc/css/nav.css">
 <link rel="stylesheet"  href="./css/hero.css">

 <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
<h1 class="hero-title">Compassionate Care for Your Furry Friends</h1>
<p class="hero-text">At Short Tail Vet Clinic, we provide expert veterinary services with a gentle touch. From routine check-ups to urgent care, your pet’s health is our top priority.</p>

                    <div class="buttons">
                        <a href="http://localhost/ovas/?page=appointment" class="btn btn-appointment"><i class="fa-regular fa-bookmark"></i> Book an Appointment </a>
                    
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="circle-image-container">
                        <div class="circle-image">
                            <img src="./assets/hero.png" alt="Veterinarian examining a dog">
                        </div>
                        <div class="scissors-icon">
                            <i class="fas fa-cut"></i>
                        </div>
                        <div class="rating-badge">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                       
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
       <?php require_once('components/brief.php') ?>

  
<script src="./inc/js/nav.js"></script>