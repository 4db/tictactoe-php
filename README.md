# tictactoe-php
PHP, MYSQL, Smarty

### Install
* Composer install.
* Set MySQL config (classes/DB.php) and extract schema.mysql.sql.
* Create folder `templates_c` with permission to create and delete.
* In index.html change host: `var host = 'http://yourhost'`.
* Start index.html.


### Requirements
*Backend: Linux 3.13.0-51, PHP 5.5.9, MySQL 5.5.43. Smarty template 3.x
*Frontend: HTML, CSS, JS, Jquery 1.11.3. Test in chrome.

### Design
* Client side: `index.html` send AJAX request(Jquery) for `server.php`.
* `server.php` backend enter point. Work with Requests and used method classes: `User.php->Game.php`. For View used `Smarty template`. 
* Server side components: `DB.php` - work with db, `ErrorLog.php` - error handler.
