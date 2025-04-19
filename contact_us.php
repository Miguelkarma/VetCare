<style>

body {
  height: 100vh;
  margin: 0;

}


.wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh; 
}




#top-Nav .container {
  width: 100%;
  max-width: 1320px;
  padding: 0 15px;
}


#top-Nav .navbar-nav {
  width: auto;
}


.user-section {
  margin-left: auto;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}


#top-Nav .contact-info {
  white-space: nowrap;
}


#navbarCollapse {
  justify-content: space-between;
}


@media (min-width: 992px) {
  .navbar-nav {
    margin-right: 1rem;
  }
}


@media (max-width: 991px) {
  #top-Nav .container {
    padding: 0 10px;
  }
  
  #navbarCollapse {
    align-items: flex-start;
  }
  
  .user-section {
    width: 100%;
    justify-content: flex-start;
    margin-top: 10px;
  }
}
.contact-card{
    border-radius:1em;
}
#map-container{
    border-radius:1em;
}
.button-contact {
  border-radius: .25rem;
  text-transform: uppercase;
  font-style: normal;
  font-weight: 700;
  padding-left: 25px;
  padding-right: 25px;
  color:rgb(75, 49, 12);
  -webkit-clip-path: polygon(0 0,0 0,100% 0,100% 0,100% calc(100% - 15px),calc(100% - 15px) 100%,15px 100%,0 100%);
  clip-path: polygon(0 0,0 0,100% 0,100% 0,100% calc(100% - 15px),calc(100% - 15px) 100%,15px 100%,0 100%);
  height: 40px;
  font-size: 0.7rem;
  line-height: 14px;
  letter-spacing: 1.2px;
  transition: .2s .1s;
  background: radial-gradient(
        65.28% 65.28% at 50% 100%,
        rgba(247, 227, 202, 0.644) 0%,
        /* Tan color */ rgba(210, 180, 140, 0) 100%
      ),
      linear-gradient(0deg, #f1d2bd, #ddc3b2); /* Beige color */
  border: 0 solid;
  overflow: hidden;
}

.button-contact:hover {
  cursor: pointer;
  transition: all .3s ease-in;
  padding-right: 30px;
  padding-left: 30px;
}
</style>
<div class="container">
  <div class="row my-5">
 
    <div class="col-md-5">
      <div class="card contact-card shadow">
        <div class="card-body rounded-0">
          <h2 class="text-center">Message Us</h2>
          <center><hr class="bg-navy border-navy w-25 border-2"></center>
          <?php if($_settings->chk_flashdata('pop_msg')): ?>
            <div class="alert alert-success">
              <i class="fa fa-check mr-2"></i> <?= $_settings->flashdata('pop_msg') ?>
            </div>
            <script>
              $(function(){
                $('html, body').animate({scrollTop:0})
              })
            </script>
          <?php endif; ?>
          <form action="" id="message-form">
            <input type="hidden" name="id">
            <div class="row">
              <div class="col-md-6">
                <input type="text" class="form-control form-control-sm form-control-border" id="fullname" name="fullname" required placeholder="First and last name">
                <small class="px-3 text-muted">Full Name</small>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control form-control-sm form-control-border" id="contact" name="contact" required placeholder="09xxxxxxxx">
                <small class="px-3 text-muted">Contact #</small>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <input type="email" class="form-control form-control-sm form-control-border" id="email" name="email" required placeholder="vetcare@sample.com">
                <small class="px-3 text-muted">Email</small>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <small class="text-muted">Message</small>
                <textarea name="message" id="message" rows="4" class="form-control form-control-sm rounded-0" required placeholder="Write your message here"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12 text-center">
                <button class="button-contact">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    
   
    <div class="col-md-7">
      <!-- Google map -->
      <div id="map-container" style="height: 400px; width: 100%;">
    <iframe src="https://maps.google.com/maps?q=15.4891123,120.9742448&t=&z=17&ie=UTF8&iwloc=&output=embed"
        frameborder="0" style="border:0; width: 100%; height: 100%;" allowfullscreen></iframe>
</div>

      <br>
      <!-- Contact Information -->
      <div class="row text-center">
        <div class="col-md-4">
          <a class="btn-floating blue accent-1"><i class="fas fa-map-marker-alt" style="  color: rgb(75, 49, 12);"></i></a>
          <dd ><?= $_settings->info('address') ?></dd>
        </div>
        <div class="col-md-4">
          <a class="btn-floating blue accent-1"><i class="fas fa-phone" style="  color: rgb(75, 49, 12);"></i> </a>
          <dd ><?= $_settings->info('contact') ?></dd>
          <dd ><?= $_settings->info('contact2') ?></dd>
        </div>
        <div class="col-md-4">
          <a class="btn-floating blue accent-1"><i class="fas fa-envelope" style="  color: rgb(75, 49, 12);"></i></a>
          <dd ><?= $_settings->info('email') ?></dd>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    $(function(){
        $('#message-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_message",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html, body').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
        })
    })
</script>