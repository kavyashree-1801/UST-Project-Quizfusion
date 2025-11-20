-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2025 at 12:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `veggiedelights`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'italian', 'uploads/categories/1762672163_italian.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `status`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(2, 0, 'Vinay', 'vinay@yahoo.com', 'regarding the notification section', 'i am not able to get the notification', '2025-11-11 16:56:30'),
(3, 0, 'Shyam', 'shyam@gmail.com', 'regarding uploading a recipe', 'i am not able to upload the recipe', '2025-11-11 17:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(2000) NOT NULL,
  `email` varchar(2000) NOT NULL,
  `rating` varchar(2000) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `rating`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'raju', 'raju@gmail.com', '5', 'There are plenty of useful recipes i happy to use this application', 0, '2025-10-29 13:17:42', '2025-10-29 13:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ingredients` text NOT NULL,
  `steps` text NOT NULL,
  `image` longblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_email`, `name`, `ingredients`, `steps`, `image`, `created_at`, `updated_at`) VALUES
(4, 'mahe@gmail.com', 'Babycorn Manchurian', 'Babycorn, Cornflour, All-purpose flour, Salt, Black pepper, Water, Oil, Garlic, Ginger, Green chilies, Onion, Capsicum, Soy sauce, Tomato ketchup, Red chili sauce, Vinegar, Sugar, Spring onions\r\n', '1. Mix cornflour, all-purpose flour, salt, and black pepper in a bowl. Add water gradually to make a smooth batter.\r\n2. Dip babycorn pieces into the batter and deep fry until golden and crispy. Drain on paper towels and set aside.\r\n3. Heat oil in a pan. Add garlic, ginger, and green chilies; sauté for 1-2 minutes.\r\n4. Add chopped onion and capsicum; stir-fry on high flame for 2-3 minutes.\r\n5. Add soy sauce, tomato ketchup, red chili sauce, vinegar, sugar, and salt; mix well.\r\n6. Add water and bring to a boil. Pour in cornflour slurry gradually while stirring to avoid lumps. Cook until sauce thickens.\r\n7. Add fried babycorn and toss gently to coat with the sauce.\r\n8. Garnish with chopped spring onions and serve hot', 0x75706c6f6164732f626162792d636f726e2d6d616e6368757269616e2e6a7067, '2025-11-04 14:39:27', '2025-11-04 14:39:27'),
(5, 'reshmapai@yahoo.com', 'Baingan Bharta', '2 large eggplants (baingan), 2 tbsp oil, 1 tsp cumin seeds, 1 large onion finely chopped, 1 tsp ginger-garlic paste, 2 medium tomatoes chopped, 1-2 green chilies finely chopped, 1/2 tsp turmeric powder, 1 tsp coriander powder, 1/2 tsp cumin powder, 1/2 tsp red chili powder, Salt to taste, 2 tbsp chopped fresh coriander leaves for garnish', '1. Roast the eggplants over an open flame or in the oven until the skin is charred and the flesh is soft. \r\n2. Once cooled, peel the skin, remove the stalk, and mash the pulp. \r\n3. Heat oil in a pan, add cumin seeds, and let them splutter. \r\n4. Add chopped onions and sauté until golden brown. \r\n5. Add ginger-garlic paste and green chilies, sauté for a minute. \r\n6. Add chopped tomatoes, turmeric, coriander, cumin, red chili powder, and salt. Cook until tomatoes turn soft and oil separates. \r\n7. Add mashed eggplant and mix well. Cook for 5–7 minutes on low flame. \r\n8. Garnish with coriander leaves and serve hot with roti, naan, or rice.', 0x75706c6f6164732f313736323236383536335f6261696e67616e2d6268617274612e6a7067, '2025-11-04 15:02:43', '2025-11-04 15:02:43'),
(6, 'Vinay@yahoo.com', 'Tiramisu', 'Mascarpone cheese,eggs,granulated sugar,savoiardi (ladyfinger biscuits),strong espresso or coffee,coffee liqueur,Unsweetened cocoa powder.', '1.Brew and cool the coffee.\r\nPrepare 1 cup of strong coffee or espresso and let it cool. Add liqueur if desired.\r\n\r\n2.Separate the eggs.\r\nPlace egg yolks in one bowl and egg whites in another.\r\n\r\n3.Whisk yolks with sugar.\r\nAdd half the sugar (40g) to the yolks and whisk until thick, pale, and creamy.\r\n\r\n4.Add mascarpone.\r\nMix the mascarpone cheese into the yolk mixture until smooth and creamy.\r\n\r\n5.Beat egg whites.\r\nIn the second bowl, whisk the egg whites with the remaining sugar (40g) until stiff peaks form.\r\n\r\n6.Fold egg whites into mascarpone cream.\r\nGently fold the whipped egg whites into the mascarpone mixture using a spatula.\r\n\r\n7.Dip ladyfingers in coffee.\r\nQuickly dip each ladyfinger into the cooled coffee — about 1–2 seconds per side.\r\n\r\n8.Layer the dessert.\r\nArrange a layer of dipped ladyfingers at the bottom of a dish.\r\n\r\n9.Spread mascarpone cream.\r\nSpread half of the mascarpone mixture evenly over the first layer of biscuits.\r\n\r\n10.Repeat layers.\r\nAdd another layer of dipped ladyfingers and top with the remaining mascarpone cream.\r\n\r\n11.Chill.\r\nCover and refrigerate for at least 4 hours (overnight is best).\r\n\r\n12.Dust with cocoa.\r\nBefore serving, dust the top generously with unsweetened cocoa powder.', 0x75706c6f6164732f313736323836313435355f546972616d6973755f313432362e77656270, '2025-11-11 11:44:15', '2025-11-11 11:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `name` varchar(2000) NOT NULL,
  `email` varchar(2000) NOT NULL,
  `password` varchar(2000) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `security_question` varchar(2000) NOT NULL,
  `security_answer` varchar(2000) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `name`, `email`, `password`, `status`, `created_at`, `updated_at`, `security_question`, `security_answer`, `role`) VALUES
(1, 'Rahul pawar', 'rahul@yahoo.com', '$2y$10$YDOdWIsR5X1GVs0wESZoeeItSreVuzFk7IAPnQBA5Auwcdao1.cpy', 0, '2025-10-31 13:06:47', '2025-10-31 13:20:19', 'What is your favorite ingredient?', '$2y$10$Nv9g7Me0OkihQO/qFo0QC.xFFTovTb5oyzADooYHHN/hQ/4yFB1uK', 'user'),
(2, 'Raju Rao', 'rajur@gmail.com', '$2y$10$zwqIqWOoUOI.UjAHNQ5m/OyW0tCqhwPFAURsj/tyAMonQs4cgrPcO', 0, '2025-10-31 13:21:21', '2025-10-31 13:54:38', 'Who taught you to cook?', '$2y$10$Gc1IHaYTly4ZgjZlwGRBA.UfT0DIcKkT.xnv7Dv05AugITIZNMJ3.', 'user'),
(3, 'Girish Nayak', 'Girish@yahoo.com', '$2y$10$RsovBKKb0fQg1lFexb3Qq./KkdF4yD1Z4j3i88J77.kXBg84o2zBi', 0, '2025-10-31 13:59:49', '2025-11-09 15:47:32', 'What is your favorite ingredient?', '$2y$10$Uwy8bbzGZI55MmrKESBhn.lnycZQHTiXQvMQn4ooc/AcErsmTvXL2', 'user'),
(4, 'Mahendra', 'mahe@gmail.com', '$2y$10$61Z73SJRHYK.Qpa2VGfTNe4eEqbeHeB45K2ZIx5bHDmYdUuJz567y', 0, '2025-11-02 05:37:34', '2025-11-09 15:47:42', 'What is your favorite recipe?', 'aloo gobi', 'user'),
(5, 'Reshma pai', 'reshmapai@yahoo.com', '$2y$10$/43Rr3IBISsHh1JdW7CT4.GKw/0Ks86942xkqH6h7kv9x8w42esh2', 0, '2025-11-04 11:02:50', '2025-11-09 15:47:52', 'What is your favorite recipe?', '$2y$10$GiJP5z9hKY3GL/ilG0MjSOyCpSNKZEKMH2QraJwAXlKFggo1ohM.S', 'user'),
(6, 'Vinaykumar', 'vinay@yahoo.com', '$2y$10$XLIsaijOXSpdMo8SvTqLQ.NSMgqwuKQVyjAHskCKAY5J8C8PFDtn6', 0, '2025-11-09 10:01:36', '2025-11-11 11:45:19', 'What is your favorite ingredient?', 'jeera', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
