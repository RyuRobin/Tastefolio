<?php
// Include your database connection file
include('../db_connection.php');

// Ensure the recipe_id is provided and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../My Recipes Page/myrecipes.php');
    exit();
}

$recipe_id = $_GET['id'];

// Fetch the recipe data from the database
$sql = "SELECT * FROM recipes WHERE recipe_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if (!$recipe) {
    header('Location: ../My Recipes Page/myrecipes.php');
    exit();
}

// Fetch the ingredients and steps from the database
$ingredients = $recipe['ingredients']; // Example: "[ingredient1], [ingredient2], [ingredient3]"
$steps = $recipe['steps']; // Example: "[step1], [step2], [step3]"

// Prepare the ingredients and steps for easy parsing
$ingredientsArray = explode('], [', trim($ingredients, '[]'));
$stepsArray = explode('], [', trim($steps, '[]'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get updated values from the form
    $recipe_name = $_POST['recipe_name'];
    $serving_size = $_POST['serving_size'];
    $prep_time = $_POST['prep_time'];
    $prep_unit = $_POST['prep_unit'];
    $cook_time = $_POST['cook_time'];
    $cook_unit = $_POST['cook_unit'];

    // Process the ingredients and steps to match the database format
    $updated_ingredients = '[' . implode('], [', $_POST['ingredients']) . ']';
    $updated_steps = '[' . implode('], [', $_POST['steps']) . ']';

    // Prepare the image file (handle file upload)
    $image = null;
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == 0) {
        $image = '../images/' . basename($_FILES['recipe_image']['name']);
        move_uploaded_file($_FILES['recipe_image']['tmp_name'], $image);
    }


    // Update the recipe in the database
    $update_sql = "UPDATE recipes SET name = ?, image = ?, serving_size = ?, prep_time = ?, prep_time_units = ?, cooking_time = ?, cooking_time_units = ?, ingredients = ?, steps = ? WHERE recipe_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('sssssssssi', $recipe_name, $image, $serving_size, $prep_time, $prep_unit, $cook_time, $cook_unit, $updated_ingredients, $updated_steps, $recipe_id);
    $stmt->execute();

    // Redirect to the recipe page after update
    header("Location: ../Recipe Page/recipe.php?id=" . $recipe_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe - TasteFolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="edit-recipe-container">
        <header>
            <h1 class="logo">TasteFolio</h1>
            <nav class="nav">
                <a href="../Add A Recipe Page/add.php">Add A New Recipe</a>
                <a href="../My Recipes Page/myrecipes.php">My Recipes</a>
                <a href="../logout.php">Logout</a>
            </nav>
        </header>
        <main>
            <h2>Editing Recipe</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="recipe_name">Recipe Name:</label>
                <input type="text" id="recipe_name" name="recipe_name" value="<?= htmlspecialchars($recipe['name']) ?>" required>

                <label for="recipe_image">Image:</label>
                <input type="file" id="recipe_image" name="recipe_image" value="<?= htmlspecialchars($recipe['image']) ?>" required>

                <label for="serving_size">Serving Size:</label>
                <input type="text" id="serving_size" name="serving_size" value="<?= htmlspecialchars($recipe['serving_size']) ?>" required>

                <label for="prep_time">Prep Time:</label>
                <input type="number" id="prep_time" name="prep_time" value="<?= htmlspecialchars($recipe['prep_time']) ?>" required>

                <label for="prep_unit">Units:</label>
                <input type="text" id="prep_unit" name="prep_unit" value="<?= htmlspecialchars($recipe['prep_time_units']) ?>" required>

                <label for="cook_time">Cooking Time:</label>
                <input type="number" id="cook_time" name="cook_time" value="<?= htmlspecialchars($recipe['cooking_time']) ?>" required>

                <label for="cook_unit">Units:</label>
                <input type="text" id="cook_unit" name="cook_unit" value="<?= htmlspecialchars($recipe['cooking_time_units']) ?>" required>

                <h3>Ingredients:</h3>
                <div id="ingredientsList">
                    <?php foreach ($ingredientsArray as $ingredient): ?>
                        <div class="ingredient">
                            <input type="text" name="ingredients[]" value="<?= htmlspecialchars($ingredient) ?>" required>
                            <button type="button" class="delete-button">X</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="addIngredient">Add Another Ingredient</button>

                <h3>Steps:</h3>
                <div id="stepsList">
                    <?php foreach ($stepsArray as $step): ?>
                        <div class="step">
                            <textarea rows="3" name="steps[]" required><?= htmlspecialchars($step) ?></textarea>
                            <button type="button" class="delete-button">X</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="addStep">Add Another Step</button>

                <button type="submit" class="button">Update Recipe</button>
            </form>
        </main>
    </div>

    <script>
        // Dynamically add ingredients
        document.getElementById('addIngredient').addEventListener('click', function () {
            const ingredientsList = document.getElementById('ingredientsList');
            const newIngredient = document.createElement('div');
            newIngredient.classList.add('ingredient');
            newIngredient.innerHTML = `
                <input type="text" name="ingredients[]" placeholder="Ingredient Name" required>
                <button type="button" class="delete-button">X</button>
            `;
            ingredientsList.appendChild(newIngredient);

            // Add event listener to delete button
            newIngredient.querySelector('.delete-button').addEventListener('click', function () {
                newIngredient.remove();
            });
        });

        // Dynamically add steps
        document.getElementById('addStep').addEventListener('click', function () {
            const stepsList = document.getElementById('stepsList');
            const newStep = document.createElement('div');
            newStep.classList.add('step');
            newStep.innerHTML = `
                <textarea rows="3" name="steps[]" placeholder="Step" required></textarea>
                <button type="button" class="delete-button">X</button>
            `;
            stepsList.appendChild(newStep);

            // Add event listener to delete button
            newStep.querySelector('.delete-button').addEventListener('click', function () {
                newStep.remove();
            });
        });

        // Delete functionality for existing ingredients and steps
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                const parentElement = button.closest('.ingredient') || button.closest('.step');
                parentElement.remove();
            });
        });
    </script>
</body>
</html>
