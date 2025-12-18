-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 04:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizfusion`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `submitted_on`) VALUES
(1, 'Kavyashreedm', 'kavyashreedmmohan@gmail.com', 'i want info about new quiz', '2025-11-21 05:49:04'),
(4, 'Keerthana Rao', 'keerthana@gmail.com', 'i want information about new quizz', '2025-11-29 07:32:57'),
(5, 'Ritu rajput', 'ritu@yahoo.com', 'i want information about the upcoming quiz!', '2025-11-29 09:05:54'),
(6, 'Gopal Sharma', 'gopal@yahoo.com', 'i want information about other quiz', '2025-11-29 09:44:39');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `comments` text NOT NULL,
  `submitted_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `email`, `rating`, `comments`, `submitted_on`) VALUES
(6, 'gopal@yahoo.com', 5, 'i liked all the categories selected and good selection of questions!!:)', '2025-11-29 09:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `hint` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `audio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `category`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `hint`, `image`, `audio`) VALUES
(1, 1, 'General_knowledge', 'What is the capital of France?', 'Paris', 'London', 'Berlin', 'Madrid', 'Paris', 'It’s known as the “City of Light” and is famous for the Eiffel Tower', '', ''),
(2, 1, '', 'Which planet is known as the Red Planet?', 'Earth', 'Mars', 'Jupiter', 'Venus', 'Mars', 'It is named after the Roman god of war.', NULL, NULL),
(3, 1, '', 'Who wrote \"Romeo and Juliet\"?', 'Shakespeare', 'Charles Dickens', 'Mark Twain', 'Leo Tolstoy', 'Shakespeare', 'He is an English playwright.', NULL, NULL),
(4, 1, '', 'What is the largest mammal?', 'Elephant', 'Blue Whale', 'Giraffe', 'Hippopotamus', 'Blue Whale', 'It lives in the ocean.', NULL, NULL),
(5, 1, '', 'Which country hosted the 2016 Summer Olympics?', 'China', 'Brazil', 'UK', 'Russia', 'Brazil', 'It is famous for Rio de Janeiro.', NULL, NULL),
(6, 1, '', 'What is the boiling point of water in Celsius?', '100', '90', '80', '120', '100', 'It\'s the temperature at which water turns into steam at standard atmospheric pressure.', NULL, NULL),
(7, 1, '', 'Who is known as the Father of Computers?', 'Alan Turing', 'Charles Babbage', 'Bill Gates', 'Steve Jobs', 'Charles Babbage', 'He designed the first mechanical computer.', NULL, NULL),
(8, 1, '', 'Which ocean is the largest?', 'Atlantic', 'Indian', 'Pacific', 'Arctic', 'Pacific', 'It covers more than 30% of the Earth.', NULL, NULL),
(9, 1, '', 'What is the currency of Japan?', 'Yuan', 'Yen', 'Dollar', 'Won', 'Yen', 'It is abbreviated as JPY.', NULL, NULL),
(10, 1, '', 'Which element has the chemical symbol O?', 'Oxygen', 'Gold', 'Iron', 'Hydrogen', 'Oxygen', 'It is essential for breathing.', NULL, NULL),
(11, 1, '', 'Which is the smallest continent by land area?', 'Europe', 'Australia', 'Antarctica', 'South America', 'Australia', 'It is also a country.', NULL, NULL),
(12, 1, '', 'Who painted the Mona Lisa?', 'Van Gogh', 'Michelangelo', 'Leonardo da Vinci', 'Raphael', 'Leonardo da Vinci', 'Famous Italian Renaissance artist.', NULL, NULL),
(13, 1, '', 'In which year did the Titanic sink?', '1912', '1905', '1920', '1915', '1912', 'It hit an iceberg on its maiden voyages.', NULL, NULL),
(14, 1, '', 'Which gas is most abundant in the Earth’s atmosphere?', 'Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Hydrogen', 'Nitrogen', 'It makes up about 78% of air.', NULL, NULL),
(15, 1, '', 'Which planet is closest to the Sun?', 'Venus', 'Mercury', 'Earth', 'Mars', 'Mercury', 'It is the smallest planet in the solar system.', NULL, NULL),
(16, 2, '', 'What does HTML stand for?', 'Hyper Text Markup Language', 'High Text Markup Language', 'Hyperlink Text Mark Language', 'Hyperlinking Text Markup Language', 'Hyper Text Markup Language', 'It is used for creating webpages.', NULL, ''),
(17, 2, '', 'Which language is used for styling web pages?', 'HTML', 'JQuery', 'CSS', 'XML', 'CSS', 'Cascading Style Sheets.', NULL, NULL),
(18, 2, '', 'What is the full form of SQL?', 'Structured Query Language', 'Stylish Question Language', 'Statement Question Language', 'Stylish Query Language', 'Structured Query Language', 'It is used for databases.', NULL, NULL),
(19, 2, '', 'Which of the following is a backend language?', 'Python', 'HTML', 'CSS', 'JavaScript', 'Python', 'It can be used to create server-side applications.', NULL, NULL),
(20, 2, '', 'Which company developed the Java programming language?', 'Microsoft', 'Sun Microsystems', 'Apple', 'IBM', 'Sun Microsystems', 'It was released in 1995.', NULL, NULL),
(21, 2, '', 'What does CSS stand for?', 'Cascading Style Sheets', 'Creative Style Sheets', 'Computer Style Sheets', 'Colorful Style Sheets', 'Cascading Style Sheets', 'Used for design and layout.', NULL, NULL),
(22, 2, '', 'Which of these is a Python framework for web development?', 'Django', 'Laravel', 'React', 'Angular', 'Django', 'Popular Python web framework.', NULL, NULL),
(23, 2, '', 'What is Git used for?', 'Database Management', 'Version Control', 'Graphic Design', 'Web Hosting', 'Version Control', 'It tracks changes in code.', NULL, NULL),
(25, 2, '', 'Which protocol is used to send emails?', 'HTTP', 'SMTP', 'FTP', 'TCP', 'SMTP', 'Simple Mail Transfer Protocol.', NULL, NULL),
(26, 2, '', 'Which language is primarily used for Android app development?', 'Swift', 'Java', 'C#', 'Ruby', 'Java', 'It runs on the Java Virtual Machine.', NULL, NULL),
(27, 2, '', 'Which data structure uses LIFO?', 'Queue', 'Stack', 'Array', 'Linked List', 'Stack', 'Last In First Out.', NULL, NULL),
(28, 2, '', 'Which keyword is used to create a class in Java?', 'function', 'class', 'object', 'define', 'class', 'Used in object-oriented programming.', NULL, NULL),
(29, 2, '', 'Which of the following is a NoSQL database?', 'MySQL', 'MongoDB', 'PostgreSQL', 'Oracle', 'MongoDB', 'Document-based database.', NULL, NULL),
(30, 2, '', 'Which of the following is the correct extension of a Python file?', '.py', '.P', '.pyt', '.pys', '.py', 'Think of the name of the language and its common file extension', NULL, NULL),
(55, 5, '', 'What is 15 + 27?', '42', '40', '43', '41', '42', 'Add the numbers correctly', NULL, NULL),
(56, 5, '', 'If all Bloops are Razzies and all Razzies are Lazzies, are all Bloops definitely Lazzies?', 'Yes', 'No', 'Cannot say', 'Only some', 'Yes', 'Think transitive logic', NULL, NULL),
(57, 5, '', 'If 5x = 20, what is x?', '2', '4', '5', '6', '4', 'Solve for x', NULL, NULL),
(58, 5, '', 'Which number is prime?', '15', '21', '29', '27', '29', 'Prime numbers are divisible only by 1 and themselves', NULL, NULL),
(59, 5, '', 'What is 9 × 6?', '54', '52', '56', '50', '54', 'Multiply 9 by 6', NULL, NULL),
(60, 5, '', 'What is 37 + 48?', '85', '80', '75', '90', '85', 'Add the two numbers correctly', NULL, NULL),
(61, 5, '', 'What comes next: A, C, E, ?', 'G', 'F', 'H', 'I', 'G', 'Alphabet pattern +2', NULL, NULL),
(62, 5, '', 'Simplify: 12 ÷ 4 + 3', '6', '9', '4', '5', '6', 'Do division first', NULL, NULL),
(63, 5, '', 'Find the odd one out: 2, 3, 5, ?, 7', '12', '2', '3', '5', '12', 'Prime logic: all others are prime', NULL, NULL),
(64, 5, '', 'If a=b=2, what is a^b?', '2', '4', '8', '6', '4', 'Exponent: 2 squared', NULL, NULL),
(65, 5, '', 'What is 100 ÷ 25?', '4', '5', '3', '6', '4', 'Divide properly', NULL, NULL),
(66, 5, '', 'If Monday is day 1, what day is 15?', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Tuesday', 'Modulo 7 arithmetic', NULL, NULL),
(67, 5, '', 'Solve: 2(x + 3) = 14', '4', '5', '6', '3', '4', 'First divide both sides by 2 to make the equation simpler. Then solve for x.\r\n', NULL, ''),
(68, 5, '', 'Which is a square number?', '18', '16', '20', '24', '16', '4 squared is 16', NULL, NULL),
(69, 5, '', 'What is half of 150?', '60', '70', '75', '80', '75', 'Divide by 2', NULL, NULL),
(112, 4, '', 'Which sound feels like relaxing background music?', 'Fast beat', 'Relaxing background', 'Alarm', 'Engine', 'Relaxing background', 'Soft peaceful melody', NULL, 'https://orangefreesounds.com/wp-content/uploads/2023/04/Free-relaxing-background-music.mp3'),
(113, 4, '', 'Which audio is good for meditation?', 'Loud music', 'Meditative tune', 'Sirens', 'Gun shot', 'Meditative tune', 'Slow and calming melody', NULL, 'https://orangefreesounds.com/wp-content/uploads/2024/01/Free-meditative-music.mp3'),
(114, 4, '', 'Which is an atmospheric ambient track?', 'Drum solo', 'Atmospheric ambient', 'Pop song', 'Whistle', 'Atmospheric ambient', 'Deep, airy sound', NULL, 'https://orangefreesounds.com/wp-content/uploads/2022/10/Free-atmospheric-background-music.mp3'),
(115, 4, '', 'Which sound is soft and good for sleeping?', 'Car horn', 'Soothing music', 'Calm sleep music', 'Gunshot', 'Calm sleep music', 'Warm synth + stream', NULL, 'https://orangefreesounds.com/wp-content/uploads/2023/01/Calm-music-for-sleep.mp3'),
(116, 4, '', 'Which sound effect is a car horn?', 'Bell', 'Siren', 'Horn', 'Whistle', 'Horn', 'Car horn sound effect', NULL, 'https://www.orangefreesounds.com/wp-content/uploads/2016/10/Horn-sound.mp3'),
(117, 4, '', 'Which is a nature ambience from backyard?', 'Construction', 'Backyard birds + dogs', 'Drum', 'Traffic', 'Backyard birds + dogs', 'Sounds of birds and dogs in backyard', NULL, 'https://orangefreesounds.com/wp-content/uploads/2025/01/Backyard-sounds.mp3'),
(118, 4, '', 'Which is the crow of a little rooster?', 'Dog bark', 'Rooster crow', 'Cat meow', 'Siren', 'Rooster crow', 'Early morning farm rooster', NULL, 'https://orangefreesounds.com/wp-content/uploads/2025/01/Little-rooster-crowing-sound-effect.mp3'),
(119, 4, '', 'Which audio is tropical upbeat instrumental?', 'Heavy metal', 'Tropical instrumental', 'Gunshot', 'Rain sound', 'Tropical instrumental', 'Happy summer melody', NULL, 'https://orangefreesounds.com/wp-content/uploads/2023/06/Tropical-instrumental-music.mp3'),
(128, 4, '', 'Identify this sound: Sparkle Sweep', 'Firework', 'Sparkle Sweep', 'Bell', 'Rain', 'Sparkle Sweep', 'It sounds like a sparkling sweep noise', NULL, 'https://orangefreesounds.com/wp-content/uploads/2024/08/Sparkle-sweep-sound.mp3'),
(130, 4, '', 'This sound is best described as?', 'Firework Crackling', 'Typing', 'Doorbell', 'Rain', 'Firework Crackling', 'It has crackling and explosive sounds', NULL, 'https://orangefreesounds.com/wp-content/uploads/2025/11/Firework-crackling-noise.mp3'),
(136, 2, '', 'What is the smallest unit of data in a computer?', 'KB', 'Byte', 'Nibble', 'bit', 'bit', 'A bit is an abbreviation for a binary digit, which is the most basic unit of information (a 0 or a 1) in computing.\r\n\r\n\r\n\r\n', NULL, NULL),
(138, 3, '', 'Who is this famous fossil hunter?', 'Marie Curie', 'Mary Anning', 'Jane Goodall', 'Rosalind Franklin', 'Mary Anning', 'She contributed immensely to paleontology in the 19th century.', 'https://i.natgeofe.com/n/a8b761f1-01f3-40e2-a4b2-d47ca003ca59/07-jurassic-coast-RXT6F0.jpg', NULL),
(139, 3, '', 'Identify this pioneering biotech entrepreneur from India.', 'Indra Nooyi', 'Kiran Mazumdar-Shaw', 'Vandana Shiva', 'Arundhati Roy', 'Kiran Mazumdar-Shaw', 'She founded Biocon and revolutionized biotech in India.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQUDjieLx0FSPndDMnBpWC9eKAy6ELMFsswA&s', NULL),
(140, 3, '', 'Which monument is shown in the image?', 'Eiffel Tower', 'Leaning Tower of Pisa', 'Big Ben', 'Tower of London', 'Leaning Tower of Pisa', 'Famous for its unintended tilt.', 'https://www.walksofitaly.com/blog/wp-content/uploads/2016/10/Leaning-tower-of-pisa-facts-vertical.jpg', NULL),
(141, 3, '', 'Identify this pink palace in India.', 'Mysore Palace', 'Hawa Mahal', 'Red Fort', 'City Palace Udaipur', 'Hawa Mahal', 'Known as the \"Palace of Winds\".', 'https://static.toiimg.com/img/101335068/Master.jpg', NULL),
(142, 3, '', 'Name this ancient Roman amphitheater.', 'Colosseum', 'Pantheon', 'Parthenon', 'Roman Forum', 'Colosseum', 'It hosted gladiatorial contests in ancient Rome.', 'https://cdn.britannica.com/36/162636-050-932C5D49/Colosseum-Rome-Italy.jpg', NULL),
(143, 3, '', 'Who is considered the world\'s first computer programmer?', 'Grace Hopper', 'Ada Lovelace', 'Katherine Johnson', 'Hedy Lamarr', 'Ada Lovelace', 'She worked with Charles Babbage.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSpR_AGeB976U9YnMxeUb_Or6C40q99rPWIIw&s', NULL),
(145, 3, '', 'Who developed the first effective polio vaccine?', 'Albert Sabin', 'Jonas Salk', 'Louis Pasteur', 'Edward Jenner', 'Jonas Salk', 'American medical researcher.', 'https://achievement.org/wp-content/uploads/2016/02/2-wp-GettyImages-109274461_master-scaled.jpg', NULL),
(146, 3, '', 'Who was the first American woman astronomer?', 'Annie Jump Cannon', 'Caroline Herschel', 'Maria Mitchell', 'Vera Rubin', 'Annie Jump Cannon', 'She classified stars based on their spectra.', 'https://irp.cdn-website.com/f225c1ca/dms3rep/multi/AJumpCannon.jpg', NULL),
(147, 3, '', 'Identify this traditional instrument from Indonesia.', 'Sitar', 'Angklung', 'Guzheng', 'Balalaika', 'Angklung', 'Made entirely of bamboo.', 'https://centerforworldmusic.org/wp-content/uploads/2023/12/Angklung-2.jpg', NULL),
(148, 3, '', 'Name this percussion instrument commonly used in Afro-Cuban music.', 'Bongo', 'Djembe', 'Tabla', 'Cajón', 'Bongo', 'Usually played in pairs.', 'https://indiancultura.com/storage/images/products/folk-musical-instrument-two-piece-natural-wood-bango-drum-set-brown-color/14-Dec-2023/folk-musical-instrument-two-piece-natural-wood-bango-drum-set-brown-color.jpg', NULL),
(149, 3, '', 'Which traditional Chinese instrument is this?', 'Erhu', 'Pipa', 'Shamisen', 'Koto', 'Pipa', 'Has a pear-shaped body with four strings.', 'https://organology.net/wp-content/uploads/2025/03/PipaChina-musical-instruments-img.jpg', NULL),
(150, 3, '', 'Identify this traditional Ethiopian dish.', 'Injera', 'Dosa', 'Roti', 'Chapati', 'Injera', 'Flat, sourdough-risen bread.', 'https://assets.epicurious.com/photos/620a779402c6f8194056c30c/4:3/w_4868,h_3651,c_limit/Injera_RECIPE_021022_27807.jpg', NULL),
(151, 3, '', 'Identify this famous Indian dish.', 'Paneer Butter Masala', 'Butter Chicken', 'Chole Bhature', 'Biryani', 'Butter Chicken', 'A creamy tomato-based chicken curry popular worldwide.', 'https://www.indianhealthyrecipes.com/wp-content/uploads/2023/04/butter-chicken-recipe.jpg', NULL),
(152, 3, '', 'Which country does this flag represent?', 'Malta', 'Switzerland', 'Monaco', 'Liechtenstein', 'Switzerland', 'European country known for neutrality.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/Flag_of_Switzerland_%28Pantone%29.svg/1200px-Flag_of_Switzerland_%28Pantone%29.svg.png', NULL),
(153, 3, '', 'Which country does this flag belong to?', 'Mozambique', 'Malawi', 'Mauritius', 'Madagascar', 'Mozambique', 'This African country’s flag uniquely features an AK-47 rifle.', 'https://img.freepik.com/free-photo/flag-mozambique_1401-178.jpg?semt=ais_hybrid&w=740&q=80', NULL),
(154, 4, '', 'Which of these activities most likely matches this sound?', 'Pouring sand into a glass', 'Scooping seeds out of a bag', 'Shaking a bag of nuts', 'Raking dry leaves on concrete', 'Scooping seeds out of a bag', 'The title mentions “hand scooping seeds … crackle, crackling, eat, food, grain.', NULL, 'https://orangefreesounds.com/wp-content/uploads/2022/10/Seeds-sound-effect.mp3'),
(155, 4, '', 'Which scenario best matches the audio clip you’ll hear?', 'A school bell signaling the end of a class', 'A warning alarm at a construction site', 'A timer bell in a kitchen', 'A doorbell at someone’s house', 'A timer bell in a kitchen', 'This sound is small, clear, and sharp—usually used to grab attention for a brief moment.', NULL, 'https://www.orangefreesounds.com/wp-content/uploads/2022/03/Timer-ding-sound-effect.mp3'),
(156, 4, '', 'Which of these scenes is most likely being described by the audio clip?', 'A city park during a light drizzle', 'Thunder and heavy rain in a dense forest', 'Rain falling on a tin roof of a house', 'Waves crashing on a rocky shoreline', 'Thunder and heavy rain in a dense forest', 'You can hear both pounding rain and low, distant rumbling—no traffic or urban noises.', NULL, 'https://www.orangefreesounds.com/wp-content/uploads/2025/04/Thunderstorm-in-the-forest-sound-effect.mp3'),
(157, 4, '', 'Which of these situations is most likely being portrayed by the audio clip?', 'A firetruck idling in a fire station', 'A train horn echoing through a tunnel', 'An emergency vehicle (police or ambulance) driving past on a city street', 'A helicopter flying low overhead', 'An emergency vehicle (police or ambulance) driving past on a city street', 'The sound has a rising-and-fading siren typical of a vehicle passing by, with urban street background.', NULL, 'https://www.orangefreesounds.com/wp-content/uploads/2016/09/Air-raid-siren.mp3'),
(158, 4, '', 'Which of the following situations does this sound clip most likely represent?', 'A cat asking for food by meowing loudly', 'A kitten quietly purring while sleeping', 'A cat hissing as a warning to another animal', 'A cat softly chirping to its owner', 'A cat asking for food by meowing loudly', 'The meow is very loud and strong — not a gentle purr or whisper', NULL, 'https://orangefreesounds.com/wp-content/uploads/2023/10/Meowing-noise.mp3'),
(159, 4, '', 'Which of the following best describes the style of the track “Electronic Soft Jazz Background Music”?', 'Fast-paced bebop with complex saxophone solos', 'Chill, smooth jazz with a soft electronic bea', 'Big-band swing featuring brass section riffs', 'Traditional acoustic jazz trio with piano, bass, and drums', 'Chill, smooth jazz with a soft electronic bea', 'Think “relaxing,” “lounge-style,” and “electronic elements,” not high-energy or classic swing.', NULL, 'https://orangefreesounds.com/wp-content/uploads/2025/10/Electronic-soft-jazz-background-music.mp3'),
(160, 1, '', 'What is the capital of Australia?', 'Sydney', 'Canberra', 'Melbourne', 'Brisbane', 'Canberra', 'Its a planned city, built specifically to be the capital.', NULL, NULL),
(161, 2, '', 'What does CPU stand for in computer systems?', 'Central Processing Unit', 'Computer Power Unit', 'Core Program Utility', 'Control Performance Unit', 'Central Processing Unit', 'Its often called the brain of the computer system', NULL, NULL),
(162, 1, '', 'Who wrote the Indian national anthem “Jana Gana Mana”?', 'Bankim Chandra Chatterjee', 'Rabindranath Tagore', 'Subhas Chandra Bose', 'Sarojini Naidu', 'Rabindranath Tagore', 'He was a Nobel Prize–winning poet.', NULL, NULL),
(163, 1, '', 'Who is known as the “Father of the Indian Constitution”?', 'Mahatma Gandhi', 'Jawaharlal Nehru', 'B.R.Ambedkar', 'Sardar Vallabhbhai Patel', 'B.R.Ambedkar', 'He was the chairman of the Drafting Committee.', NULL, NULL),
(164, 1, '', 'Which instrument is used to measure earthquakes?', 'Barometer', 'Thermometer', 'Anemometer', 'seismograph', 'seismograph', 'It records seismic waves.', NULL, NULL),
(165, 2, '', 'Which HTTP method is used to send data securely to a server?', 'GET', 'POST', 'DELETE', 'HEAD', 'POST', 'Data is sent in the request body ,not the URL.', NULL, NULL),
(166, 2, '', 'What is the default port number for MySQL?', '80', '443', '3306', '8080', '3306', 'Its a four-digit number starting with 33.', NULL, NULL),
(167, 2, '', 'Which JavaScript keyword is used to declare a constant variable?', 'var', 'let', 'const', 'static', 'const', 'Its value cannot be reassigned.', NULL, NULL),
(168, 2, '', 'What is the purpose of an index in a database?', 'To store backup data', 'To speed up data retrieval', 'To encrypt database tables', 'To reduce database size', 'To speed up data retrieval', 'It improves SELECT query performance.', NULL, NULL),
(169, 5, '', 'A number is increased by 20% and then decreased by 20%. What is the net change?', 'No change', '2% increase', '4%decrease', '20%decrease', '4%decrease', 'Increase and decrease percentages are not reversible.', NULL, NULL),
(170, 5, '', 'What comes next in series?\r\n2,6,12,20,?', '28', '30', '32', '24', '28', 'Look at the pattern of differences(+4,+6,+8,+10).', NULL, NULL),
(171, 5, '', 'If 5 workers can complete a task in 10 days, how many days will 10 workers take to complete the same task?', '2', '5', '10', '20', '5', 'Work is inversely proportional to number of workers.', NULL, NULL),
(172, 5, '', 'A father is 4 times as old as his son. After 10 years, the father will be 2 times as old as his son. What is the son’s present age?', '5 years ', '8 years', '10 years', '12 years', '10 years', 'Form two equations using present and future ages.', NULL, NULL),
(173, 5, '', 'A die is rolled once. What is the probability of getting a number greater than 4?', '1/6', '1/3', '1/2', '2/3', '1/3', 'Favorable outcomes÷ total outcomes.', NULL, NULL),
(174, 3, '', 'Who is the unsung hero shown in this image?', 'Bhagat Singh', 'Birsa Munda', 'Subhash Chandra Bose', 'Chandrashekhar  Azad', 'Birsa Munda', 'A tribal freedom fighter from Jharkhand.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT6vXzUc2LTVYsXtqSmNUB8Dcm0NklXM1X37g&s', NULL),
(175, 3, '', 'Identify the landmark shown in the image', 'Eiffel Tower', 'Big Ben', 'Statue of Liberty', 'Christ the redeemer ', 'Statue of Liberty', 'It was a gift from France.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/Front_view_of_Statue_of_Liberty_%28cropped%29.jpg/960px-Front_view_of_Statue_of_Liberty_%28cropped%29.jpg', NULL),
(176, 3, '', 'Identify the monument shown in the image', 'Machu Pichu', 'Angkor Wat', 'Petra', 'Borobudur', 'Petra', 'It is a rock-cut city in Jordan.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQizpnCPikoMnRA1i4TepUGWTmKMi7U0FzYjg&s', NULL),
(177, 3, '', 'Which country does this flag belong to?', 'Bhutan', 'Sri Lanka', 'Nepal', 'Myanmar', 'Nepal', 'It is only non-rectangular national flag.', 'https://images.bergerpaints.com/s3fs-public/2024-08/Flag-of-Nepal.png?VersionId=Pt2puVGxLqusiTOvRRJx9kH0K_rkUCzo&format=webp&width=3840&quality=75', NULL),
(178, 3, '', 'Which country is famous for this dish?', 'China', 'Thailand', 'South Korea', 'Japan', 'Japan', 'It uses vinegared rice and raw fish.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtTm0Bb-OL1glJygTK2WNELnGBVDKf3-OErg&s', NULL),
(179, 4, '', 'What type of sound is played here?', 'Typing on  a keyboard', 'Water dripping', 'Wind blowing', 'Dog growling', 'Typing on  a keyboard', 'Listen for fast,Mechanical tapping sounds.', NULL, 'uploads/audio/1766060935_Keyboard-typing-sound-effect.mp3'),
(180, 4, '', 'Which sound is this?', 'Footsteps on gravel', 'Train passing', 'Rain hitting window', 'Guitar strum', 'Footsteps on gravel', 'A rhythmic pattern of steps on a rough surface.', NULL, 'uploads/audio/1766061129_Footsteps-on-beach-gravel-sound-effect.mp3'),
(181, 4, '', 'Identify the sound in this clip.', 'Dog barking', 'Bird chirping', 'Clock ticking', 'Keyboard typing', 'Bird chirping', 'You can hear small repetitive melodic sounds outdoors.', NULL, 'uploads/audio/1766061323_Morning-birds-sound-effect.mp3'),
(182, 4, '', 'What is this sound?', 'Air conditioner', 'Apartment generator', 'Elevator moving', 'Washing machine', 'Apartment generator', 'It’s a continuous humming sound, usually heard when electricity is cut off in a building.', NULL, 'uploads/audio/1766061732_Large-electric-generator-sound-effect.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `category`) VALUES
(1, 'General_knowledge'),
(2, 'Technical'),
(3, 'Pictionary'),
(4, 'Audio'),
(5, 'Maths & Logic');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `taken_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `quiz_id`, `email`, `category`, `total_questions`, `score`, `taken_on`) VALUES
(7, 1, 'kavyashreedmmohan@gmail.com', 'General_knowledge', 15, 13, '2025-11-20 18:43:25'),
(10, 2, 'kavyashreedmmohan@gmail.com', 'Technical', 15, 13, '2025-11-20 19:09:16'),
(11, 5, 'kavyashreedmmohan@gmail.com', 'Maths & Logic', 15, 15, '2025-11-20 19:19:12'),
(13, 4, 'kavyashreedmmohan@gmail.com', 'Audio', 10, 9, '2025-11-21 04:16:26'),
(14, 3, 'kavyashreedmmohan@gmail.com', 'Pictionary', 15, 15, '2025-11-21 04:59:22'),
(15, 4, 'Mohan@yahoo.com', 'audio', 10, 10, '2025-11-21 15:48:41'),
(16, 3, 'Mohan@yahoo.com', 'Pictionary', 15, 11, '2025-11-21 15:50:21'),
(17, 1, 'Mohan@yahoo.com', 'General_knowledge', 16, 15, '2025-11-21 15:52:35'),
(18, 2, 'Mohan@yahoo.com', 'Technical', 15, 14, '2025-11-21 15:54:06'),
(19, 5, 'Mohan@yahoo.com', 'Maths & Logic', 15, 14, '2025-11-21 15:56:06'),
(22, 1, 'mahe@gmail.com', 'General_knowledge', 16, 14, '2025-11-21 16:08:56'),
(23, 2, 'mahe@gmail.com', 'Technical', 15, 10, '2025-11-21 16:11:02'),
(27, 4, 'mahe@gmail.com', 'audio', 10, 10, '2025-11-21 17:29:03'),
(28, 3, 'mahe@gmail.com', 'Pictionary', 15, 9, '2025-11-21 17:33:27'),
(29, 5, 'mahe@gmail.com', 'Maths & Logic', 15, 12, '2025-11-21 17:45:16'),
(33, 3, 'nehar@gmail.com', 'Pictionary', 15, 9, '2025-11-23 16:46:53'),
(34, 3, 'abhid@yahoo.com', 'Pictionary', 15, 13, '2025-11-23 17:34:09'),
(35, 3, 'abhid@yahoo.com', 'Pictionary', 15, 13, '2025-11-23 17:38:30'),
(36, 3, 'Neha@yahoo.com', 'Pictionary', 15, 11, '2025-11-25 14:46:20'),
(37, 1, 'Neha@yahoo.com', 'General_knowledge', 15, 11, '2025-11-25 14:47:44'),
(38, 2, 'Neha@yahoo.com', 'Technical', 15, 14, '2025-11-25 14:49:11'),
(39, 5, 'Neha@yahoo.com', 'Maths & Logic', 15, 14, '2025-11-25 14:51:03'),
(40, 4, 'Neha@yahoo.com', 'audio', 15, 14, '2025-11-25 14:52:54'),
(41, 4, 'dinesh@yahoo.com', 'audio', 16, 16, '2025-11-25 15:23:07'),
(42, 3, 'dinesh@yahoo.com', 'Pictionary', 15, 13, '2025-11-25 15:25:19'),
(43, 1, 'dinesh@yahoo.com', 'General_knowledge', 15, 13, '2025-11-25 15:27:02'),
(44, 2, 'dinesh@yahoo.com', 'Technical', 15, 14, '2025-11-25 15:28:17'),
(45, 5, 'dinesh@yahoo.com', 'Maths & Logic', 15, 13, '2025-11-25 15:29:36'),
(48, 3, 'keerthana@gmail.com', 'Pictionary', 15, 11, '2025-11-29 07:25:41'),
(49, 1, 'keerthana@gmail.com', 'General_knowledge', 15, 12, '2025-11-29 07:26:46'),
(50, 2, 'keerthana@gmail.com', 'Technical', 15, 14, '2025-11-29 07:28:29'),
(51, 5, 'keerthana@gmail.com', 'Maths & Logic', 15, 10, '2025-11-29 07:29:51'),
(52, 4, 'keerthana@gmail.com', 'audio', 16, 16, '2025-11-29 07:31:33'),
(53, 1, 'ritu@yahoo.com', 'General_knowledge', 15, 13, '2025-11-29 08:58:26'),
(54, 2, 'ritu@yahoo.com', 'Technical', 15, 14, '2025-11-29 09:00:28'),
(55, 5, 'ritu@yahoo.com', 'Maths & Logic', 15, 10, '2025-11-29 09:01:45'),
(56, 3, 'ritu@yahoo.com', 'Pictionary', 15, 14, '2025-11-29 09:03:45'),
(57, 4, 'ritu@yahoo.com', 'audio', 16, 14, '2025-11-29 09:05:06'),
(58, 1, 'gopal@yahoo.com', 'General_knowledge', 16, 14, '2025-11-29 09:38:42'),
(59, 2, 'gopal@yahoo.com', 'Technical', 15, 15, '2025-11-29 09:39:44'),
(60, 3, 'gopal@yahoo.com', 'Pictionary', 15, 12, '2025-11-29 09:41:31'),
(61, 5, 'gopal@yahoo.com', 'Maths & Logic', 15, 13, '2025-11-29 09:42:47'),
(62, 4, 'gopal@yahoo.com', 'audio', 16, 14, '2025-11-29 09:46:11'),
(63, 1, 'rekha@gmail.com', 'General_knowledge', 16, 12, '2025-12-17 18:03:31'),
(64, 1, 'rekha@gmail.com', 'General_knowledge', 16, 11, '2025-12-17 22:47:49'),
(65, 1, 'rekha@gmail.com', 'General_knowledge', 16, 14, '2025-12-17 22:50:47'),
(66, 1, 'rekha@gmail.com', 'General_knowledge', 16, 13, '2025-12-17 22:56:43'),
(67, 1, 'rekha@gmail.com', 'General_knowledge', 16, 11, '2025-12-17 23:00:35'),
(68, 2, 'rekha@gmail.com', 'Technical', 16, 13, '2025-12-17 23:06:02'),
(69, 2, 'rekha@gmail.com', 'Technical', 16, 13, '2025-12-18 13:09:05'),
(70, 5, 'rekha@gmail.com', 'Maths & Logic', 15, 11, '2025-12-18 13:13:51'),
(71, 5, 'rekha@gmail.com', 'Maths & Logic', 15, 11, '2025-12-18 13:14:43'),
(72, 3, 'rekha@gmail.com', 'Pictionary', 15, 11, '2025-12-18 13:25:13'),
(73, 4, 'rekha@gmail.com', 'Audio', 16, 14, '2025-12-18 14:06:56'),
(74, 4, 'rekha@gmail.com', 'Audio', 16, 10, '2025-12-18 14:15:48'),
(75, 4, 'rekha@gmail.com', 'Audio', 20, 18, '2025-12-18 18:14:54'),
(76, 3, 'rekha@gmail.com', 'Pictionary', 20, 20, '2025-12-18 18:16:37'),
(77, 4, 'rekha@gmail.com', 'Audio', 20, 0, '2025-12-18 18:24:21'),
(78, 4, 'rekha@gmail.com', 'Audio', 20, 0, '2025-12-18 18:25:28'),
(79, 4, 'rekha@gmail.com', 'Audio', 20, 0, '2025-12-18 18:26:46'),
(80, 1, 'rekha@gmail.com', 'General_knowledge', 19, 12, '2025-12-18 18:27:59'),
(81, 1, 'rekha@gmail.com', 'General_knowledge', 19, 11, '2025-12-18 18:34:01'),
(82, 4, 'rekha@gmail.com', 'Audio', 20, 6, '2025-12-18 18:37:30'),
(83, 3, 'rekha@gmail.com', 'Pictionary', 20, 17, '2025-12-18 18:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `remember_token` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `confirm_password`, `security_question`, `security_answer`, `role`, `remember_token`) VALUES
(1, 'Kavyashree D M', 'kavyashreedmmohan@gmail.com', '$2y$10$Lu1h2tyztGq7OhXc7.9TPOEy5pZEG1g1QAzE82A9WqevdkfwKkBuC', '$2y$10$cGRKktgPMICbOy3AYMCYIOtzRoEc6dsagwBou3VRiQFVftEaMD7/u', 'What is your birthplace?', '$2y$10$rj5Q7ch7oowRjrhd.gkrXeZKOcrMtKIOfeU0SPkLkK/gQMm83Ktyy', 'user', NULL),
(2, 'Mahendra', 'mahe@gmail.com', '$2y$10$8mrc0sxOVlAoPJDfG/GiDO.sWPmQUNIzIT4Dn2aPYgyhWQBRA6El2', '$2y$10$8mrc0sxOVlAoPJDfG/GiDO.sWPmQUNIzIT4Dn2aPYgyhWQBRA6El2', 'What is your birthplace?', '$2y$10$XEiqsDWwHMYMrStIDfJaJ.S8OxqDzKuClo2IGrLvIIOLiV1YLGkUu', 'user', NULL),
(3, 'Mohan Rao', 'Mohan@yahoo.com', '$2y$10$xix1dcNwUbK7Z/ZhJAFu7uFuc/jPw7JdlIawLwT9rwQ6g0ZJ0mp92', '$2y$10$xix1dcNwUbK7Z/ZhJAFu7uFuc/jPw7JdlIawLwT9rwQ6g0ZJ0mp92', 'What is your favorite movie?', '$2y$10$lOCD5gbR9f83j3gr9mXV4u0WHqCEqLpo2m97fEh98/TaRsKOAvG9W', 'user', NULL),
(7, 'Neha Rajput', 'nehar@gmail.com', '$2y$10$LsfOGCgevLKn5V5hKI00l.40lnrPotTHR5GUtPtvSwkCR0x8CxXu.', '', 'What is your first pet', '$2y$10$U/KutUaOZZuMpVmc3q92z.Hh5jBkSzAU2aqkfHfA1UY5BN6VI2y1C', 'user', NULL),
(8, 'Abhiram Dixit', 'abhid@yahoo.com', '$2y$10$6jySWCOhMoBHaWh2/B3iAeQtV7QqkNULM1n5.Op788nXoCHebKBI2', '', 'What is your favorite movie?', '$2y$10$yFwfQd4waUzIlYlI1FvKgu0BhgC9dlUHc1jHqbuYDKwWPc77pqOSS', 'user', NULL),
(9, 'Rajesh nayak', 'Rajesh@yahoo.com', '$2y$10$1bJVjCb/qX5E73YJhi35W.ZLco5mflLzMF4fqx6gC5dqTmV5DPNy.', '', 'What is your favorite movie?', '$2y$10$NbcMXO9CDmz5hTOP39unwOOfoJwkWC3d95Nx6lenjDXiPRJUJ6XwS', 'user', NULL),
(10, 'Neha', 'Neha@yahoo.com', '$2y$10$7lTqL2tYlxLXMM6654C23.yfqe00j3hjfPhJLFlEEAhtzqcR/IZbG', '', 'What is your favorite movie?', '$2y$10$1p44HAO6BIq1/ATUVyu2Ue2O7a00mOEV5GWiopOcdKuU9YAAsq1wC', 'user', NULL),
(11, 'Dinesh Rao', 'dinesh@yahoo.com', '$2y$10$AgosjOkRBC84nFwbtil1mu/bSKxLjOcrlQpmizRsjNt2srFvs0WxW', '', 'What is your first pet', '$2y$10$Hau9wS/YruKNK188C/tPw.64F4zVH6y3E/67Ic1BseaXiv9dT0TUO', 'user', NULL),
(13, 'Keerthana Rao', 'keerthana@gmail.com', '$2y$10$Sryie3vVFgKvvBfmXLXJQ.1xlM58s2rWC9FQjjy1zlB2EJxL/YX3W', '', 'What is your favorite movie?', '$2y$10$UbG2d4ev5vDmSx05ioUxB.QnQC2KgvbR.S2C7wMwAk6yIM9d37Zuy', 'user', NULL),
(14, 'Ritu Rajput', 'ritu@yahoo.com', '$2y$10$uV3zZm8PwktVWY50dyK9YOApsvdTkZZDQ1gQTrzjOiAUKvqzWUerW', '', 'What is your birthplace?', '$2y$10$8U10QDH8fIcwpeENZgdEd./ho4LF62ofpavtfznkhDB6bQGIAyj4.', 'user', NULL),
(15, 'Gopal Sharma', 'gopal@yahoo.com', '$2y$10$hV/5ynDSOMNce/05Cq.oo.A8MKeRl3agjS8OVK/PGpPe9X0M5Z7tG', '', 'What is your first pet', '$2y$10$ZjAeuLPv07aiO.4MuR1znOw3RPybDBKwSInU5z.OjdshE9XJyAMB2', 'user', NULL),
(16, 'Rekha', 'rekha@gmail.com', '$2y$10$J46n.G7AbNKsx.xvo5RCuOpwTX3ElwqoML.dHyn362i.EUcCyw3Ku', '', '', '', 'user', NULL),
(17, 'Admin', 'admin@quizfusion.com', '$2y$10$5q8rhS4VOVqrDoe8tJ5kxevWq7quwwUYiO3LmBxDjbizV4ps.1yoO', '', '', '', 'admin', NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
