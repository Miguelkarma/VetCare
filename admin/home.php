<style>
	.fc-event-title-container{
       background-color:rgb(212, 199, 181)!important;
        text-align:center;
        color:#5C4033 !important;
       border: none !important;
      
    }
    .fc-daygrid-event{
        border: none !important;
    }
 

    .fc-today-button{
          background-color: #eacda3!important;
          color: #000 !important;
          border: none !important;
    }
    .fc-prev-button{
          background-color: #eacda3!important;
           color: #000 !important;
          border: none !important;
    }
     .fc-next-button{
          background-color: #eacda3!important;
           color: #000 !important;
           border: none !important;
    }
    .fc-event-title.fc-sticky{
        font-size:2em;
      
    }
   
    .fc-event-title.fc-sticky{
        font-size:2em;
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
     body{
        font-family: "Abel", sans-serif;
  font-weight: 400;
  font-style: normal;
  }
  .card-header{
     background-color:#D6C5AE!important;
  border-top-left-radius: 1em !important;
  border-top-right-radius: 1em !important;
  border:none!important;
      color:rgb(75, 49, 12) !important;
  }
  .card{
    border-radius:1em!important;
        background-color:rgba(243, 241, 239, 0.94) !important;
  }

.btn{
    background-color:#C7B299;
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
<?php if($_settings->userdata('type') == 3): ?>
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
                    echo $conn->query("SELECT * FROM `appointment_list` where email = '$email' and  `status` = 2 ")->num_rows;
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
<div class="card card-outline  rounded-0 shadow">
    <div class="card-header rounded-0">
            <h4 class="card-title" style="font-weight:bold;">Appointment Requests</h4>
    </div>
    <div class="card-body">
        <div id="appointmentCalendar"></div>
    </div>
</div>

<script>
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
            //Random default events
            events: [
                {
                    daysOfWeek: [0,1,2,3,4,5,6], // these recurrent events move separately
                    title:0,
                    allDay: true,
                    }
            ],
            validRange:{
                start: moment(date).format("YYYY-MM-DD"),
            },
            eventDidMount:function(info){
                // console.log(appointment)
                if(!!appointment[info.event.startStr]){
                    var available = parseInt(info.event.title) + parseInt(appointment[info.event.startStr]);
                     $(info.el).find('.fc-event-title.fc-sticky').text(available)
                }
                end_loader()
            },
            editable  : true
        });

    calendar.render();
    })
</script>
<?php endif; ?>