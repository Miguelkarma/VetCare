<style>
   html, body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .content-wrapper {
            width: 100%;
            height: 90%;
        }
        .card {
            height: 100% !important;
        }
        .card-body {
            height: 100% !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

.team-container{
    margin-top:9em;
}

.vet-card{
  background: radial-gradient(
        65.28% 65.28% at 50% 100%,
        rgba(247, 227, 202, 0.644) 0%,
        /* Tan color */ rgba(210, 180, 140, 0) 100%
      ),
      linear-gradient(0deg, #f1d2bd, #ddc3b2); /* Beige color */
      color:rgb(75, 49, 12);
}



</style>

<div class="col-12 ">
    <div class="row my-5 ">
    
        <div class="col-md-12 ">
        <section class="py-5">
  <div class="container">
    <div class="row">
      <!-- Left Column -->
      <div class="col-md-5">
    <span class="text-muted">Our Story</span>
    <h2 class="font-weight-bold" style="font-size: 2.5rem;">About Us</h2>
    <p class="lead">
        We treat pets like family. Our team helps keep them healthy, happy, and safe with care you can trust.
    </p>
</div>

      <!-- Right Column -->
      <div class="col-md-6 offset-md-1">
      <?= file_get_contents("about_us.html") ?>
      </div>
      
    </div>
    <div class="container team-container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="mb-4">
          <span class="small mt-4 d-block text-uppercase ">Meet Our Team</span>
          <h2 class="font-weight-bold" style="font-size: 2.5rem;">Dedicated Veterinary Professionals</h2>
          <p>
            Our experienced and compassionate veterinary staff is here to provide the best care possible for your furry family members.
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="row pt-4">
        <!-- Team Member 1 -->
        <div class="col-md-6 text-center p-4 shadow-lg mb-4 vet-card rounded-lg">
          <div>
            <img alt="Dr. Veron Obligacion" class="rounded-circle mb-3" 
              src="../ovas/assets/doctor.png"
              style="height: 10vh;" loading="lazy">
            <p>
              Dr. Veron provides expert care in both routine check-ups and complex medical procedures. She ensures every pet receives personalized attention and love.
            </p>
          </div>
          <div class="mt-2 py-2" style="border-top:1px solid black">
            <h5><strong>Dr. Veronica Obligacion</strong></h5>
            <small class="text-secondary" style="letter-spacing:1px">Veterinarian & Clinic Head</small>
          </div>
        </div>

        <!-- Team Member 2 -->
        <div class="col-md-6 text-center p-4 mb-4">
          <div>
            <img alt="Kiko Magnaye" class="rounded-circle mb-3"
              src="../ovas/assets/staff.png"
              style="height: 10vh;" loading="lazy">
            <p>
              Kiko handles patient coordination and assists in treatments. His friendly personality makes pets and their owners feel at ease during every visit.
            </p>
          </div>
          <div class="mt-2 py-2 " style="border-top:1px solid black">
            <h5><strong>Kiko Magnaye</strong></h5>
            <small class="text-secondary" style="letter-spacing:1px">Vet Assistant & Client Care</small>
          </div>
   
  </div>
  </div>
</div>


  </div>
</section>

       
