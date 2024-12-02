<?php
// Start the session
session_start();

// Include the database connection
include('includes/db.php');

// Initialize variables
$error_message = '';
$success_message = '';
$name = $phone = $address = $photo = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = __DIR__ . "/uploads/"; // Use absolute path
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Create the uploads directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory with proper permissions
        }

        // Validate the uploaded file
        if (!is_writable($target_dir)) {
            $error_message = "Upload directory is not writable.";
        } elseif (getimagesize($_FILES["photo"]["tmp_name"]) === false) {
            $error_message = "File is not an image.";
        } elseif (file_exists($target_file)) {
            $error_message = "Sorry, file already exists.";
        } elseif ($_FILES["photo"]["size"] > 500000) { // 500KB limit
            $error_message = "Sorry, your file is too large.";
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = "uploads/" . basename($_FILES["photo"]["name"]); // Relative path for storing in DB
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // If no error, save profile data in the database
    if (empty($error_message)) {
        // Insert or update the profile data
        $stmt = $conn->prepare("INSERT INTO profile (name, phone, address, photo) 
                                VALUES (?, ?, ?, ?) 
                                ON DUPLICATE KEY UPDATE name = ?, phone = ?, address = ?, photo = ?");
        $stmt->bind_param("ssssssss", $name, $phone, $address, $photo, $name, $phone, $address, $photo);
        
        if ($stmt->execute()) {
            $success_message = "Profile updated successfully!";
        } else {
            $error_message = "Error updating profile: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Retrieve existing profile data
$stmt = $conn->prepare("SELECT * FROM profile LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc();
    $name = $profile['name'];
    $phone = $profile['phone'];
    $address = $profile['address'];
    $photo = $profile['photo'];
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 30%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        input, textarea {
            margin-bottom: 12px;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            height: 100px;
        }

        button {
            padding: 10px;
            font-size: 1em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 1em;
        }

        .success {
            color: green;
            font-size: 1.2em;
        }

        img {
            margin-top: 10px;
            max-width: 200px;
        }
    </style>
</head>
<body>
<?php include("header.php") ?>
    <div class="container">
        <h2>User Profile</h2>

        <?php
        if ($error_message) {
            echo "<p class='error'>$error_message</p>";
        } elseif ($success_message) {
            echo "<p class='success'>$success_message</p>";
        }
        ?>

        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            
            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($address); ?></textarea>
            
            <label for="photo">Upload Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*">
            
            <button type="submit">Submit</button>
        </form>

        <?php if (!empty($photo)): ?>
            <h3>Profile Picture:</h3>
            <img src="<?php echo htmlspecialchars($photo); ?>" alt="Profile Photo">
        <?php endif; ?>
    </div>
</body>
</html>
