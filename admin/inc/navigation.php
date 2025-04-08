<style>
  .main-sidebar {
    background-color: #fffffc;
    background-image: linear-gradient(200deg, #fffffc 0%, #beb7a4 74%);

     overflow: hidden !important;
  }
  .nav-link{
    color:rgb(75, 49, 12) !important;
  }
   .nav-header{
    color:rgb(75, 49, 12) !important;
  }
  .active{
    background-color: #fffffc;
    background-image: linear-gradient(200deg,rgb(255, 255, 252) 0%,rgb(150, 149, 148) 74%);
    border: none !important;
  }

</style>

<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-light levation-8 " >
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link  text-sm  border-0 ">
        <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-2 " style="width: 1.8rem;height: 1.8rem;max-height: unset;object-fit:scale-down;object-position:center center">
        <span class="brand-text font-weight-bold text-color-black" style="color:#333;"><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=appointment_user" class="nav-link nav-appointment_user">
                        <i class="nav-icon fas fa-calendar-day"></i>
                        <p>
                          Appointment Requests
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=pet_records" class="nav-link nav-pet_records">
                        <i class="nav-icon fas fa-paw"></i>
                        <p>
                        Your Pet Records 
                        </p>
                      </a>
                    </li>
                    <?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2 ): ?>
                      <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=pet_records/pet_all" class="nav-link nav-pet_records-pet_all">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                        All Pet Records 
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>
                   <!--<li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=pethistory" class="nav-link nav-pethistory">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                         Pet History
                        </p>
                      </a>
                    </li>-->
                    <?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2 ): ?>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=appointments" class="nav-link nav-appointments">
                        <i class="nav-icon fas fa-calendar-day"></i>
                        <p>
                          Appointment Requests Clients
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>
                    <?php if($_settings->userdata('type') == 1): ?>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=inquiries" class="nav-link nav-inquiries">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>
                          Inquiries
                        </p>
                      </a>
                    </li>
                    <li class="nav-header">Maintenance</li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=categories" class="nav-link nav-categories">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                          Category List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=services" class="nav-link nav-services">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                          Service List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                          User List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                          Settings
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>

                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>
      <script>
        var page;
    $(document).ready(function(){
      page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      page = page.replace(/\//gi,'-');

      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
      
		$('#receive-nav').click(function(){
      $('#uni_modal').on('shown.bs.modal',function(){
        $('#find-transaction [name="tracking_code"]').focus();
      })
			uni_modal("Enter Tracking Number","transaction/find_transaction.php");
		})
    })
  </script>