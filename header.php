<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include('includes/db.php');

// Fetch the user's profile picture
$profile_image = 'assets/imgs/teacher_essie.jpg'; // Default profile picture
$stmt = $conn->prepare("SELECT photo FROM profile LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc();
    if (!empty($profile['photo'])) {
        $profile_image = htmlspecialchars($profile['photo']); // Use uploaded photo
    }
}
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/header.css"> <!-- External CSS for styling -->
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="Dashboard.php">
                <img src="assets/imgs/kings.svg" alt="Logo">
            </a>
        </div>

        <div class="header-text">
            <h1> Grading System</h1>
        </div>

        <div class="profile">
            <a href="profile.php">
                <img src="<?php echo $profile_image; ?>" alt="User Profile">
            </a>
            <a href="logout.php" class="signout">Sign Out</a>
        </div>
    </header>
</body>

</html>
