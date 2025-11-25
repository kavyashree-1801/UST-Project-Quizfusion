# Quizfusion

A web-based quiz platform supporting multiple question types (MCQ, audio, image-based / Pictionary style), categories (General Knowledge, Technical, Maths & Logic, Audio), admin management, and user/signup flows. Built with PHP, MySQL and vanilla frontend (HTML/CSS/JS).

 ## Demo / Live Link
Repository: ()

## Features
- User signup/login with role-based access
- Admin dashboard for question management
- Supports MCQs, audio questions, image-based questions
- Hints for every question
- Responsive frontend
- SQL import for quick setup

  
 ## Tech Stack
| Layer    | Technology                                 |
| -------- | ------------------------------------------ |
| Backend  | PHP (procedural)                           |
| Database | MySQL / MariaDB                            |
| Frontend | HTML, CSS (Bootstrap optional), JavaScript |
| Dev/Test | XAMPP / LAMP (local)                       |

## Folder Structure
quizfusion/
 ┣ assets/
 ┃  ┣ css/
 ┃  ┣ js/
 ┃  ┗ images/
 ┣ admin/
 ┃  ┣ index.php
 ┃  ┣ manage_questions.php
 ┃  ┗ edit_question.php
 ┣ uploads/
 ┃  ┣ audio/
 ┃  ┗ images/
 ┣ includes/
 ┃  ┣ header.php
 ┃  ┣ footer.php
 ┃  ┗ config.php
 ┣ sql/
 ┃  ┗ quizfusion.sql
 ┣ index.php
 ┣ login.php
 ┣ signup.php
 ┗ README.md

## Installation
1. Clone the repo.
2. Place the project inside your server directory (e.g., htdocs).
3. Create a MySQL database, import the provided SQL.
4. Edit `config.php` with your DB details.
5. Access via browser.

## Testing & Troubleshooting
If you see mysqli_sql_exception: No connection could be made... — check config.php DB credentials and ensure MySQL is running (XAMPP control panel).
Ensure uploads/ directory exists and is writable.
If audio doesn't play, confirm the file is .mp3 and MIME type is correct.

## Future Improvements 
1. Add Difficulty Levels
2. Certificates After Quiz Completion
3. Bookmark / Save Questions
4. Add Explanations for Answers
5. AI-Based Question Generation




## Contact
Project owner / maintainer
Kavyashree D M
📩 Email: kavyashreedmmohan@gmail.com

## ⭐ Support
If you like this project, please ⭐ the repo!

