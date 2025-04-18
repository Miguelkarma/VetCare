<?php
require_once('./config.php');

$action = 'get_users';
$name = $_settings->userdata('id');

if ($action === 'get_users') {
    $search = $_GET['q'] ?? '';
    $stmt = $conn->prepare("SELECT A.pet_id, A.breed, A.pet_name, A.age, B.name, A.category_id 
                           FROM pet_records AS A 
                           INNER JOIN category_list AS B ON A.category_id = B.id 
                           WHERE A.breed LIKE ? AND A.owner_id = ? AND A.delete_flag = 0");
    $search = "%$search%";
    $stmt->bind_param("ss", $search, $name);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'id' => $row['category_id'],
            'breed' => $row['breed'],    
            'text' => $row['pet_name'],
            'cat' => $row['name'],
            'age' => $row['age'],  
            'pet_id' => $row['pet_id'],  
        ];
    }
    echo json_encode(['results' => $users]);
    $stmt->close();
}
?>