<?php


require 'vendor/autoload.php';

require_once(__DIR__ . '/email_config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Send appointment confirmation email to client
 * 
 * @param string $recipient_email Client's email address
 * @param string $recipient_name Client's name
 * @param array $appointment Appointment details array
 * @return bool Success or failure
 */
function send_appointment_confirmation($recipient_email, $recipient_name, $appointment) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
/**
 * Create email_config.php for this at the same level of email_functions.php (ROOT) 
 * it should be like this 
define('BREVO_HOST', 'BREVO_HOST');
define('BREVO_PORT', BREVO_PORT);
define('BREVO_USERNAME', 'BREVO_LOGIN_IN_STMP_PAGE'); 
define('BREVO_API_KEY', 'BREVO_STMP_KEY'); 
define('BREVO_ENCRYPTION', 'tls');

// Email sender settings
define('EMAIL_FROM_ADDRESS', 'BREVO_EMAIL'); 
define('EMAIL_FROM_NAME', 'VET_NAME');
define('EMAIL_REPLY_TO', 'BREVO_EMAIL'); 

// Email content settings
define('EMAIL_SUBJECT_PREFIX', '[VET_NAME] '); 
 */
        $mail->isSMTP();
        $mail->Host       = BREVO_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = BREVO_USERNAME;
        $mail->Password   = BREVO_API_KEY;
        $mail->SMTPSecure = BREVO_ENCRYPTION;
        $mail->Port       = BREVO_PORT;
        
        // Recipients
        $mail->setFrom(EMAIL_FROM_ADDRESS, EMAIL_FROM_NAME);
        $mail->addAddress($recipient_email, $recipient_name);
        $mail->addReplyTo(EMAIL_REPLY_TO, EMAIL_FROM_NAME);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = EMAIL_SUBJECT_PREFIX . 'Appointment Confirmation #' . $appointment['code'];
        
        // Create HTML email body
        $mail->Body = get_appointment_email_template($appointment);
        $mail->AltBody = get_appointment_email_text($appointment);
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Generate HTML email template for appointment confirmation with service details
 * 
 * @param array $appointment Appointment details
 * @return string HTML content
 */
function get_appointment_email_template($appointment) {
    // Format the schedule date
    $appointment_date = date("F d, Y", strtotime($appointment['schedule']));
    
    // Service information
    $services_html = '';
    if (!empty($appointment['service_names'])) {
        $services_html = '<tr>
            <th>Services:</th>
            <td>' . $appointment['service_names'] . '</td>
        </tr>';
    }
    
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .header {
                background-color: #f1d2bd;
                padding: 15px;
                text-align: center;
                border-radius: 5px 5px 0 0;
            }
            .content {
                padding: 20px;
            }
            .footer {
                background-color: #f8f9fa;
                padding: 15px;
                text-align: center;
                font-size: 12px;
                border-radius: 0 0 5px 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                background-color: #f8f9fa;
                width: 30%;
            }
            .btn {
                display: inline-block;
                padding: 10px 20px;
                background-color: #f1d2bd;
                color: #4b310c;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>Appointment Confirmation</h2>
                <p>Booking Reference: ' . $appointment['code'] . '</p>
            </div>
            <div class="content">
                <p>Dear ' . $appointment['owner_name'] . ',</p>
                <p>Thank you for booking an appointment with our veterinary clinic. We have received your appointment request and it has been successfully registered in our system.</p>
                
                <h3>Appointment Details:</h3>
                <table>
                    <tr>
                        <th>Date:</th>
                        <td>' . $appointment_date . '</td>
                    </tr>
                    <tr>
                        <th>Time Block:</th>
                        <td>' . $appointment['time_sched'] . '</td>
                    </tr>
                    <tr>
                        <th>Pet Type:</th>
                        <td>' . $appointment['category_id'] . '</td>
                    </tr>
                    <tr>
                        <th>Breed:</th>
                        <td>' . $appointment['breed'] . '</td>
                    </tr>
                    <tr>
                        <th>Age:</th>
                        <td>' . $appointment['age'] . '</td>
                    </tr>
                    ' . $services_html . '
                </table>
                
                <p>Our staff will review your appointment and contact you at ' . $appointment['contact'] . ' to confirm the exact time of your appointment.</p>
                
                <p>If you need to reschedule or cancel your appointment, please contact us as soon as possible.</p>
                
                <p>Best regards,<br>' . EMAIL_FROM_NAME . '</p>
            </div>
            <div class="footer">
                <p>This is an automated message. Please do not reply to this email.</p>
                <p>&copy; ' . date("Y") . ' ' . EMAIL_FROM_NAME . '. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    return $html;
}

/**
 * Generate plain text email for appointment confirmation with service details
 * 
 * @param array $appointment Appointment details
 * @return string Plain text content
 */
function get_appointment_email_text($appointment) {
    // Format the schedule date
    $appointment_date = date("F d, Y", strtotime($appointment['schedule']));
    
    // Service information
    $services_text = '';
    if (!empty($appointment['service_names'])) {
        $services_text = "Services: " . $appointment['service_names'] . "\n";
    }
    
    $text = "APPOINTMENT CONFIRMATION\n";
    $text .= "Booking Reference: " . $appointment['code'] . "\n\n";
    
    $text .= "Dear " . $appointment['owner_name'] . ",\n\n";
    $text .= "Thank you for booking an appointment with our veterinary clinic. We have received your appointment request and it has been successfully registered in our system.\n\n";
    
    $text .= "APPOINTMENT DETAILS:\n";
    $text .= "Date: " . $appointment_date . "\n";
    $text .= "Time Block: " . $appointment['time_sched'] . "\n";
    $text .= "Pet Type: " . $appointment['category_id'] . "\n";
    $text .= "Breed: " . $appointment['breed'] . "\n";
    $text .= "Age: " . $appointment['age'] . "\n";
    $text .= $services_text . "\n";
    
    $text .= "Our staff will review your appointment and contact you at " . $appointment['contact'] . " to confirm the exact time of your appointment.\n\n";
    
    $text .= "If you need to reschedule or cancel your appointment, please contact us as soon as possible.\n\n";
    
    $text .= "Best regards,\n";
    $text .= EMAIL_FROM_NAME . "\n\n";
    
    $text .= "This is an automated message. Please do not reply to this email.\n";
    $text .= "© " . date("Y") . " " . EMAIL_FROM_NAME . ". All rights reserved.";
    
    return $text;
}

/**
 * Send an email notification to the admin about new appointments
 * 
 * @param array $appointment Appointment details
 * @return bool Success or failure
 */
function send_admin_notification($appointment) {
    // This function can be used to notify the admin about new appointments
    // Implementation is similar to send_appointment_confirmation but with different content
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = BREVO_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = BREVO_USERNAME;
        $mail->Password   = BREVO_API_KEY;
        $mail->SMTPSecure = BREVO_ENCRYPTION;
        $mail->Port       = BREVO_PORT;
        
        // Admin email - you should set this in email_config.php
        $admin_email = 'sanospaulmigz@gmail.com'; // Replace with actual admin email
        
        // Recipients
        $mail->setFrom(EMAIL_FROM_ADDRESS, EMAIL_FROM_NAME);
        $mail->addAddress($admin_email, 'Clinic Admin');
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = EMAIL_SUBJECT_PREFIX . 'New Appointment #' . $appointment['code'];
        
        // Create admin notification email
        $mail->Body = get_admin_notification_template($appointment);
        $mail->AltBody = get_admin_notification_text($appointment);
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Admin notification could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Generate HTML email template for admin notification
 * 
 * @param array $appointment Appointment details
 * @return string HTML content
 */
function get_admin_notification_template($appointment) {
    // Format the schedule date
    $appointment_date = date("F d, Y", strtotime($appointment['schedule']));
    
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .header {
                background-color: #f1d2bd;
                padding: 15px;
                text-align: center;
                border-radius: 5px 5px 0 0;
            }
            .content {
                padding: 20px;
            }
            .footer {
                background-color: #f8f9fa;
                padding: 15px;
                text-align: center;
                font-size: 12px;
                border-radius: 0 0 5px 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                background-color: #f8f9fa;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>New Appointment Notice</h2>
                <p>Reference: ' . $appointment['code'] . '</p>
            </div>
            <div class="content">
                <p>A new appointment has been booked in the system.</p>
                
                <h3>Appointment Details:</h3>
                <table>
                    <tr>
                        <th>Date:</th>
                        <td>' . $appointment_date . '</td>
                    </tr>
                    <tr>
                        <th>Time Block:</th>
                        <td>' . $appointment['time_sched'] . '</td>
                    </tr>
                    <tr>
                        <th>Owner:</th>
                        <td>' . $appointment['owner_name'] . '</td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td>' . $appointment['contact'] . '</td>
                    </tr>
                    <tr>
                        <th>Pet Type:</th>
                        <td>' . $appointment['category_id'] . '</td>
                    </tr>
                    <tr>
                        <th>Breed:</th>
                        <td>' . $appointment['breed'] . '</td>
                    </tr>
                    <tr>
                        <th>Age:</th>
                        <td>' . $appointment['age'] . '</td>
                    </tr>
                </table>
                
                <p>Please log into the system to review and confirm this appointment.</p>
            </div>
            <div class="footer">
                <p>This is an automated notification from your veterinary appointment system.</p>
                <p>&copy; ' . date("Y") . ' ' . EMAIL_FROM_NAME . '. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    return $html;
}

/**
 * Generate plain text email for admin notification
 * 
 * @param array $appointment Appointment details
 * @return string Plain text content
 */
function get_admin_notification_text($appointment) {
    // Format the schedule date
    $appointment_date = date("F d, Y", strtotime($appointment['schedule']));
    
    $text = "NEW APPOINTMENT NOTICE\n";
    $text .= "Reference: " . $appointment['code'] . "\n\n";
    
    $text .= "A new appointment has been booked in the system.\n\n";
    
    $text .= "APPOINTMENT DETAILS:\n";
    $text .= "Date: " . $appointment_date . "\n";
    $text .= "Time Block: " . $appointment['time_sched'] . "\n";
    $text .= "Owner: " . $appointment['owner_name'] . "\n";
    $text .= "Contact: " . $appointment['contact'] . "\n";
    $text .= "Pet Type: " . $appointment['category_id'] . "\n";
    $text .= "Breed: " . $appointment['breed'] . "\n";
    $text .= "Age: " . $appointment['age'] . "\n\n";
    
    $text .= "Please log into the system to review and confirm this appointment.\n\n";
    
    $text .= "This is an automated notification from your veterinary appointment system.\n";
    $text .= "© " . date("Y") . " " . EMAIL_FROM_NAME . ". All rights reserved.";
    
    return $text;
}

/**
 * Send appointment status update email to client
 * 
 * @param string $recipient_email Client's email address
 * @param string $recipient_name Client's name
 * @param array $appointment Appointment details array with updated status
 * @return bool Success or failure
 */
function send_status_update_email($recipient_email, $recipient_name, $appointment) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = BREVO_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = BREVO_USERNAME;
        $mail->Password   = BREVO_API_KEY;
        $mail->SMTPSecure = BREVO_ENCRYPTION;
        $mail->Port       = BREVO_PORT;
        
        // Recipients
        $mail->setFrom(EMAIL_FROM_ADDRESS, EMAIL_FROM_NAME);
        $mail->addAddress($recipient_email, $recipient_name);
        $mail->addReplyTo(EMAIL_REPLY_TO, EMAIL_FROM_NAME);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = EMAIL_SUBJECT_PREFIX . 'Appointment Status Update #' . $appointment['code'];
        
        // Create HTML email body
        $mail->Body = get_status_update_email_template($appointment);
        $mail->AltBody = get_status_update_email_text($appointment);
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Status update email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Generate HTML email template for appointment status update
 * 
 * @param array $appointment Appointment details with status
 * @return string HTML content
 */
function get_status_update_email_template($appointment) {
    // Format the schedule date
    $appointment_date = date("F d, Y", strtotime($appointment['schedule']));
    
    // Convert status code to text
    $status_text = get_status_text($appointment['status']);
    
    // Get appropriate message based on status
    $status_message = get_status_message($appointment['status']);
    
    // Get status color for header background
    $status_color = get_status_color($appointment['status']);
    
    // Service information
    $services_html = '';
    if (!empty($appointment['service_names'])) {
        $services_html = '<tr>
            <th>Services:</th>
            <td>' . $appointment['service_names'] . '</td>
        </tr>';
    }
    
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .header {
                background-color: ' . $status_color . ';
                padding: 15px;
                text-align: center;
                border-radius: 5px 5px 0 0;
            }
            .content {
                padding: 20px;
            }
            .footer {
                background-color: #f8f9fa;
                padding: 15px;
                text-align: center;
                font-size: 12px;
                border-radius: 0 0 5px 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                background-color: #f8f9fa;
                width: 30%;
            }
            .status-badge {
                display: inline-block;
                padding: 5px 10px;
                background-color: ' . $status_color . ';
                color: #fff;
                border-radius: 3px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>Appointment Status Update</h2>
                <p>Booking Reference: ' . $appointment['code'] . '</p>
            </div>
            <div class="content">
                <p>Dear ' . $appointment['owner_name'] . ',</p>
                <p>This is to inform you that your appointment status has been updated to <span class="status-badge">' . $status_text . '</span>.</p>
                
                <p>' . $status_message . '</p>
                
                <h3>Appointment Details:</h3>
                <table>
                    <tr>
                        <th>Date:</th>
                        <td>' . $appointment_date . '</td>
                    </tr>
                    <tr>
                        <th>Time Block:</th>
                        <td>' . $appointment['time_sched'] . '</td>
                    </tr>
                    <tr>
                        <th>Pet Type:</th>
                        <td>' . $appointment['category_id'] . '</td>
                    </tr>
                    <tr>
                        <th>Breed:</th>
                        <td>' . $appointment['breed'] . '</td>
                    </tr>
                    <tr>
                        <th>Age:</th>
                        <td>' . $appointment['age'] . '</td>
                    </tr>
                    ' . $services_html . '
                </table>
                
                <p>If you have any questions or need further assistance, please contact us at ' . EMAIL_REPLY_TO . '.</p>
                
                <p>Best regards,<br>' . EMAIL_FROM_NAME . '</p>
            </div>
            <div class="footer">
                <p>This is an automated message. Please do not reply to this email.</p>
                <p>&copy; ' . date("Y") . ' ' . EMAIL_FROM_NAME . '. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    return $html;
}

/**
 * Generate plain text email for appointment status update
 * 
 * @param array $appointment Appointment details with status
 * @return string Plain text content
 */
function get_status_update_email_text($appointment) {
    // Format the schedule date
    $appointment_date = date("F d, Y", strtotime($appointment['schedule']));
    
    // Convert status code to text
    $status_text = get_status_text($appointment['status']);
    
    // Get appropriate message based on status
    $status_message = get_status_message($appointment['status']);
    
    // Service information
    $services_text = '';
    if (!empty($appointment['service_names'])) {
        $services_text = "Services: " . $appointment['service_names'] . "\n";
    }
    
    $text = "APPOINTMENT STATUS UPDATE\n";
    $text .= "Booking Reference: " . $appointment['code'] . "\n\n";
    
    $text .= "Dear " . $appointment['owner_name'] . ",\n\n";
    $text .= "This is to inform you that your appointment status has been updated to " . $status_text . ".\n\n";
    $text .= $status_message . "\n\n";
    
    $text .= "APPOINTMENT DETAILS:\n";
    $text .= "Date: " . $appointment_date . "\n";
    $text .= "Time Block: " . $appointment['time_sched'] . "\n";
    $text .= "Pet Type: " . $appointment['category_id'] . "\n";
    $text .= "Breed: " . $appointment['breed'] . "\n";
    $text .= "Age: " . $appointment['age'] . "\n";
    $text .= $services_text . "\n";
    
    $text .= "If you have any questions or need further assistance, please contact us at " . EMAIL_REPLY_TO . ".\n\n";
    
    $text .= "Best regards,\n";
    $text .= EMAIL_FROM_NAME . "\n\n";
    
    $text .= "This is an automated message. Please do not reply to this email.\n";
    $text .= "© " . date("Y") . " " . EMAIL_FROM_NAME . ". All rights reserved.";
    
    return $text;
}

/**
 * Get status text from status code
 * 
 * @param int $status_code Status code (0, 1, 2, 3, 4)
 * @return string Status text
 */
function get_status_text($status_code) {
    switch ($status_code) {
        case 0:
            return "Pending";
        case 1:
            return "Confirmed";
        case 2:
            return "Completed";
        case 3:
            return "Cancelled";
        case 4:
            return "No Show";
        default:
            return "Unknown";
    }
}

/**
 * Get appropriate message based on status
 * 
 * @param int $status_code Status code (0, 1, 2, 3, 4)
 * @return string Message
 */
function get_status_message($status_code) {
    switch ($status_code) {
        case 0:
            return "Your appointment request is currently pending. Our staff will review it shortly.";
        case 1:
            return "Your appointment has been confirmed. We look forward to seeing you and your pet!";
        case 2:
            return "Your appointment has been marked as completed. Thank you for visiting our clinic.";
        case 3:
            return "Your appointment has been cancelled. If you would like to reschedule, please contact us or book a new appointment through our system.";
        case 4:
            return "Your appointment has been marked as a no-show. If you would like to reschedule, please contact us or book a new appointment through our system.";
        default:
            return "Please contact us if you have any questions about your appointment.";
    }
}

/**
 * Get color for status styling
 * 
 * @param int $status_code Status code (0, 1, 2, 3, 4)
 * @return string Hex color code
 */
function get_status_color($status_code) {
    switch ($status_code) {
        case 0:
            return "#ff9800"; // Orange for pending
        case 1:
            return "#4CAF50"; // Green for confirmed
        case 2:
            return "#2196F3"; // Blue for completed
        case 3:
            return "#F44336"; // Red for cancelled
        case 4:
            return "#9E9E9E"; // Grey for no-show
        default:
            return "#f1d2bd"; // Default color
    }
}