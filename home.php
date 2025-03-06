<?php
// Home Page (Landing Page)

// Redirect user if they are already logged in
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: tastefolio/My Recipes Page/myrecipes.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TasteFolio</title>
    <link rel="stylesheet" href="tastefolio/styles.css">
</head>
<body>
    <div class="landing-container">
        <header>
            <h1 class="logo">TasteFolio</h1>
        </header>
        <main>
            <h2>Welcome to your very own personalized recipe book!</h2>
            <p>Log in or Sign up to get started!</p>
            <div class="button-container">
                <a href="tastefolio/Log In Page/login.php" class="button">Login</a>
                <a href="tastefolio/Sign Up Page/signup.php" class="button">Create an Account</a>
            </div>
        </main>
    </div>
</body>
</html>
