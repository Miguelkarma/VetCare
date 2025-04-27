<style>
    body{
        font-family: "Abel", sans-serif;
        font-weight: 400;
        font-style: normal;
    }
    /* Styling for the conflict notification */
    .conflict-notification {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #fff;
        border-left: 4px solid #dc3545;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        padding: 15px 20px;
        border-radius: 4px;
        z-index: 1050;
        max-width: 450px;
        width: 100%;
        display: none;
    }
    .conflict-notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .conflict-notification-header h5 {
        margin: 0;
        color: #dc3545;
        font-weight: 600;
    }
    .conflict-notification-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #6c757d;
        cursor: pointer;
    }
    .conflict-notification-body {
        color: #343a40;
    }
</style>
<div class="container-fluid">
    <!-- Time conflict notification card -->
    <div class="conflict-notification" id="conflict-notification">
        <div class="conflict-notification-header">
            <h5>Scheduling Conflict</h5>
            <button type="button" class="conflict-notification-close" onclick="dismissNotification()">&times;</button>
        </div>
        <div class="conflict-notification-body">
            <p>This time slot is already booked by another client. Please select a different time.</p>
        </div>
    </div>

    <form action="" id="update-form">
        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
        <?php 
        require_once('../../config.php');
						$i = 1;
                        $ap_id = $_GET['id'];
						$qry = $conn->query("SELECT * from `appointment_list` WHERE id='$ap_id' order by unix_timestamp(`date_created`) desc ");
						while($row = $qry->fetch_assoc()):
                            $category_id = $row['category_id'];
                            $service_ids = $row['service_ids'];
                            $status = $row['status'];



$service = "";
$total = 0;
$services = $conn->query("SELECT * FROM `service_list` where id in ({$service_ids}) order by `name` asc");
while($row2 = $services->fetch_assoc()){
    if(!empty($service)) $service .=", ";
    $service .=$row2['name'];
    $total = $total + $row2['fee'];
}
$service = (empty($service)) ? "N/A" : $service;

					?>

            <div class="form-group">
                <small style="font-weight:700; font-size:1rem">Status</small>
                <select name="status" id="status" class="form-control form-control-sm form-control-border" required>
                    <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Pending</option>
                    <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>Confirmed</option>
                    <option value="3" <?= isset($status) && $status == 3 ? "selected" : "" ?>>Cancelled</option>
                </select>
            </div>
            <fieldset>


                    <div class="form-group">
                        <label for="time_sched" class="control-label">Schedule Date</label>
                        <input type="date" name="schedule" id="schedule" class="form-control form-control-border" value ="<?php echo isset($row['schedule']) ? $row['schedule'] : '' ?>" required>
                    </div>
                    <div class="form-group">
    <label for="time_sched" class="control-label">Appointment Time Block</label>
    <?php
    // Get business hours from settings
    $business_start = $_settings->info('business_hours_start') ?: '07:00';
    $business_end = $_settings->info('business_hours_end') ?: '19:00';
    $lunch_start = $_settings->info('lunch_break_start') ?: '11:00';
    $lunch_end = $_settings->info('lunch_break_end') ?: '13:00';
    
    $morning_start = date('g:i A', strtotime($business_start)); // g instead of h removes leading zero
    $morning_end = date('g:i A', strtotime($lunch_start));
    $afternoon_start = date('g:i A', strtotime($lunch_end));
    $afternoon_end = date('g:i A', strtotime($business_end));
    
    // Format times for display
       
    $morning_block = $morning_start . ' - ' . $morning_end;
    $afternoon_block = $afternoon_start . ' - ' . $afternoon_end;
    ?>
    <select name="time_sched" id="time_sched" class="form-control form-control-border" required>
        <option value="<?= $morning_block ?>" <?php echo isset($row['time_sched']) && $row['time_sched'] == 'morning' ? 'selected' : ''; ?>>Morning (<?= $morning_block ?>)</option>
        <option value="<?= $afternoon_block ?>" <?php echo isset($row['time_sched']) && $row['time_sched'] == 'afternoon' ? 'selected' : ''; ?>>Afternoon (<?= $afternoon_block ?>)</option>
    </select>
</div>



                </fieldset>
        <?php endwhile; ?>
    </form>
</div>
<script>
    // Function to show the conflict notification
    function showConflictNotification() {
        const notification = document.getElementById('conflict-notification');
        notification.style.display = 'block';
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            dismissNotification();
        }, 5000);
    }

    // Function to dismiss the conflict notification
    function dismissNotification() {
        const notification = document.getElementById('conflict-notification');
        notification.style.display = 'none';
    }

    // Check time availability before submitting
    function checkTimeAvailability(formData, callback) {
        var id = formData.get('id');
        var schedule = formData.get('schedule');
        var time_sched = formData.get('time_sched');
        var status = formData.get('status');
        
        // Only check conflicts if confirming or pending, not when cancelling
        if (status == '3') {
            callback(true); // Skip check for cancelled appointments
            return;
        }
        
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=check_time_availability",
            data: {
                id: id,
                schedule: schedule,
                time_sched: time_sched
            },
            method: 'POST',
            dataType: 'json',
            success: function(resp) {
                if (resp.available) {
                    callback(true); // Time is available
                } else {
                    showConflictNotification();
                    callback(false); // Time is not available
                }
            },
            error: function(err) {
                console.error(err);
                // Fail safely - prevent submission
                showConflictNotification();
                callback(false);
            }
        });
    }

    $(function(){
        $('#update-form').submit(function(e){
            e.preventDefault();
            
            var formData = new FormData($(this)[0]);
            var _this = $("#entry-form");
            $('.pop-msg').remove();
            var el = $('<div>');
                el.addClass("pop-msg alert");
                el.hide();
            
            start_loader();
            
            // First check if the time is available
            checkTimeAvailability(formData, function(isAvailable) {
                if (!isAvailable) {
                    // Time is not available, don't proceed with update
                    end_loader();
                    return false;
                }
                
                // Time is available, proceed with the update
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=update_appointment_status",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    dataType: 'json',
                    error: function(err) {
                        console.log(err);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    },
                    success: function(resp) {
                        if (resp.status == 'success') {
                            location.reload();
                        } else if (resp.status == 'failed' && resp.msg && resp.msg.includes("time slot is already booked")) {
                            // Show the conflict notification for time slot conflicts
                            showConflictNotification();
                            end_loader();
                        } else if (!!resp.msg) {
                            el.addClass("alert-danger");
                            el.text(resp.msg);
                            _this.prepend(el);
                            el.show('slow');
                            end_loader();
                        } else {
                            el.addClass("alert-danger");
                            el.text("An error occurred due to unknown reason.");
                            _this.prepend(el);
                            el.show('slow');
                            end_loader();
                        }
                        $('html, body, .modal').animate({scrollTop: 0}, 'fast');
                    }
                });
            });
        });

        $(document).ready(function(){
            $('.summernote').summernote({
                height: '20vh',
                toolbar: [
                    [ 'style', [ 'style' ] ],
                    [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                    [ 'fontname', [ 'fontname' ] ],
                    [ 'fontsize', [ 'fontsize' ] ],
                    [ 'color', [ 'color' ] ],
                    [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                    [ 'table', [ 'table' ] ],
                    ['insert', ['link', 'picture']],
                    [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                ]
            });
        });
    });
</script>