<?php
$host = 'localhost';
$username = 'root'; // default XAMPP username
$password = ''; // default XAMPP password
$database = 'portfolio_db';

// Create connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Ensure database exists and select it
$conn->select_db($database);

// Optional: Automatically create database and tables if they don't exist
// This makes setup easier for the user without needing phpMyAdmin import
$sqlCreateDb = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sqlCreateDb) === TRUE) {
    $conn->select_db($database);
    
    // Create projects table
    $sqlProjects = "CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        tech_stack VARCHAR(255) NOT NULL,
        image_url VARCHAR(255) DEFAULT '',
        link VARCHAR(255) DEFAULT '',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sqlProjects);

    // Create messages table
    $sqlMessages = "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sqlMessages);
    
    // Seed projects table if empty
    $checkProjects = $conn->query("SELECT id FROM projects LIMIT 1");
    if ($checkProjects && $checkProjects->num_rows == 0) {
        $insertData = "INSERT INTO projects (title, description, tech_stack, image_url, link) VALUES 
        ('E-Commerce Platform', 'A fully responsive online store with shopping cart and payment integration built as part of my college final year project.', 'PHP, MySQL, HTML, CSS, JavaScript', '', '#'),
        ('Interactive Dashboard', 'A dynamic data visualization dashboard consuming third-party APIs to display real-time analytics.', 'JavaScript, HTML, CSS, Chart.js', '', '#'),
        ('College Management System', 'A system to manage student records, grades, and attendance with role-based access control.', 'PHP, MySQL, Bootstrap', '', '#')";
        $conn->query($insertData);
    }
} else {
    die(json_encode(["status" => "error", "message" => "Error creating database: " . $conn->error]));
}

// Set charset
$conn->set_charset("utf8");
?>
