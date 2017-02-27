<?php

  $title = 'Main Menu';
  include('header.php');
?>
  <h2>Main Menu</h2>
  <ul>
    <li><a class="active" href="index.php">Home</a></li>
    <li><a href="theater.php">Theater Table</a></li>
    <li><a href="screen.php">Screen Table</a></li>
    <li><a href="movie.php">Movie Table</a></li>
    <li><a href="showtime.php">Showtime Table</a></li>
  </ul>
  <div class="container">
    <img class="mainlogo" src="newcat_pic.png" alt="Blue Cat Picture" height="449" width="508" />
  </div>

<?php
  include('footer.php');
?>