-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 16, 2024 at 03:02 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

USE ryuy_tastefolio;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tastefolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(2, 'breakfast'),
(1, 'dessert'),
(4, 'dinner'),
(3, 'lunch');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `serving_size` int DEFAULT NULL,
  `prep_time` int DEFAULT NULL,
  `prep_time_units` varchar(50) DEFAULT NULL,
  `cooking_time` int DEFAULT NULL,
  `cooking_time_units` varchar(50) DEFAULT NULL,
  `ingredients` text,
  `steps` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `user_id`, `name`, `image`, `description`, `category_name`, `serving_size`, `prep_time`, `prep_time_units`, `cooking_time`, `cooking_time_units`, `ingredients`, `steps`) VALUES
(5, 1, 'Tiramisu', '../images/tiramisu.jpg', 'This delicious and unbelievably easy Tiramisu recipe is made with coffee soaked lady fingers, sweet and creamy mascarpone (no raw eggs!), and cocoa powder dusted on top. It requires no baking and can be made in advance!', 'dessert', 9, 10, 'minutes', 4, 'hours', '[ 1 1/2 cups heavy whipping cream ], [ 8 ounce container mascarpone cheese ,room temperature ], [ 1/3 cup granulated sugar ], [ 1 teaspoon vanilla extract ], [ 1 1/2 cups cold espresso ], [ 3 Tablespoons coffee flavored liqueur ,optional (Kahlua or DaVinci brands) ], [ 1 package Lady Fingers ,Savoiardi brand can be found in the cookie aisle at your local grocery store, or online ], [ Cocoa powder for dusting the top ]', '[ Add whipping cream to a mixing bowl and beat on medium speed with electric mixers (or use a stand mixer). Slowly add sugar and vanilla and continue to beat until stiff peaks. Add mascarpone cheese and fold in until combined. Set aside. ], [ Add coffee and liqueur to a shallow bowl. Dip the lady fingers in the coffee (Don\'t soak them--just quickly dip them on both sides to get them wet) and lay them in a single layer on the bottom of an 8x8\'\' or similar size pan. ], [ Smooth half of the mascarpone mixture over the top. Add another layer of dipped lady fingers. Smooth remaining mascarpone cream over the top. ], [ Dust cocoa powder generously over the top (I use a fine mesh strainer to do this). Refrigerate for at least 3-4 hours or up to overnight before serving. ]');
(6, 1, 'Fried Chicken', '../images/chicken.jpg', 'Dust cocoa powder generously over the top (I use a fine mesh strainer to do this). Refrigerate for at least 3-4 hours or up to overnight before serving.', 'lunch', 8, 15, 'minutes', 35, 'minutes', '[ 1 (4 pound) chicken, cut into pieces ], [ 1 cup buttermilk ], [ 2 cups all-purpose flour for coating ], [ 1 teaspoon paprika ], [ salt and pepper to taste ], [ 2 quarts vegetable oil for frying ]', '[ Take your cut up chicken pieces and skin them if you prefer. ], [ Put the flour in a large plastic bag (let the amount of chicken you are cooking dictate the amount of flour you use). Season the flour with paprika, salt and pepper to taste (paprika helps to brown the chicken). ], [ Dip chicken pieces in buttermilk then, a few at a time, put them in the bag with the flour, seal the bag and shake to coat well. ], [ Place the coated chicken on a cookie sheet or tray, and cover with a clean dish towel or waxed paper. LET SIT UNTIL THE FLOUR IS OF A PASTE-LIKE CONSISTENCY. THIS IS CRUCIAL! ], [ Fill a large skillet (cast iron is best) about 1/3 to 1/2 full with vegetable oil. Heat until VERY hot. ], [ Put in as many chicken pieces as the skillet can hold. Brown the chicken in HOT oil on both sides. ], [ When browned, reduce heat and cover skillet; let cook for 30 minutes (the chicken will be cooked through but not crispy). Remove cover, raise heat again, and continue to fry until crispy. ], [ Drain the fried chicken on paper towels. Depending on how much chicken you have, you may have to fry in a few shifts. Keep the finished chicken in a slightly warm oven while preparing the rest. ]');
(7, 1, 'Pancakes', '../images/pancakes.jpg', 'I found this pancake recipe in my Grandma\'s recipe book. Judging from the weathered look of this recipe card, this was a family favorite.', 'breakfast', 8, 5, 'minutes', 15, 'minutes', '[ 1 ½ cups all-purpose flour ], [ 3 ½ teaspoons baking powder ], [ 1 tablespoon white sugar ], [ ¼ teaspoon salt, or more to taste ], [ 1 ¼ cups milk ], [ 3 tablespoons butter, melted ], [ 1 large egg ]', '[ Sift flour, baking powder, sugar, and salt together in a large bowl. Make a well in the center and add milk, melted butter, and egg; mix until smooth. ], [ Heat a lightly oiled griddle or pan over medium-high heat. Pour or scoop the batter onto the griddle, using approximately 1/4 cup for each pancake; cook until bubbles form and the edges are dry, about 2 to 3 minutes. Flip and cook until browned on the other side. Repeat with remaining batter. ]');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'test', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_category` (`category_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_name`) REFERENCES `categories` (`category_name`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
