<?php
//require "login.php";
  $dsn = 'mysql:host=dbserver.engr.scu.edu;dbname=sdb_yli';
  $username = 'username here';   // username is your phpmyadmin username
  $password = 'password here';   // password is your phpmyadmin password
  $options = array(
                   PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                   );

  try {
    $dbh = new PDO($dsn, $username, $password);
    //echo "Connected";
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    
  }
  
?>
