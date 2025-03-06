<?php
session_start();
require '../db_connection.php'; // Ensure this path is correct

// Initialize error message
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query the database for the username
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Username does not exist
        $error_message = "Username does not exist";
    } else {
        $user = $result->fetch_assoc();
        if ($password !== $user['password']) {
            // Password is incorrect
            $error_message = "Password is incorrect";
        } else {
            // Login successful
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to "My Recipes Page"
            header("Location: ../My Recipes Page/myrecipes.php");
            exit();
        }
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - TasteFolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <header>
            <h1 class="logo">TasteFolio</h1>
            <a href="../../home.php" class="back-link">Go Back</a>
        </header>
        <main>
            <h2>Log In</h2>
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <p><?php echo htmlspecialchars($error_message); ?></p>
                </div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="button">Login</button>
            </form>
        </main>
    </div>
</body>
</html>
