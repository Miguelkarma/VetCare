<link rel="stylesheet"  href="./css/appointment.css">
<?php 
$appointments = $conn->query("SELECT schedule, time_sched FROM `appointment_list` where `status` in (0,1) and date(schedule) >= '".date("Y-m-d")."' ");
$appoinment_arr = [];
while($row = $appointments->fetch_assoc()){
    $date = date("Y-m-d", strtotime($row['schedule']));
    if(!isset($appoinment_arr[$date])) {
        $appoinment_arr[$date] = ['morning' => 0, 'afternoon' => 0];
    }
    
    // Fix: Properly check which time block this appointment belongs to
    $time_block = strtolower($row['time_sched']);
    
    // Check if it contains the word "morning" in the description field
    if(strpos($time_block, 'morning') !== false) {
        $appoinment_arr[$date]['morning'] += 1;
    } 
    // Check if it contains the word "afternoon" in the description field
    else if(strpos($time_block, 'afternoon') !== false) {
        $appoinment_arr[$date]['afternoon'] += 1;
    }
    // If neither morning nor afternoon is explicitly mentioned, check the time range
    else {
        // Extract the start time from the time_sched
        $time_parts = explode('-', $time_block);
        if(count($time_parts) >= 2) {
            $start_time = trim($time_parts[0]);
            
            // Get the lunch break start time from settings for comparison
            $lunch_start = $_settings->info('lunch_break_start');
            $lunch_start = $lunch_start ? $lunch_start : '11:00';
            $lunch_start_timestamp = strtotime($lunch_start);
            
            // Try to parse the start time
            $appointment_start_timestamp = strtotime($start_time);
            
            // If time can be parsed, compare with lunch start
            if($appointment_start_timestamp !== false && $lunch_start_timestamp !== false) {
                if($appointment_start_timestamp < $lunch_start_timestamp) {
                    $appoinment_arr[$date]['morning'] += 1;
                } else {
                    $appoinment_arr[$date]['afternoon'] += 1;
                }
            } 
            // Fallback if time parsing fails
            else {
                // If AM is in the time string, it's likely morning
                if(stripos($start_time, 'am') !== false) {
                    $appoinment_arr[$date]['morning'] += 1;
                } else {
                    $appoinment_arr[$date]['afternoon'] += 1;
                }
            }
        } 
        // If time format is unexpected, make a best guess
        else {
            if(stripos($time_block, 'am') !== false) {
                $appoinment_arr[$date]['morning'] += 1;
            } else {
                $appoinment_arr[$date]['afternoon'] += 1;
            }
        }
    }
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

    events: [
        {
            daysOfWeek: [0,1,2,3,4,5,6],
            // Modified to dynamically calculate morning and afternoon slots
            title:'Morning: Loading...\nAfternoon: Loading...',
            allDay: true,
        }
    ],

    showNonCurrentDates: false,
    fixedWeekCount: false,

    eventClick: function(info) {
        // Get the date in YYYY-MM-DD format
        var clickedDate = info.event.startStr;
        
        // Show modal with the date
        uni_modal("Set an Appointment", "add_appointment.php?schedule=" + clickedDate, "mid-large");
    },
    validRange:{
        start: moment(date).format("YYYY-MM-DD"),
    },
    eventDidMount: function(info) {
    var date = info.event.startStr;
    var morning_count = 0;
    var afternoon_count = 0;
    
    if(appointment[date]) {
        morning_count = appointment[date].morning || 0;
        afternoon_count = appointment[date].afternoon || 0;
    }
    
    // Calculate morning and afternoon maximums with morning priority for odd numbers
    var max_total = <?= $_settings->info('max_appointment') ?>;
    var max_morning = Math.ceil(max_total / 2); // Priority to morning for odd numbers
    var max_afternoon = Math.floor(max_total / 2);
    
    var morning_available = max_morning - morning_count;
    var afternoon_available = max_afternoon - afternoon_count;
    
    $(info.el).find('.fc-event-title.fc-sticky').html(
        '<i class="fa fa-cloud-sun"></i> <strong>AM:</strong> ' + morning_available + 
        '<br><i class="fa fa-sun"></i> <strong>PM:</strong> ' + afternoon_available
    );
    
    end_loader();
},
    editable: true
});

    calendar.render();
})
</script>