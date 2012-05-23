Installation Instructions
===================

Requirements
-------------
PHP 5.3 (tested 5.3.3, default php.ini)
php-gd
php-pear
php-xsl
php-SimpleXML
php-json
php-Phar

PEAR:
Installed packages, channel pear.php.net:
Package          Version State
Archive_Tar      1.3.7   stable
Console_Getopt   1.2.3   stable
Mail             1.2.0   stable
Mail_Mime        1.8.3   stable
PEAR             1.9.4   stable
Structures_Graph 1.0.4   stable
XML_RPC          1.5.4   stable
XML_Util         1.2.1   stable



Code deployment
-------------

Database configuration
-------------

Install MySQL 5.1, delete the example databases and users using /usr/bin/mysql_secure_installation


Load the SQL database structure from db/scaler.sql using mysqlimport or LOAD DATA INFILE on the mysql client

Create a user 'scaler' with permission to INSERT,DELETE,SELECT and UPDATE to the scaler database on localhost.


Create a file src/php-classes/

<?php
define('DB_HOST','localhost');
define('DB_USERNAME','<password>');
define('DB_PASSWORD','scaler');
?>

Web configuration
------------
