<?php
// Include your database connection file
include('../db_connection.php');

// Handle form submission for adding a new recipe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['recipe_name'];  // Recipe name
    $description = $_POST['description']; // Description
    $serving_size = $_POST['serving_size'];
    $prep_time = $_POST['prep_time'];
    $prep_unit = $_POST['prep_unit'];
    $cook_time = $_POST['cook_time'];
    $cook_unit = $_POST['cook_unit'];
    $category_name = $_POST['category_name']; // Category name
    $user_id = 1;  // Assuming the logged-in user's ID is 1 for now (replace with actual logged-in user ID)

    // Get the ingredients (from the dynamically added input fields)
    $ingredientsArray = [];
    if (isset($_POST['ingredients'])) {
        foreach ($_POST['ingredients'] as $ingredient) {
            // Make sure to trim spaces from the ingredient values
            if (!empty(trim($ingredient))) {
                $ingredientsArray[] = trim($ingredient);
            }
        }
    }
    // Format the ingredients string (comma-separated), set to NULL if empty
    $ingredients = !empty($ingredientsArray) ? '[ ' . implode(' ], [ ', $ingredientsArray) . ' ]' : null;

    // Get the steps (from the dynamically added textarea fields)
    $stepsArray = [];
    if (isset($_POST['steps'])) {
        foreach ($_POST['steps'] as $step) {
            // Make sure to trim spaces from the step values
            if (!empty(trim($step))) {
                $stepsArray[] = trim($step);
            }
        }
    }
    // Format the steps string (comma-separated), set to NULL if empty
    $steps = !empty($stepsArray) ? '[ ' . implode(' ], [ ', $stepsArray) . ' ]' : null;

    // Handle image upload
    $image = null;
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] == 0) {
        $image = '../images/' . basename($_FILES['recipe_image']['name']);
        move_uploaded_file($_FILES['recipe_image']['tmp_name'], $image);
    }

    // Insert the new recipe into the database
    $sql = "INSERT INTO recipes (user_id, name, image, description, category_name, serving_size, prep_time, prep_time_units, cooking_time, cooking_time_units, ingredients, steps)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    echo "Number of expected bind variables: " . $stmt->param_count . "<br>";


    // Bind the parameters
    $stmt->bind_param(
        'issssiisisss',  // Define the types for each parameter
        $user_id, 
        $name, 
        $image, 
        $description, 
        $category_name, 
        $serving_size, 
        $prep_time, 
        $prep_unit, 
        $cook_time, 
        $cook_unit, 
        $ingredients, 
        $steps
    );

    // Execute the statement
    $stmt->execute();

    // Redirect to the "My Recipes" page after adding the recipe
    header('Location: ../My Recipes Page/myrecipes.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Recipe - TasteFolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="edit-recipe-container">
        <header>
            <h1 class="logo">TasteFolio</h1>
            <nav class="nav">
                <a href="../Add A Recipe Page/add.php">Add A New Recipe</a>
                <a href="../My Recipes Page/myrecipes.php">My Recipes</a>
                <a href="../Home Page/home.php">Logout</a>
            </nav>
        </header>
        <main>
            <h2>Add a Recipe</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="recipe_name">Recipe Name:</label>
                <input type="text" id="recipe_name" name="recipe_name" placeholder="Recipe Name" required>

                <label for="recipe_image">Image:</label>
                <input type="file" id="recipe_image" name="recipe_image">

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" placeholder="Recipe Description" required>

                <label for="serving_size">Serving Size:</label>
                <input type="text" id="serving_size" name="serving_size" placeholder="Serving Size" required>

                <label for="prep_time">Prep Time:</label>
                <input type="number" id="prep_time" name="prep_time" placeholder="Prep Time" required>

                <label for="prep_unit">Units:</label>
                <input type="text" id="prep_unit" name="prep_unit" placeholder="Units" required>

                <label for="cook_time">Cooking Time:</label>
                <input type="number" id="cook_time" name="cook_time" placeholder="Cook Time" required>

                <label for="cook_unit">Units:</label>
                <input type="text" id="cook_unit" name="cook_unit" placeholder="Units" required>

                <label for="category_name">Category:</label>
                <select id="category_name" name="category_name" required>
                    <option value="dessert">Dessert</option>
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                </select>

                <h3>Ingredients:</h3>
                <div id="ingredientsList">
                    <div class="ingredient">
                        <input type="text" name="ingredients[]" placeholder="Ingredient Name" required>
                        <button type="button" class="delete-button">X</button>
                    </div>
                </div>
                <button type="button" id="addIngredient">Add Another Ingredient</button>

                <h3>Steps:</h3>
                <div id="stepsList">
                    <div class="step">
                        <textarea rows="3" name="steps[]" placeholder="Step" required></textarea>
                        <button type="button" class="delete-button">X</button>
                    </div>
                </div>
                <button type="button" id="addStep">Add Another Step</button>

                <button type="submit" class="button">Add Recipe</button>
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
