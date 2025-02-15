<?php
session_start();
include 'db_connect.php'; // Include the connection file

$showNotificationScript = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Vulnerable version using direct SQL query (no SQL injection protection)
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = $conn->query($sql);

    // Check if any rows are returned
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // There is no manual password checking here (pointing bad coding practice).
        // Uncomment the following line if you want to see how it behaves with a password input
     
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: home.php");
            exit();
            
         } else {
             $showNotificationScript = "<script>
                     document.addEventListener('DOMContentLoaded', function() {
                         showNotification('Wrong details, please try again!.', 'error');
                     });
                   </script>";
         }
    }

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Vulnerable Login</title>
</head>
<body>
    <div id="notification" class="notification"></div>
    
    <div class="header">
        <img src="assets/logo.png" alt="MAAUN Logo">
        <h2>MAAUN/21/CBS/0028</h2>
    </div>

    <div class="form-container">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <h2>Vulnerable To SQL Attack!</h2>
        <form action="login_vulnerable.php" method="POST">
            <label for="email">Email: <span> Enter a payload like: <code>' OR 1=1-- </code></span>
        </label>
            <input type="text" name="email" required>

            <label for="password">Password:<span> Enter anything (it will be bypassed)</span></label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
            <p>Note: Using <code>' OR 1=1-- </code> in the email field will bypass authentication by exploiting an SQL injection vulnerability.</p>
        </form>
    </div>

    <script>
    function showNotification(message, type = 'success') {
        var notification = document.getElementById('notification');
        notification.innerHTML = message;
        notification.classList.add('show');
        
        if (type === 'error') {
            notification.classList.add('error');
        } else {
            notification.classList.remove('error');
        }
        
        setTimeout(function() {
            notification.classList.remove('show');
        }, 4000);
    }
    </script>

    <?php echo $showNotificationScript; ?>
</body>
</html>
