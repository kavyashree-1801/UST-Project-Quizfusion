# Quizfusion

A web-based quiz platform supporting multiple question types (MCQ, audio, image-based / Pictionary style), categories (General Knowledge, Technical, Maths & Logic, Audio), admin management, and user/signup flows. Built with PHP, MySQL and vanilla frontend (HTML/CSS/JS).

 ## Demo / Live Link
Live preview:https://github.com/user-attachments/assets/c2610ad1-fdae-4910-84d6-c17c937bc518

Repository:https://github.com/kavyashree-1801/UST-Project-Quizfusion.git

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
| Frontend | HTML, CSS (Bootstrap), JavaScript          |
| Dev/Test | XAMPP / LAMP (local)                       |

## Folder Structure
QuizFusion/
│
├── api/                  # API endpoints for quizzes and platform actions
│   ├── api_audio.php          # Audio-based quiz API
│   ├── api_gk.php             # General Knowledge quiz API
│   ├── api_technical.php      # Technical quiz API
│   ├── api_math_logic.php     # math & logic quiz API
│   ├── api_pictionary.php     # pictionary quiz API
│   ├── check_email.php        # Check if email is registered
│   ├── contact_submit.php     # Handle contact form submissions
│   ├── feedback_submit.php    # Submit user feedback
│   ├── get_security_question.php # Fetch security question for password recovery
│   ├── leaderboards.php       # Fetch leaderboard data
│   ├── login_api.php          # Login API
│   ├── register.php           # User registration API
│   ├── update_profile.php     # Update user profile
│   ├── user_report.php         # Fetch user quiz report
│   ├── verify_answer.php      # Verify quiz answers
│
├── css/                  # Stylesheets
│   ├── about.css
│   ├── audio.css
│   └── categories.css
│   └── contact.css
│   └── forgot_password.css
│   └── gk.css
│   └── homepage.css
│   └── leaderboard.css
│   └── login.css
│   └── math_logic.css
│   └── pictionary.css
│   └── profile.css
│   └── register.css
│   └── technical.css
│   └── user_report.css
│
├── js/                   # JavaScript files
│ ├── audio.js
│ ├── categories.js
│ ├── contact.js
│ ├── feedback.js
│ ├── forgot_password.js
│ ├── homepage.js
│ ├── leaderboard.js
│ ├── math_logic.js
│ ├── pictionary.js
│ ├── profile.js
│ ├── register.js
│ ├── reset_password.js
│ ├── technical.js
│ ├── user_report.js
│ ├── verify_security.js
│
├── uploads/               # audio for the quiz
├── config.php            # Database connection  
├── register.php
├── login.php
├── homepage.php          # Home page
├── about.php
├── contact.php
├── categories.php
├── feedback.php
├── leaderboard.php
├── user_report.php
├── add_question.php
├── categories.php
├── edit_question.php
├── forgot_password.php
├── gk.php
├── logout.php
├── manage_contact.php
├── manage_feedback.php
├── manage_questions.php
├── manage_user.php
├── manage_quiz.php
├── manage_leaderboard.php
├── pictionary.php
├── technical.php
├── audio.php
├── math_logic.php
├── profile.php
├──reset_password.php
├── verify_security.php
└── README.md



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

