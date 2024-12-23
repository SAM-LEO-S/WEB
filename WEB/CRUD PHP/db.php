<?php
// db.php - Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "todo_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        // Create operation
        $task = $_POST['task'];
        $stmt = $conn->prepare("INSERT INTO todos (task) VALUES (:task)");
        $stmt->bindParam(':task', $task);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        // Update operation
        $taskId = $_POST['id'];
        $task = $_POST['task'];
        $isCompleted = isset($_POST['is_completed']) ? 1 : 0;
        
        $stmt = $conn->prepare("UPDATE todos SET task = :task, is_completed = :is_completed WHERE id = :id");
        $stmt->bindParam(':task', $task);
        $stmt->bindParam(':is_completed', $isCompleted);
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();
    }
}

if (isset($_GET['delete'])) {
    // Delete operation
    $taskId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->bindParam(':id', $taskId);
    $stmt->execute();
}

// Fetch tasks
$stmt = $conn->prepare("SELECT * FROM todos");
$stmt->execute();
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP To-Do Application</title>
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
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        .task-list {
            list-style-type: none;
            padding: 0;
        }
        .task-list li {
            background-color: #ffffff;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .task-list li a {
            color: #ff6347;
            text-decoration: none;
        }
        .task-list li a:hover {
            text-decoration: underline;
        }
        form {
            background-color: #ffffff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="checkbox"] {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<header>
    <h1>To-Do List Application</h1>
</header>

<div class="container">

    <h2>Add a New Task</h2>
    <form method="POST" action="">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit" name="create">Add Task</button>
    </form>

    <h2>Current To-Do List</h2>
    <ul class="task-list">
        <?php foreach ($tasks as $task): ?>
            <li>
                <?php echo $task['task']; ?> 
                - <?php echo $task['is_completed'] ? "Completed" : "Pending"; ?>
                <a href="?delete=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                <a href="update.php?id=<?php echo $task['id']; ?>">Update</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>
