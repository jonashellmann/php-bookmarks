# PHP Bookmarks

This is a PHP-based application you can install on your own server.
It is created for saving bookmarks not in the browser but on your server so you can save and access them from any browser you want.

For an easier usage there will be a browser plugin in the future.

## Installation

1. Clone the repository in a folder of your choice. You must be able to reach this directory via the web.
2. Log in to your DBMS and create a new user and database the application can use.
3. Grant all priviliges for the database to the user.
4. Add a new user in the table 'users'. Encrypt your password with bcrypt (https://www.dailycred.com/article/bcrypt-calculator).
5. Look in the file 'database.php' and fill in the fields (step 2).
6. Open the website which points to the directory where PHP Bookmarks is installed and log in with username and password (step 4).
