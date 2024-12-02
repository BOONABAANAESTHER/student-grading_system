<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="assets/css/forgotpassword.css">
</head>
<body>
  <div class="login-container">
    <h1>Grading System</h1>
    <h2>Reset Password</h2>
    <form>
      <div class="form-group">
        <label for="new-password">New Password</label>
        <input type="password" id="new-password" name="new-password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
      </div>
      <button type="submit" class="login-button">Submit</button>
    </form>
    <a href="<?php 'login.php' ?>" class="back-to-login">Back to Login</a>
  </div>
</body>
</html>
