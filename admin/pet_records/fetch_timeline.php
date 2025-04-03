<?php 

require_once('../../config.php');


$sql = "SELECT * FROM clinic_history";
$result = $conn->query($sql);

$timelineData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $timelineData[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($timelineData);


?>