
<?php
include 'db_connect.php'; // Include the connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    // $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Secure password hashing

    // Prepare and execute the SQL query using prepared statements
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Success notification
        echo "<script>showNotification('Registration successful!', 'success');</script>";
    } else {
        // Error notification
        echo "<script>showNotification('Error: " . $conn->error . "', 'error');</script>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Register</title>
    <link rel="shortout icon" href="assets/logo.png" type="image/x-icon" />
</head>
<body>
    <div id="notification" class="notification"></div> <!-- Notification container -->
    <div class="header">
        <img src="assets/logo.png">
        <h2>MAAUN/21/CBS/0028</h2>
    </div>
    <div class="form-container">
        <h2 style="color:#000">Register</h2>
        <form method="POST" action="register.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login_secure.php">Log in here</a></p>
    </div>

    <!-- Notification system script -->
    <script>
    function showNotification(message, type = 'success') {
        var notification = document.getElementById('notification');
        
        // Set the message and the notification type
        notification.innerHTML = message;
        notification.classList.add('show');
        
        // Apply error styling if type is 'error'
        if (type === 'error') {
            notification.classList.add('error');
        } else {
            notification.classList.remove('error');
        }
        
        // Hide the notification after 4 seconds
        setTimeout(function() {
            notification.classList.remove('show');
        }, 4000);
    }
    </script>
</body>
</html>
