<?php
session_start();
include 'db_connect.php'; // Include the connection file

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login_secure.php");
    exit();
}

// Fetch user information from the database
$user_id = $_SESSION["user_id"];

// Fetch user details from the database **after** any updates to get the latest bio/username
function fetchUserDetails($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .header {
            background-color:rgb(7, 54, 104);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .header img{
            height: 60px;
            width: 60px;
        }

        .details-card {
            background-color: white;
            padding: 15px;
            margin: 15px;
            height: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .details-card h3 {
            margin: 0;
            position: absolute;
            font-size: 20px;
        }
        .details-card .bi-check-circle-fill{
            font-size: 0.74em;
            color: blue;
        }
        .details-card span{
            float: right;
            padding-top: 4px;
            color: green;
            position: relative;
        }
        .actions{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .actions ul{
           text-align: center;
           max-width: 500px;
           padding: 0;
        }
        .actions ul li{
            display: inline-block;
            height: 70px;
            margin: 14px;
            padding: 17px 8px;
            border-radius: 7px;
            box-shadow: 0px 4px 9px rgba(0, 0, 0, 0.19);
            width: 87px;
        }
        .actions ul li i{
            font-size: 1.25em;
        }
        .actions p{
            padding-top: 0px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>MAAUN Pro</h2>
        <img src="assets/logo.png" alt="">
        <h2>Administrator <i class="bi bi-person-circle"></i></h2>
    </div>

    <div class="details-card">
        <h3><?php echo htmlspecialchars($_SESSION["username"]); ?> <i class="bi bi-check-circle-fill"></i></h3>
        <span>Staff ID: MAAUN/Adm/001</span>
    </div>

    <div class="actions">
        <ul>
            <li><i class="bi bi-plus-circle"></i><p>Add Student</p></li>
            <li><i class="bi bi-person-circle"></i><p>Broadcast Message</p></li>
            <li><i class="bi bi-info-circle"></i><p>Students Details</p></li>
            <li><i class="bi bi-person-circle"></i><p>Delete Record</p></li>
            <li><i class="bi bi-person-circle"></i><p>Edit Assesments</p></li>
            <li><i class="bi bi-arrow-up"></i><p>Publish Results</p></li>

        </ul>
    </div>


</body>
</html>
