<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once 'db_connect.php';

// Get JSON POST body
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name']) || !isset($data['email']) || !isset($data['message'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input data."]);
    exit();
}

$name = $conn->real_escape_string(trim($data['name']));
$email = $conn->real_escape_string(trim($data['email']));
$message = $conn->real_escape_string(trim($data['message']));

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit();
}

$sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Thank you! Your message has been sent."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to send message. Please try again."]);
}

$conn->close();
?>
