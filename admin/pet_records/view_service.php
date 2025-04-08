<?php 
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * from clinic_history AS A INNER JOIN category_list AS B ON A.category_id = B.id INNER JOIN pet_records AS C ON A.pet_id = C.pet_id WHERE A.pet_id = '".$_GET['id']."' ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }else{
    echo "<script>alert('No Records Found'); location.replace('./?page=pet_records');</script>";
    }
}
else{
    echo "<script>alert('Appointment Request ID is required'); location.replace('./?page=pet_records');</script>";
}

$sql = "SELECT A.service_ids, A.breed, A.category_id, A.date_created, A.notes ,C.age, C.pet_name from clinic_history AS A INNER JOIN pet_records AS C ON A.pet_id = C.pet_id WHERE A.pet_id = '".$_GET['id']."' ";
$result = $conn->query($sql);

?>
    <style>
        .timeline {
            position: relative;
            padding: 2rem 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 2px;
            background: #ddd;
            transform: translateX(-50%);
        }
        .timeline-item {
            position: relative;
            margin: 2rem 0;
        }
        .timeline-item.left {
            text-align: right;
        }
        .timeline-item.right {
            text-align: left;
        }
        .timeline-item .timeline-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 1.5rem;
            height: 1.5rem;
            background: #0d6efd;
            border-radius: 50%;
        }
        .timeline-item.left .timeline-content {
            margin-right: calc(50% + 1.5rem);
        }
        .timeline-item.right .timeline-content {
            margin-left: calc(50% + 1.5rem);
        }
        .timeline-content {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .bg{
            background-color: #eacda3!important;
	border-radius:0.5em!important;
    color:rgb(75, 49, 12) !important;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Clinic History Timeline</h1>
        <div class="timeline">
            <?php
            // Check if there are records


            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {


                    $service_data = $row['service_ids'];
                    $position = $row['breed'];
                    $cat_id = $row['category_id'];
                    echo "  <p><strong>Date:</strong> {$row['date_created']} </p> ";
                    echo "
                    <div class='timeline-item $position'>
                        <div class='timeline-content'>
                        ";
                        $category = $conn->query("SELECT * FROM `category_list` where id = '$cat_id' order by `name` asc");
                        $row2 = $category->fetch_assoc();
                         
                          echo "  <p><strong>Pet Type:</strong>{$row2['name']} </p> ";
                            echo "<p><strong>Pet Name:</strong> {$row['pet_name']}</p>
                            <p><strong>Pet Age:</strong> {$row['age']}</p>
                            <p class='py-3 px-4 text-light bg'>Service(s)</p>";
                            
                            $services = $conn->query("SELECT * FROM `service_list` where id in ({$service_data}) order by `name` asc");
                            $service = "";
                            $total = 0;
                            while($row1 = $services->fetch_assoc()){
                                if(!empty($service)) $service .=", ";
                                 $service .=$row1['name'];
                                $total = $total + $row1['fee'];
                            }
                            $service = (empty($service)) ? "N/A" : $service;
                         
                         echo "<p class='py-1 px-2 text-right'>$service</p>
                            <p class='py-1 px-2 text-right'>Total: $total</p> ";

                            
                           echo " <p class='py-1 px-2 text-left'>Doctor's Note: {$row['notes']}</p>
                        </div>
                    </div>
                    ";
                    
                }
            } else {
                echo "<p class='text-center'>No events found in the timeline.</p>";
            }

            // Close the database connection
         
            ?>
        </div>
    </div>