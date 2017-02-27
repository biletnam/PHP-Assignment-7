<?php
  $dsn = 'mysql:host=localhost';
  $username = 'root';
  $password = '';
  $title = 'Create Database';
  include ('header.php');
  echo '<h1>Create User, Database, and Tables</h1>';
  
  
  try {
      $db = new PDO($dsn, $username, $password);
      echo '<p>You are connected to the database as \'root\'.</p>';
    
      $SQL = "CREATE USER IF NOT EXISTS admin@localhost IDENTIFIED BY 'Pa11word';
            GRANT ALL ON *.* TO admin@localhost IDENTIFIED BY 'Pa11word';";
      $db->exec($SQL);
      $dsn = 'mysql:host=localhost';
      $username = 'admin';
      $password = 'Pa11word';
      $db = new PDO($dsn, $username, $password);
      echo '<p>You are connected to the database as \'admin\'.</p>';
      
      $SQL = 'CREATE DATABASE IF NOT EXISTS entertainment';
      $db->exec($SQL);
      echo '<p>The database entertainment has been created.</p>';
      
      $SQL = 'USE entertainment;';
      $db->exec($SQL);
      
      $SQL = 'CREATE TABLE IF NOT EXISTS Theater (
                theaterID INT(6) PRIMARY KEY AUTO_INCREMENT,
                theater_name VARCHAR(60) NOT NULL,
                theater_location VARCHAR(255) NOT NULL
                );';
      $db->exec($SQL);
      echo '<p>The table Theater has been created.</p>';
      
       $SQL = 'CREATE TABLE IF NOT EXISTS Screen (
                screenID INT(6) PRIMARY KEY AUTO_INCREMENT,
                seat_capacity INT(4) NOT NULL,
                theaterID INT(6) NOT NULL,
              FOREIGN KEY (theaterID) REFERENCES Theater(theaterID)
                );';
      $db->exec($SQL);
      echo '<p>The table Screen has been created.</p>';
      
       $SQL = 'CREATE TABLE IF NOT EXISTS Movie (
                movieID INT(6) PRIMARY KEY AUTO_INCREMENT,
                movie_title VARCHAR(60) NOT NULL,
                movie_type VARCHAR(30) NOT NULL
                );';
      $db->exec($SQL);
      echo '<p>The table Movie has been created.</p>';
      
       $SQL = 'CREATE TABLE IF NOT EXISTS MovieShowtime (
                showID INT(6) PRIMARY KEY AUTO_INCREMENT,
                movieID INT(6) NOT NULL,
                screenID INT(6) NOT NULL,
                show_time DATETIME NOT NULL,
               FOREIGN KEY (movieID) REFERENCES Movie(movieID),
               FOREIGN KEY (screenID) REFERENCES Screen(screenID)
                );';
      $db->exec($SQL);
      echo '<p>The table MovieShowtime has been created.</p>';
 
  } catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>An error occurred while connecting to
             the database: $error_message </p>";
  }
  include('footer.php');
  
?>