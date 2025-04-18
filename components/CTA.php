<style>
  .cta-container{
    margin-top:15em;
  }
  .text-column{
 
    margin-top:7em;
    }
    
</style>
<section class="ezy__cta9 cta-container">
  <div class="container">
    <div class="row align-items-center">
      <!-- Text Column -->
      <div class="col-lg-7 col-md-6 p-4">
        <h2 class="ezy__cta9-heading mb-4">Caring for Your Pets Like Family</h2>
        <p class="ezy__cta6-sub-heading mb-4">
          Discover quality veterinary care tailored to your furry companion's health and happiness. Schedule a visit with our expert team today.
        </p>
        <div>
          <button  onclick="window.location.href='//localhost/ovas/?page=services'"  class="btn ezy__cta9-btn me-2">Our Services</button>
          <button onclick="window.location.href='//localhost/ovas/?page=appointment'" class="btn btn-light ezy__cta9-btn">Book Appointment</button>
        </div>
      </div>

      <!-- Image Column -->
      <div class="col-lg-5 col-md-6">
        <img src="../ovas/assets/cta.png" alt="Vet Clinic CTA Image" class="img-fluid" />
      </div>
    </div>
  </div>
</section>



<style>
.ezy__cta9 {
  /* Bootstrap variables */
  --bs-body-color: #ffffff;
  
  background: radial-gradient(
        65.28% 65.28% at 50% 100%,
        rgba(247, 227, 202, 0.644) 0%,
        /* Tan color */ rgba(210, 180, 140, 0) 100%
      ),
      linear-gradient(0deg, #f1d2bd, #ddc3b2); /* Beige color */
  /* Easy Frontend variables */
  --ezy-theme-color: rgb(13, 110, 253);
  --ezy-theme-color-rgb: 13, 110, 253;
  --ezy-form-card-bg: #eff4fd;


  overflow: hidden;
  padding: 0;
  border-radius:1em;
  color: rgb(75, 49, 12);
}

/* Gray Block Style */
.gray .ezy__cta9,
.ezy__cta9.gray {
  /* Easy Frontend Variables */
  --ezy-form-card-bg: #e3ebfa;
}

/* Dark Gray Block Style */
.dark-gray .ezy__cta9,
.ezy__cta9.dark-gray {
  /* Easy Frontend variables */
  --ezy-form-card-bg: #394656;
}

/* Dark Block Style */
.dark .ezy__cta9,
.ezy__cta9.dark {
  /* Easy Frontend variables */
  --ezy-form-card-bg: #1c293a;
}

.ezy__cta9-heading {
  font-weight: bold;
  font-size: 25px;
  line-height: 25px;
  color: rgb(75, 49, 12);
}


@media (min-width: 768px) {
  .ezy__cta9-heading {
    font-size: 40px;
    line-height: 40px;
  }
}

.ezy__cta9 .form-control {
  min-height: 48px;
  line-height: 26px;
  border: none;
  background: rgba(255, 255, 255, 1);
  color: #000000;
}

.ezy__cta9 .form-control:focus {
  box-shadow: none;
}

.ezy__cta9-btn {
  padding: 12px 30px;
  min-width: 110px;
  height: 48px;
  
}
</style>