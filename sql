
CREATE DATABASE grading_system;

USE grading_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'teacher') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO users (username, email, password, role) VALUES 
('admin_user', 'admin@example.com', '11223', 'admin'),
('teacher_user', 'teacher@example.com', '0987654321', 'teacher');

CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    ENG INT NOT NULL,
    MTC INT NOT NULL,
    SCI INT NOT NULL,
    SST INT NOT NULL,
    total INT NOT NULL
);


CREATE TABLE profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    address TEXT NOT NULL,
    photo VARCHAR(255),
    UNIQUE(name) -- If you want to ensure the name is unique (you can adjust this based on your need)
);
