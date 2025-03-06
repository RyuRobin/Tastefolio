<?php
// Start the session
session_start();

// Include the database connection
include('../db_connection.php');

// Check if a delete request has been made
if (isset($_GET['delete']) && $_GET['delete'] == 'true') {
    // Get the recipe ID from the URL
    $recipe_id = $_GET['id'];

    // Prepare and execute the DELETE query
    $delete_sql = "DELETE FROM recipes WHERE recipe_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $recipe_id);

    if ($stmt->execute()) {
        // Redirect to the 'My Recipes' page after deletion
        header("Location: ../My Recipes Page/myrecipes.php");
        exit();
    } else {
        // Handle any error during deletion
        echo "Error deleting the recipe: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Get the recipe ID from the URL
$recipe_id = $_GET['id'];

// Query to fetch the recipe data
$sql = "SELECT r.name, r.description, r.serving_size, r.prep_time, r.prep_time_units, r.cooking_time, r.cooking_time_units, r.image, r.ingredients, r.steps, c.category_name 
        FROM recipes r 
        JOIN categories c ON r.category_name = c.category_name
        WHERE r.recipe_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

// Parse the ingredients and steps from the database string format
$ingredients = explode("], [", trim($recipe['ingredients'], "[]"));
$steps = explode("], [", trim($recipe['steps'], "[]"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['name']); ?> - TasteFolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="recipe-container">
        <header>
            <h1 class="logo">TasteFolio</h1>
            <nav class="nav">
                <a href="../Add A Recipe Page/add.php">Add a Recipe</a>
                <a href="../My Recipes Page/myrecipes.php">My Recipes</a>
                <a href="../logout.php">Logout</a>
            </nav>
        </header>
        <main>
            <div class="recipe-header">
                <!-- Recipe Title -->
                <h2><?php echo htmlspecialchars($recipe['name']); ?></h2>
                <!-- Category and Description -->
                <p><?php echo "Category: " . htmlspecialchars($recipe['category_name']) . ". " . htmlspecialchars($recipe['description']); ?></p>
                
                <div class="recipe-info">
                    <!-- Serving, Preparation and Cooking Time -->
                    <span>SERVES: <?php echo htmlspecialchars($recipe['serving_size']); ?> People</span>
                    <span>PREP: <?php echo htmlspecialchars($recipe['prep_time']); ?> <?php echo htmlspecialchars($recipe['prep_time_units']); ?></span>
                    <span>COOK: <?php echo htmlspecialchars($recipe['cooking_time']); ?> <?php echo htmlspecialchars($recipe['cooking_time_units']); ?></span>
                </div>
                
                <!-- Recipe Image -->
                <img src="../images/<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" class="recipe-image">

                <div class="action-buttons">
                    <!-- Edit Button -->
                    <a href="../Edit Recipe Page/edit.php?id=<?php echo $recipe_id; ?>">
                        <img src="../images/editRecipe.png" alt="Edit Recipe" title="Edit Recipe">
                    </a>
                    <!-- Delete Button -->
                    <a href="recipe.php?id=<?php echo $recipe_id; ?>&delete=true" onclick="return confirm('Are you sure you want to delete this recipe?');">
                        <img src="../images/deleteRecipe.png" alt="Delete Recipe" title="Delete Recipe">
                    </a>
                </div>
            </div>

            <!-- Ingredients and Steps -->
            <div class="recipe-details">
                <h3>Ingredients</h3>
                <ul>
                    <?php foreach ($ingredients as $ingredient) : ?>
                        <li><?php echo htmlspecialchars($ingredient); ?></li>
                    <?php endforeach; ?>
                </ul>

                <h3>Instructions</h3>
                <ol>
                    <?php foreach ($steps as $step) : ?>
                        <li><?php echo htmlspecialchars($step); ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </main>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
