<link rel="stylesheet"  href="../css/appointment.css">
<style>
  
.card-body {
    width: 100% !important;
    padding: 1rem;
    transition: width 0.3s ease;
}

#appointmentCalendar {
    width: 100% !important;
    min-height: 500px;
    transition: all 0.3s ease;
}


.fc {
    width: 100% !important;
}

.fc-view-container {
    width: 100% !important;
}


.fc-day-grid-container,
.fc-scroller,
.fc-row,
.fc-content-skeleton {
    width: 100% !important;
}

.fc-view > table {
    width: 100% !important;
}

.info-box {
    background-color: #ebe5dd !important;
    box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.2);
        color:rgb(75, 49, 12) !important;
        font-weight:bold;
}
.distinct {
    background-color:#E3D6C2 !important;
    box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.2);
}

</style>
<?php 

$email = $_settings->userdata('username');

$appointments = $conn->query("SELECT * FROM `appointment_list` where `status` in (0,1) and date(schedule) >= '".date("Y-m-d")."' ");
$appoinment_arr = [];
while($row = $appointments->fetch_assoc()){
    if(!isset($appoinment_arr[$row['schedule']])) $appoinment_arr[$row['schedule']] = 0;
    $appoinment_arr[$row['schedule']] += 1;
}
?>

<?php if($_settings->userdata('type') == 1): ?>
    
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box distinct">
            <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Services</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `service_list` ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box ">
            <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-calendar-day"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Pending Request</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `appointment_list` where `status` = 0 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box distinct">
            <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-calendar-day"></i></span>

            <div class="info-box-content">
            <span class="info-box-text ">Confirmed Request</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `appointment_list` where `status` = 1 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box ">
            <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-calendar-day"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Cancelled Request</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `appointment_list` where `status` = 3 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<?php endif; ?>
<?php if($_settings->userdata('type') == 3 || $_settings->userdata('type') == 2) :?> 
 
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box ">
            <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-calendar-day"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Pending Request</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `appointment_list` where email = '$email' and `status` = 0 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box ">
            <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-calendar-day"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Confirmed Request</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `appointment_list` where email = '$email' and  `status` = 1 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box ">
            <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-calendar-day"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Cancelled Request</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `appointment_list` where email = '$email' and  `status` = 3 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<?php endif; ?>
<hr>


<?php if($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2): ?>

    
<!-- Daily Schedule Section -->
<div class="row">
  <div class="col-12">
    <div class="card card-outline rounded-0 shadow p-3">
      <div class="row">
        <div class="col-md-6">
          <dt class="text-muted">
            <i class="fa fa-clock"></i> Daily Schedule
          </dt>
          <dd class="ps-4"><?= $_settings->info('clinic_schedule') ?></dd>
        </div>
        <div class="col-md-6">
          <dt class="text-muted">
            <i class="fa fa-paw"></i> Maximum Daily Appointments
          </dt>
          <dd class="ps-4"><?= $_settings->info('max_appointment') ?></dd>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card card-outline rounded-0 shadow">
    <div class="card-header rounded-0">
            <h4 class="card-title" style="font-weight:bold;">Appointment Availability</h4>
    </div>
    <div class="card-body">
        <div id="appointmentCalendar"></div>
    </div>
</div>

<script>
    //resizing of calendar when collapsed
    $(document).on('collapsed.lte.pushmenu expanded.lte.pushmenu', function() {
    if(calendar) {
 
        setTimeout(function() {
            calendar.updateSize();
        }, 350);
    }
});


$('[data-widget="pushmenu"]').on('click', function() {
    if(calendar) {
        setTimeout(function() {
            calendar.updateSize();
           
            $('.card-body').css('width', '100%');
        }, 350);
    }
});

// Handle window resize events
$(window).resize(function() {
    if(calendar) {
        calendar.updateSize();
    }
});
    
    var calendar;
    var appointment = $.parseJSON('<?= json_encode($appoinment_arr) ?>') || {};
    start_loader();
    $(function(){
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()
        var Calendar = FullCalendar.Calendar;

        calendar = new Calendar(document.getElementById('appointmentCalendar'), {
            headerToolbar: {
                left  : false,
                center: 'title',
            },
            selectable: true,
            themeSystem: 'bootstrap',
            
            events: [
                {
                    daysOfWeek: [0,1,2,3,4,5,6],
                    title:'<?= $_settings->info('max_appointment') ?>',
                    allDay: true,
                }
            ],
            
            showNonCurrentDates: false,
            fixedWeekCount: false,

          
            
            validRange:{
                start: moment(date).format("YYYY-MM-DD"),
            },
            eventDidMount: function(info) {
                if(!!appointment[info.event.startStr]) {
                    var available = parseInt(info.event.title) - parseInt(appointment[info.event.startStr]);
                    $(info.el).find('.fc-event-title.fc-sticky').html('<i class="fa fa-paw"></i> <span class="hide-on-sm"><strong>Available</strong></span><br><strong>' + available + '</strong>');
                } else {
                    $(info.el).find('.fc-event-title.fc-sticky').html('<i class="fa fa-paw"></i> <span class="hide-on-sm"><strong>Available</strong></span><br><b>' + info.event.title + '</b>');
                }
                
                end_loader();
            },
            editable: true
        });

        calendar.render();
    })
</script>
<?php endif; ?>