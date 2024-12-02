<?php 
require_once 'resultsdb.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $ENG = $_POST["ENG"];
    $MTC = $_POST["MTC"];
    $SCI = $_POST["SCI"];
    $SST = $_POST["SST"];

    $total = $ENG + $MTC + $SCI + $SST;
    

    add_student($name, $ENG, $MTC, $SCI, $SST, $total);

    header("Location: Dashboard.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Marks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">      
    <link rel="stylesheet" href="assets/css/result.css">  
</head>
<body>
<?php include("header.php") ?>
    <div class="container">
        <h2 class="mt-5">Add Marks</h2>
        <form method="post" action="">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>ENG</label>
                <input type="number" name="ENG" class="form-control" required>
            </div>
            <div class="form-group">
                <label>MTC</label>
                <input type="number" name="MTC" class="form-control" required>
            </div>
            <div class="form-group">
                <label>SCI</label>
                <input type="number" name="SCI" class="form-control" required>
            </div>
            <div class="form-group">
                <label>SST</label>
                <input type="number" name="SST" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</body>
</html>
