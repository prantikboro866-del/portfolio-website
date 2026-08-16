<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once 'db_connect.php';

$sql = "SELECT * FROM projects ORDER BY created_at DESC";
$result = $conn->query($sql);

$projects = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

echo json_encode([
    "status" => "success",
    "data" => $projects
]);

$conn->close();
?>
