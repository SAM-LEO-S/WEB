<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        .welcome {
            text-align: center;
            margin: 20px 0;
        }
        .logout {
            text-align: center;
        }
        .logout a {
            color: #4CAF50;
            text-decoration: none;
        }
        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to your Dashboard</h1>
</header>

<div class="container">
    <div class="welcome">
        <h2>Hello, <?php echo $_SESSION['username']; ?>!</h2>
        <p>Email: <?php echo $_SESSION['email']; ?></p>
    </div>
    
    <div class="logout">
        <p><a href="logout.php">Logout</a></p>
    </div>
</div>

</body>
</html>
