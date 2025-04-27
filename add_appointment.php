<?php
require_once('./config.php');
$schedule = $_GET['schedule'];
?>
<style>
   
    #uni_modal, .modal {
        z-index: 1051 !important; 
    }
    .modal-backdrop {
        z-index: 1050 !important;
    }
 
    
  
    .modal-content {
        border-radius: 1rem;
    }
    

    .form-control, 
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        border-radius: 0.5rem !important;
    }
    
 
    .container-fluid {
        padding: 1rem;
    }
    
 
    fieldset {
        margin-bottom: 1.5rem;
        padding: 1rem;
        border-radius: 0.75rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }
    
    legend {
        width: auto;
        padding: 0 0.5rem;
        font-size: 1.1rem;
        font-weight: 500;
        border-radius: 0.25rem;
    }
    #uni_modal .modal-footer {
    display: none !important;
}
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .row > div[class^="col-"] {
            margin-bottom: 1.5rem;
        }
        
        .select2-container {
            width: 100% !important;
        }
    }
    
    /* Select2 improvements */
    .select2-container {
        width: 100% !important;
    }
    
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        border-radius: 0.5rem !important;
        border: 1px solid #ced4da;
        min-height: 38px;
    }
    
    /* Submit button container */
    .form-actions {
        margin-top: 1rem;
        text-align: right;
    }
    
    /* Form group spacing */
    .form-group {
        margin-bottom: 1rem;
    }
    .btn-submit-appointment{
        background: radial-gradient(
        65.28% 65.28% at 50% 100%,
        rgba(247, 227, 202, 0.644) 0%,
        rgba(210, 180, 140, 0) 100%
      ),
      linear-gradient(0deg, #f1d2bd, #ddc3b2);
  color: rgb(75, 49, 12);
  border: 1px solid rgb(75, 49, 12);
    }
</style>

<div class="container-fluid">
    <form action="" id="appointment-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="schedule" value="<?php echo isset($schedule) ? $schedule : '' ?>">
        
        <div class="card mb-3" style="border-radius: 0.75rem;">
            <div class="card-body">
                <dl>
                    <dt class="text-muted">Appointment Schedule</dt>
                    <dd class="pl-3"><b><?= date("F d, Y",strtotime($schedule)) ?></b></dd>
                </dl>
            </div>
        </div>
        <div class="form-group">
    <label for="time_sched" class="control-label">Appointment Time Block</label>
    <?php
    // Get business hours from settings
    $business_start = $_settings->info('business_hours_start') ?: '07:00';
    $business_end = $_settings->info('business_hours_end') ?: '19:00';
    $lunch_start = $_settings->info('lunch_break_start') ?: '11:00';
    $lunch_end = $_settings->info('lunch_break_end') ?: '13:00';
    
    // Format times for display without leading zeros
    $morning_start = date('g:i A', strtotime($business_start)); 
    $morning_end = date('g:i A', strtotime($lunch_start));
    $afternoon_start = date('g:i A', strtotime($lunch_end));
    $afternoon_end = date('g:i A', strtotime($business_end));
    
    $morning_block = $morning_start . ' - ' . $morning_end;
    $afternoon_block = $afternoon_start . ' - ' . $afternoon_end;
    ?>
    <select name="time_sched" id="time_sched" class="form-control" required>
        <option value="<?= $morning_block ?>">Morning (<?= $morning_block ?>)</option>
        <option value="<?= $afternoon_block ?>">Afternoon (<?= $afternoon_block ?>)</option>
    </select>
    <small class="text-muted">Please select your preferred appointment time block</small>
</div>
        
        <div class="row">
            <!-- Owner Information Column -->
            <div class="col-md-6">
                <fieldset>
                    <legend class="text-muted">Owner Information</legend>
                    <div class="form-group">
                        <?php if(!empty($_settings->userdata('username'))){
                            $email = $_settings->userdata('username');
                            $owner_id = $_settings->userdata('id');
                            $owner_firstname = $_settings->userdata('firstname');
                            $owner_lastname = $_settings->userdata('lastname');
                            $contact = $_settings->userdata('contact');
                            $address = $_settings->userdata('address');
                            $owner_name = $owner_firstname." ".$owner_lastname;
                            ?>
                           
                            <input type="hidden" name="owner_id" id="owner_id" class="form-control" placeholder="John D Smith" value ="<?php echo isset($owner_id) ? $owner_id : '' ?>" required>
                            <label for="owner_name" class="control-label">Name</label>
                            <input type="text" name="owner_name" id="owner_name" class="form-control" placeholder="John D Smith" value ="<?php echo isset($owner_name) ? $owner_name : '' ?>" required>
                        <?php }else{ ?>
                            <label for="owner_name" class="control-label">Name</label>
                            <input type="text" name="owner_name" id="owner_name" class="form-control" placeholder="John D Smith" value ="<?php echo isset($owner_name) ? $owner_name : '' ?>" required>
                        <?php  } ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact" class="control-label">Contact #</label>
                        <input type="tel" name="contact" id="contact" class="form-control" 
                               maxlength="13" 
                               placeholder="09XXXXXXXXX or +639XXXXXXXXX"
                               oninput="this.value = this.value.replace(/[^0-9+]/g, '')"
                               value ="<?php echo isset($contact) ? $contact : '' ?>" required>
                        <small class="text-muted">Must be a valid mobile number (09XXXXXXXXX or +639XXXXXXXXX)</small>
                        <small id="contact_error" class="text-danger" style="display:none;"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="jsmith@sample.com" value ="<?php echo isset($email) ? $email : '' ?>" required>
                        <small class="text-muted">Example: Sample@gmail.com</small>
                        <small id="email_error" class="text-danger" style="display:none;"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea name="address" id="address" class="form-control" rows="3" placeholder="Lot 2 Block 23, Here Subd., Over There City, Anywhere, 2306" required><?php echo isset($address) ? $address : '' ?></textarea>
                    </div>
                </fieldset>
            </div>
            
            <!-- Pet Information Column -->
            <div class="col-md-6">
                <?php if(!empty($_settings->userdata('username'))){ ?>
                    <fieldset>
                        <legend class="text-muted">Pet Information</legend>
                        <div class="form-group">
                            <label for="user-select">Select Your Pet Name:</label>
                            <select id="user-select" class="form-control"></select>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_id" class="control-label">Pet Type</label>
                            <input type="hidden" name="pet_id" id="pet_id" class="form-control" value ="<?php echo isset($pet_id) ? $pet_id : '' ?>" required>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value="" selected disabled></option>
                                <?php 
                                $categories = $conn->query("SELECT * FROM category_list where delete_flag = 0 ".(isset($category_id) && !empty($category_id) ? " or id = '{$category_id}'" : "")." order by name asc");
                                while($row = $categories->fetch_assoc()):
                                ?>
                                <option value="<?= $row['id'] ?>" <?= isset($category_id) && in_array($row['id'],explode(',', $category_id)) ? "selected" : "" ?> <?= $row['delete_flag'] == 1 ? "disabled" : "" ?>><?= ucwords($row['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="breed" class="control-label">Breed</label>
                            <input type="text" name="breed" id="breed" class="form-control" placeholder="Siberian Husky" value ="<?php echo isset($breed) ? $breed : '' ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="age" class="control-label">Age</label>
                            <input type="text" name="age" id="age" class="form-control" placeholder="1 yr. old" value ="<?php echo isset($age) ? $age : '' ?>" required>
                        </div>
                    </fieldset>
                <?php }else{ ?>
                    <fieldset>
                        <legend class="text-muted">Pet Information</legend>
                        <div class="form-group">
                            <label for="category_id" class="control-label">Pet Type</label>
                            <input type="hidden" name="pet_id" id="pet_id" class="form-control" value ="0" required>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value="" selected disabled></option>
                                <?php 
                                $categories = $conn->query("SELECT * FROM category_list where delete_flag = 0 ".(isset($category_id) && !empty($category_id) ? " or id = '{$category_id}'" : "")." order by name asc");
                                while($row = $categories->fetch_assoc()):
                                ?>
                                <option value="<?= $row['id'] ?>" <?= isset($category_id) && in_array($row['id'],explode(',', $category_id)) ? "selected" : "" ?> <?= $row['delete_flag'] == 1 ? "disabled" : "" ?>><?= ucwords($row['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="breed" class="control-label">Breed</label>
                            <input type="text" name="breed" id="breed" class="form-control" placeholder="Siberian Husky" value ="<?php echo isset($breed) ? $breed : '' ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="age" class="control-label">Age</label>
                            <input type="text" name="age" id="age" class="form-control" placeholder="1 yr. old" value ="<?php echo isset($age) ? $age : '' ?>" required>
                        </div>
                    </fieldset>
                <?php } ?>
                
                <div class="form-group">
                    <label for="service_id" class="control-label">Service(s)</label>
                    <?php 
                        $services = $conn->query("SELECT * FROM service_list where delete_flag = 0 ".(isset($service_id) && !empty($service_id) ? " or id in ('{$service_id}')" : "")." order by name asc");
                        while($row = $services->fetch_assoc()){
                            unset($row['description']);
                            $service_arr[] = $row;
                        }
                    ?>
                    <select name="service_id[]" id="service_id" class="form-control select2" multiple>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-submit-appointment" style="border-radius: 0.5rem;">Submit Appointment</button>
            <button class="btn btn-secondary mr-2" type="button" data-dismiss="modal" style="border-radius: 0.5rem; ">Cancel</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
    // Function to update the display schedule
    function updateDisplaySchedule() {
        var start = $('#business_hours_start').val();
        var end = $('#business_hours_end').val();
        var lunchStart = $('#lunch_break_start').val();
        var lunchEnd = $('#lunch_break_end').val();
        
        if(start && end && lunchStart && lunchEnd) {
            // Format times for display
            var formattedStart = formatTime(start);
            var formattedEnd = formatTime(end);
            var formattedLunchStart = formatTime(lunchStart);
            var formattedLunchEnd = formatTime(lunchEnd);
            
            var displaySchedule = formattedStart + ' - ' + formattedLunchStart + ' | ' + 
                                 formattedLunchEnd + ' - ' + formattedEnd;
            
            $('#clinic_schedule').val(displaySchedule);
        }
    }
    
    // Format time from 24h to 12h format
    function formatTime(time) {
        var timeParts = time.split(':');
        var hours = parseInt(timeParts[0]);
        var minutes = timeParts[1];
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; 
        return hours + ':' + minutes + ' ' + ampm;
    }
    
    $('#business_hours_start, #business_hours_end, #lunch_break_start, #lunch_break_end').on('change', function() {
        updateDisplaySchedule();
    });
    
    // Initialize on page load
    updateDisplaySchedule();
});
    // Initialize Select2 with AJAX
    $('#user-select').select2({
        ajax: {
            url: 'db_helper.php?action=get_users',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term // Search query
                };
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            }
        },
        placeholder: "Search for a pet",
        minimumInputLength: 0,
        dropdownParent: $('#uni_modal')
    });

    $('#user-select').on('select2:select', function(e) {
        const selectedData = e.params.data;
        $('#breed').val(selectedData.breed);
        $('#age').val(selectedData.age);
        $('#pet_id').val(selectedData.pet_id);
        $('#category_id').val(selectedData.id).trigger('change');
    });

    var service = $.parseJSON('<?= json_encode($service_arr) ?>') || {};
    
    // Function to validate contact information
    function validateContactInfo() {
        var contactValue = $("#contact").val().trim();
        
        if (!(contactValue.match(/^09[0-9]{9}$/) || contactValue.match(/^\+639[0-9]{9}$/))) {
            $('#contact_error').text('Please enter a valid mobile number (09XXXXXXXXX or +639XXXXXXXXX)').show();
            return false;
        }
        $('#contact_error').hide();
        return true;
    }
    
    // Function to validate email
    function validateEmail() {
        var emailValue = $("#email").val().trim();
        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        if (!emailRegex.test(emailValue)) {
            $('#email_error').text('Please enter a valid email address').show();
            return false;
        }
        $('#email_error').hide();
        return true;
    }
    
    $(function(){
        $('#uni_modal').on('shown.bs.modal',function(){
            $('#category_id').select2({
                placeholder:"Please Select Pet Type Here",
                width:'100%',
                dropdownParent:$('#uni_modal')
            });
            
            $('#service_id').select2({
                placeholder:"Please Select Service(s) Here",
                width:'100%',
                dropdownParent:$('#uni_modal')
            });
        });
        
        // Add event handler for contact field to validate on blur
        $('#contact').on('blur', function() {
            validateContactInfo();
        });
        
        // Add event handler for email field to validate on blur
        $('#email').on('blur', function() {
            validateEmail();
        });
        
        $('#category_id').change(function(){
            var id = $(this).val();
            $('#service_id').html('');
            $('#service_id').select2('destroy');
            
            Object.keys(service).map(function(k){
                if($.inArray(id,service[k].category_ids.split(',')) > -1 ){
                    var opt = $("<option>");
                    opt.val(service[k].id);
                    opt.text(service[k].name);
                    $('#service_id').append(opt);
                }
            });
            
            $('#service_id').select2({
                placeholder:"Please Select Service(s) Here",
                width:'100%',
                dropdownParent:$('#uni_modal')
            });
            
            $('#service_id').val('').trigger('change');
        });
        
        $('#uni_modal #appointment-form').submit(function(e){
            e.preventDefault();
            
            // Validate contact number and email before submitting
            if(!validateContactInfo() || !validateEmail()) {
                $('html,body,.modal').animate({scrollTop:0},'fast');
                return false;
            }
            
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_appointment",
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
                    end_loader();
                        setTimeout(() => {
                            uni_modal("Success","success_msg.php?code="+resp.code)
                        }, 750);
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
                    $('html,body,.modal').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
        })
    })
</script>