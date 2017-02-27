<?php
  include('dbconnect.php');//passes username and password to PDO object and creates $db variable
  
  $SQL = 'SELECT showID, show_time, Movie.movie_title, Movie.movieID, Screen.screenID, Screen.theaterID
  FROM MovieShowtime
    INNER JOIN Movie
      ON MovieShowtime.movieID = Movie.movieID
    INNER JOIN Screen
      ON MovieShowtime.screenID = Screen.screenID;';
  $showtimes = $db->query($SQL);//Creates PDO object containing query results to be used in table

  $title = 'Showtime Table';
  include('header.php');
  echo "<h2>$title</h2>";
?>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="theater.php">Theater Table</a></li>
    <li><a href="screen.php">Screen Table</a></li>
    <li><a href="movie.php">Movie Table</a></li>
    <li><a class="active" href="showtime.php">Showtime Table</a></li>
  </ul>

  <div class="container">
    <table>
      <tr>
        <th>Show ID</th>
        <th>Showtime</th>
        <th>Movie Title</th>
        <th>Screen Number</th>
        <th>Theater ID</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($showtimes as $showtime) { ?>
      <tr>
        <td><?php echo $showtime['showID']; ?></td>
        <td><?php echo $showtime['show_time']; ?></td>
        <td><?php echo $showtime['movie_title']; ?></td>
        <td><?php echo $showtime['screenID']; ?></td>
        <td><?php echo $showtime['theaterID']; ?></td>
        <td><a href="updateitem.php?table=movieshowtime&showID=<?php echo $showtime['showID']; ?>&show_time=<?php echo $showtime['show_time'];?>
        &screenID=<?php echo $showtime['screenID']; ?>&movieID=<?php echo $showtime['movieID']; ?>">Update</a></td>
        <td><a href="deleteitem.php?table=movieshowtime&showID=<?php echo $showtime['showID']; ?>&show_time=<?php echo $showtime['show_time'];?>
        &screenID=<?php echo $showtime['screenID']; ?>&movieID=<?php echo $showtime['movieID']; ?>">Delete</a></td>
      </tr>
      <?php } ?>
      <?php if (empty($showtime['screenID'])) 
        echo "<tr><td>Empty</td><td>Empty</td><td>Empty</td><td>Empty</td><td>Empty</td></tr>"; ?>
    </table>
    <?php if (empty($showtime['screenID'])) echo '<h4>No showtimes to display</h4>'; ?>
    <form action="addform.php" method="get">
      <input type="hidden" name="table" value="movieshowtime">
      <input type="submit" value="Add Showtime" />
    </form>
  </div>
<?php
  include('footer.php');
?>