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
  .card-title{
    font-weight:700;
  }
</style>
<?php 
$appointments = $conn->query("SELECT * FROM `appointment_list` where `status` in (0,1) and date(schedule) >= '".date("Y-m-d")."' ");
$appoinment_arr = [];
while($row = $appointments->fetch_assoc()){
    if(!isset($appoinment_arr[$row['schedule']])) $appoinment_arr[$row['schedule']] = 0;
    $appoinment_arr[$row['schedule']] += 1;
}
?>
<div class="content ">
  <div class="container">
    <!-- Daily Schedule on top, full width -->
    <div class="row ">
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

    <!-- Calendar Section -->
    <div class="row">
      <div class="col-12">
        <div class="card card-outline rounded-0 shadow">
          <div class="card-header rounded-0">
            <h4 class="card-title">Appointment Availability</h4>
          </div>
          <div class="card-body">
            <div id="appointmentCalendar"></div>
          </div>
        </div>
      </div>
    </div>
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
                    title:'<?= $_settings->info('max_appointment') ?>',
                    allDay: true,
                    }
            ],
            eventClick: function(info) {
                   console.log(info.el)
                   if($(info.el).find('.fc-event-title.fc-sticky').text() > 0)
                    uni_modal("Set an Appointment","add_appointment.php?schedule="+info.event.startStr,"mid-large")
                },
            validRange:{
                start: moment(date).format("YYYY-MM-DD"),
            },
            eventDidMount:function(info){
                // console.log(appointment)
                if(!!appointment[info.event.startStr]){
                    var available = parseInt(info.event.title) - parseInt(appointment[info.event.startStr]);
                     $(info.el).find('.fc-event-title.fc-sticky').text(available)
                }
                end_loader()
            },
            editable  : true
        });

    calendar.render();
    })
</script>