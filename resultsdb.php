<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "grading_system";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch all students from the database
function get_students() {
    global $conn;
    $sql = "SELECT * FROM results";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new student to the database
function add_student($name, $ENG, $MTC, $SCI, $SST, $total) {
    global $conn;
    $sql = "INSERT INTO results (name, ENG, MTC, SCI, SST, total) 
            VALUES (?, ?, ?, ?, ?, ? )";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("siiiii", $name, $ENG, $MTC, $SCI, $SST, $total);

        if (!$stmt->execute()) {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Function to get a student by ID
function get_student_by_id($id) {
    global $conn;
    $sql = "SELECT * FROM results WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
        $stmt->close();
        return $student;
    } else {
        echo "Error preparing statement: " . $conn->error;
        return null;
    }
}


// Function to update a student's data
function update_student($id, $name, $ENG, $MTC, $SCI, $SST, $total) {
    global $conn;
    $sql = "UPDATE results SET name = ?, ENG = ?, MTC = ?, SCI = ?, SST = ?, total = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("siiiiii", $name, $ENG, $MTC, $SCI, $SST, $total, $id);
        if (!$stmt->execute()) {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Function to delete a student from the database
function delete_student($id) {
    global $conn;
    $sql = "DELETE FROM results WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
