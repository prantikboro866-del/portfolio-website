-- Database Creation
CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

-- Projects Table
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    tech_stack VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) DEFAULT '',
    link VARCHAR(255) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Messages Table (for Contact Form)
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Projects
INSERT INTO projects (title, description, tech_stack, image_url, link) VALUES 
('E-Commerce Platform', 'A fully responsive online store with shopping cart and payment integration built as part of my college final year project.', 'PHP, MySQL, HTML, CSS, JavaScript', '', '#'),
('Interactive Dashboard', 'A dynamic data visualization dashboard consuming third-party APIs to display real-time analytics.', 'JavaScript, HTML, CSS, Chart.js', '', '#'),
('College Management System', 'A system to manage student records, grades, and attendance with role-based access control.', 'PHP, MySQL, Bootstrap', '', '#');
