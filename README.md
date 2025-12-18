# Quizfusion

A web-based quiz platform supporting multiple question types (MCQ, audio, image-based / Pictionary style), categories (General Knowledge, Technical, Maths & Logic, Audio), admin management, and user/signup flows. Built with PHP, MySQL and vanilla frontend (HTML/CSS/JS).

 ## Demo / Live Link
Live preview:https://github.com/user-attachments/assets/820039c8-5ab8-48f4-bcce-5f45dafaafc6

Repository:https://github.com/kavyashree-1801/UST-Project-Quizfusion.git](https://github.com/kavyashree-1801/UST-Project-Quizfusion.git

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
1.AI-based question recommendations
2. Mobile app support
3.Multiplayer quiz battles
4.Video-based questions
5.Certifications
6.Push notifications





## Contact
Project owner / maintainer
Kavyashree D M

📩 Email: kavyashreedmmohan@gmail.com

## ⭐ Support
If you like this project, please ⭐ the repo!

