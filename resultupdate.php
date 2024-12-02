<?php 
require_once 'resultsdb.php';

// Fetch student data for the specific ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get student data by ID
    $student = get_student_by_id($id);

    if (!$student) {
        die("Student not found.");
    }
} else {
    die("Invalid request.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $ENG = $_POST["ENG"];
    $MTC = $_POST["MTC"];
    $SCI = $_POST["SCI"];
    $SST = $_POST["SST"];
    $total = $ENG + $MTC + $SCI + $SST;

    update_student($id, $name, $ENG, $MTC, $SCI, $SST, $total);

    header("Location:Dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Marks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">      
</head>
<body>
<?php include("header.php") ?>
    <div class="container">
        <h2 class="mt-5">Update Marks</h2>
        <form method="post" action="">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>ENG</label>
                <input type="number" name="ENG" class="form-control" value="<?php echo $student['ENG']; ?>" required>
            </div>
            <div class="form-group">
                <label>MTC</label>
                <input type="number" name="MTC" class="form-control" value="<?php echo $student['MTC']; ?>" required>
            </div>
            <div class="form-group">
                <label>SCI</label>
                <input type="number" name="SCI" class="form-control" value="<?php echo $student['SCI']; ?>" required>
            </div>
            <div class="form-group">
                <label>SST</label>
                <input type="number" name="SST" class="form-control" value="<?php echo $student['SST']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" style="background-color: #2a2185;">Update</button>
        </form>
    </div>
</body>
</html>
