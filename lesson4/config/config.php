<?php
define("MYSQL_SERVER","localhost");
define("MYSQL_USER","admin_geek");
define("MYSQL_PASSWORD","12345678");
define("MYSQL_DB","admin_geek");

define("DIR_BIG","uploads/");
define("DIR_SMALL","uploads/mini/");
@mkdir(DIR_BIG, 0777);
@mkdir(DIR_SMALL, 0777);
$cols = 3;
$k = 1;
$message = '';
