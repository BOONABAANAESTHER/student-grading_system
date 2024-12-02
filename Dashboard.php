<?php 
// session_start();

// // // Check if the user is logged in
// // if (!isset($_SESSION['name'])) {
// //     header("Location: login.php"); // Redirect to login page if not logged in
// //     exit();
// // }

include("includes/db.php");

// // Get count of students
// $studentsQuery = "SELECT COUNT(*) AS total_students FROM students";
// $studentsResult = $conn->query($studentsQuery);
// $studentsCount = $studentsResult->fetch_assoc()['total_students'];

// Get count of results
$resultsQuery = "SELECT COUNT(*) AS total_results FROM results";
$resultsResult = $conn->query($resultsQuery);
$resultsCount = $resultsResult->fetch_assoc()['total_results'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading System</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.1.0/mdb.min.css" rel="stylesheet"/>
</head>

<body>
<?php include("header.php") ?>
    <div class="container">

        <div class="cardBox">
            <!-- <div class="card">
                <div>
                    <div class="numbers">1</div>
                    <div class="cardName">Students</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </div> -->

            <div class="card">
                <div>
                    <div class="numbers"><?php echo $resultsCount; ?></div>
                    <div class="cardName">Results</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="document-text-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">1</div>
                    <div class="cardName">Reports</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="stats-chart-outline"></ion-icon>
                </div>
            </div>
        </div>

        <?php include("results.php"); ?>

        <button type="submit" class="btn btn-primary" style="background-color: #2a2185; margin-left:980px; margin-top:30px">Download</button>
        
    </div>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.1.0/mdb.umd.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
