<?php
session_start();
include('../db_connection.php'); // Assuming your database connection is in this file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Home Page/home.php');
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch recipes from the database based on user ID and selected category
$category = isset($_GET['category']) ? $_GET['category'] : 'all'; // Default to 'all' if no category is selected

// Start the query with a basic condition to filter by user_id
$sql = "SELECT * FROM recipes WHERE user_id = ?";
$params = [$user_id];

// Only add the category filter if the category is valid and exists
if ($category !== 'all' && in_array($category, ['breakfast', 'lunch', 'dinner', 'dessert'])) {
    $sql .= " AND category_name = ?";  // Use 'category_name' instead of 'category'
    $params[] = $category;
}

// Prepare the statement and bind parameters
$stmt = $conn->prepare($sql);

// Check if category filter is used and bind parameters accordingly
if ($category !== 'all' && in_array($category, ['breakfast', 'lunch', 'dinner', 'dessert'])) {
    $stmt->bind_param("ss", $params[0], $params[1]); // Binding for both user_id and category_name
} else {
    $stmt->bind_param("s", $params[0]); // Binding for user_id only
}

$stmt->execute();

// Get the result and fetch the recipes
$result = $stmt->get_result();
$recipes = $result->fetch_all(MYSQLI_ASSOC);

// Close statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Recipes - TasteFolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="recipes-container">
        <header>
            <h1 class="logo">TasteFolio</h1>
            <nav class="nav">
                <a href="../Add A Recipe Page/add.php">Add A New Recipe</a>
                <a href="myrecipes.php">My Recipes</a>
                <a href="../logout.php">Logout</a>
            </nav>
        </header>
        <main>
            <h2>My Recipes</h2>
            <div class="dropdown">
                <button class="dropdown-button">Select Category</button>
                <ul class="dropdown-menu">
                    <li><a href="?category=all">Show All</a></li>
                    <li><a href="?category=breakfast">Breakfast</a></li>
                    <li><a href="?category=lunch">Lunch</a></li>
                    <li><a href="?category=dinner">Dinner</a></li>
                    <li><a href="?category=dessert">Dessert</a></li>
                </ul>
            </div>
            <div class="recipe-grid">
                <?php if (count($recipes) > 0): ?>
                    <?php foreach ($recipes as $recipe): ?>
                        <a href="../Recipe Page/recipe.php?id=<?= $recipe['recipe_id'] ?>" class="recipe-card">
                            <img src="../images/<?= $recipe['image'] ?>" alt="<?= htmlspecialchars($recipe['name']) ?>">
                            <h3><?= htmlspecialchars($recipe['name']) ?></h3>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-recipes-message">
                        No Recipes Yet!
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        const dropdownButton = document.querySelector('.dropdown-button');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        // Toggle dropdown menu
        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.dropdown')) {
                dropdownMenu.classList.remove('show');
            }
        });

        // Update button text based on selection
        dropdownMenu.addEventListener('click', (event) => {
            const category = event.target.dataset.category;
            if (!category) return;

            // Update button text to the selected option
            dropdownButton.textContent = event.target.textContent;

            // Close dropdown
            dropdownMenu.classList.remove('show');
        });
    </script>
</body>
</html>
