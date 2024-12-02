<?php
require_once 'resultsdb.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Call the delete function
    delete_student($id);

    // Redirect back to the results page after deletion
    header("Location: Dashboard.php");
    exit;
} else {
    die("Invalid request.");
}
?>
