<?php
require_once(__DIR__.'/../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `pet_records` where pet_id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ovas_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define vaccination schedules for common pets
$vaccineSchedule = [
    "Canine Distemper" => ["intervals" => [0, 21, 365]], // Days after initial dose
    "Rabies" => ["intervals" => [0, 365]], // Days after initial dose
    "Dental Shinning" => ["intervals" => [0, 185, 365]],
    "Feline Leukemia" => ["intervals" => [0, 21, 365]],
    "Feline Leukemia" => ["intervals" => [0, 21, 365]], // Days after initial dose
];

// Helper function to calculate dates based on intervals
function calculateSchedule($startDate, $intervals) {
    $dates = [];
    foreach ($intervals as $days) {
        $dates[] = date('Y-m-d', strtotime("$days days", strtotime($startDate)));
    }
    return $dates;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petName = $_POST['pet_name'];
    $vaccineType = $_POST['vaccine_type'];
    $startDate = $_POST['start_date'];

    if (isset($vaccineSchedule[$vaccineType])) {
        $intervals = $vaccineSchedule[$vaccineType]['intervals'];
        $scheduleDates = calculateSchedule($startDate, $intervals);

        $sql = "SELECT * FROM vaccinations WHERE pet_id = $pet_id and  vaccine_type = '$vaccineType' and start_date = '$startDate'  ";
        $res = $conn->query($sql);
        
        if($res->num_rows == 0 ){

        // Save data to database
        $stmt = $conn->prepare("INSERT INTO vaccinations (pet_name, pet_id, vaccine_type, start_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $petName, $pet_id ,$vaccineType, $startDate);
        if ($stmt->execute()) {
            $vaccinationId = $stmt->insert_id;

            foreach ($scheduleDates as $date) {
                $stmtSchedule = $conn->prepare("INSERT INTO vaccination_schedule (vaccination_id, scheduled_date) VALUES (?, ?)");
                $stmtSchedule->bind_param("is", $vaccinationId, $date);
                $stmtSchedule->execute();
            }
        }
        $stmt->close();

    }else{

        echo '<script>alert("Vaccination Already Exist");window.open("","_self")</script>';
    }

    }
}

// Fetch all vaccination schedules
$schedules = [];
$result = $conn->query("SELECT v.pet_name, v.vaccine_type, vs.scheduled_date FROM vaccinations v JOIN vaccination_schedule vs ON v.id = vs.vaccination_id WHERE v.pet_id = '$pet_id' ORDER BY v.vaccine_type ASC");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
}
?>
<style>
    body{
        font-family: "Abel", sans-serif;
  font-weight: 400;
  font-style: normal;
  }
</style>
 <div class="container my-5">
        <h1 class="text-center">Vet Clinic Vaccination Schedule</h1>
        <form method="POST" class="mb-5">
            <div class="mb-3">
                <label for="pet_name" class="form-label">Pet Name:</label>
                <input type="text" id="pet_name" name="pet_name" class="form-control" value="<?php echo isset($pet_name) ? $pet_name: '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="pet_name" class="form-label">Pet Id:</label>
                <input type="text" id="pet_id" name="pet_id" class="form-control" value="<?php echo isset($pet_id) ? $pet_id: '' ?>" required>
            </div>

            <div class="mb-3">
                <label for="vaccine_type" class="form-label">Vaccine Type:</label>
                <select id="vaccine_type" name="vaccine_type" class="form-control" required>
                    <?php foreach ($vaccineSchedule as $vaccine => $details): ?>
                        <option value="<?php echo $vaccine; ?>"><?php echo $vaccine; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning">Generate Schedule</button>
        </form>
        <h2 class="text-center">All Scheduled Vaccinations</h2>
        <?php if (!empty($schedules)): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Pet Name</th>
                        <th>Vaccine Type</th>
                        <th>Scheduled Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedules as $schedule): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($schedule['pet_name']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['vaccine_type']); ?></td>
                            <td><?php echo htmlspecialchars($schedule['scheduled_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">No schedules found.</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>