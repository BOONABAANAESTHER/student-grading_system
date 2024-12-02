<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <style>
        /* Inline CSS for demonstration */
        .dashboard-container {
            margin: 20px;
        }
    </style>
</head>
<body>
<?php
include("includes/db.php");
// Handle form submission to create user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'create_user') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        $success = "New user created successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Handle user deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete_user') {
    $userId = $_POST['id'];
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']); // Redirect to refresh the page
        exit;
    } else {
        $error = "Error deleting user: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
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
                <img src="assets/imgs/teacher_essie.jpg" alt="User Profile">
            </a>
            <a href="logout.php" class="signout">Sign Out</a>
        </div>
</header>
<div class="container-fluid dashboard-container">
    <main class="mt-4">
        <div class="row g-4">
            <!-- Create User Form -->
            <section id="create-user-form" class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-white" style="background-color: #2a2185;">
                        <h2 class="h5 mb-0">Create New User</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?= $success ?></div>
                        <?php elseif (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <input type="hidden" name="action" value="create_user">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="admin">Admin</option>
                                    <option value="teacher">Teacher</option>
                                </select>
                            </div>
                            <button type="submit" class=" w-100" id="btn">Create User</button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Manage Accounts Section -->
            <section id="manage-accounts" class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-white" style="background-color: #2a2185;">
                        <h2 class="h5 mb-0">Manage Accounts</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['username']); ?></td>
                                            <td><?= htmlspecialchars($row['email']); ?></td>
                                            <td><?= htmlspecialchars($row['role']); ?></td>
                                            <td>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="action" value="delete_user">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No users found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
