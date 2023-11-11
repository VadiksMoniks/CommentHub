## About CommentHub

This project realize SPA on Laravel and Vue js which is immitates comments or something like social network
It provides next abilities:

- Creating an account
- Writing comments
- Answer for other users comments
- Downloading images and text files

## Technology stack

- PHP 8.1.7
- node js
- Laravel 10.30.1
- Vue js 3.3.7
- Tailwind CSS
- MySQL

## How to install this project

First of all you need to have localserver on your computer. Open command line go to your working directory in localserver(in XAMPP its 'htdocs') and paste next commands 'git clone https://github.com/VadiksMoniks/CommentHub'.
Then rename file '.env.example' to '.env', open it and set DB_DATABASE=comment_hub.
Then in command line in project's directory use commands 'php artisan migrate', 'php artisan db:seed', 'php artisan key:generate', 'composer install' and 'npm install' - it will load all dependencies and create tables in your database and past come initial data there.
Use command 'npm run dev'. Now you can use this project localy. You have two users: login - test_user, password - 123 and login - real_user, password - 123. If you need you can create other
