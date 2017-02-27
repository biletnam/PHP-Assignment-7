<?php
  $dsn = 'mysql:host=localhost;dbname=entertainment';
  $username = 'admin';
  $password = 'Pa11word';
  $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
   
  try {
    $db = new PDO($dsn, $username, $password, $options);
    $errorMessage = '';
  } catch (PDOException $e) {
    $errorMessage = $e->getMessage();
    echo "<p>An error occurred while connecting to the database: $errorMessage </p>";
  }
?>