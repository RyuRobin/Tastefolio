<?php
session_start();
require '../db_connection.php'; // Ensure this path is correct

// Initialize error message
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username is taken
        $error_message = "Username is taken";
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            // Get the new user's ID
            $user_id = $stmt->insert_id;

            // Start session and log the user in
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            // Redirect to "My Recipes Page"
            header("Location: ../My Recipes Page/myrecipes.php");
            exit();
        } else {
            $error_message = "An error occurred during registration. Please try again.";
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
    <title>Sign Up - TasteFolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="signup-container">
        <header>
            <h1 class="logo">TasteFolio</h1>
            <a href="../../home.php" class="back-link">Go Back</a>
        </header>
        <main>
            <h2>Sign Up</h2>
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <p><?php echo htmlspecialchars($error_message); ?></p>
                </div>
            <?php endif; ?>
            <form action="signup.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="button">Sign Up</button>
            </form>
        </main>
    </div>
</body>
</html>
