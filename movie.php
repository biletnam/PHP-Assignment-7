<?php
  include('dbconnect.php');//passes username and password to PDO object and creates $db variable
  
  $SQL = 'SELECT * from Movie;';
  $movies = $db->query($SQL);//Creates PDO object containing query results to be used in table

  $title = 'Movie Table';
  $message = '';
  include('header.php');
  echo "<h2>$title</h2>";
?>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="theater.php">Theater Table</a></li>
    <li><a href="screen.php">Screen Table</a></li>
    <li><a class="active" href="movie.php">Movie Table</a></li>
    <li><a href="showtime.php">Showtime Table</a></li>
  </ul>

  <div class="container">
    <table>
      <tr>
        <th>Movie ID</th>
        <th>Title</th>
        <th>Genre</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($movies as $movie) { ?>
      <tr>
        <td><?php echo $movie['movieID']; ?></td>
        <td><?php echo $movie['movie_title']; ?></td>
        <td><?php echo $movie['movie_type']; ?></td>
        <td><a href="updateitem.php?table=movie&movieID=<?php echo $movie['movieID'];?>
        &movie_title=<?php echo $movie['movie_title']; ?>&movie_type=<?php echo $movie['movie_type']; ?>">Update</a></td>
        <?php
        /*this block queries the db for references to this item.
          If any are found, the delete button is not displayed and an indication
          is made to the user that this item cannot be deleted.
        */
          $movieID = $movie['movieID'];
          $SQL = "SELECT movieID FROM MovieShowtime
                  WHERE movieID = '$movieID';";
          $canDelete = $db->query($SQL);
          if ($canDelete->rowCount() == 0) { 
        ?>
        <td><a href="deleteitem.php?table=movie&movieID=<?php echo $movie['movieID'];?>
        &movie_title=<?php echo $movie['movie_title']; ?>&movie_type=<?php echo $movie['movie_type']; ?>">Delete</a></td>
        <?php } else { ?>
          <?php $message = '<h4>An item cannot be deleted if it is referenced in another table...</h4>'; ?>
          <td>Cannot Delete</td>
        <?php } ?>
     </tr>
      <?php } ?>
      <?php if (empty($movie['movieID'])) {echo "<tr><td>Empty</td><td>Empty</td><td>Empty</td></tr>";} ?>
    </table>
    <?php if (empty($movie['movieID'])) echo '<h4>No movies to display</h4>'; ?>
    <form action="addform.php" method="get">
      <input type="hidden" name="table" value="movie">
      <input type="submit" value="Add Movie" />
    </form>
    <?php echo $message; ?>
  </div>
<?php
  include('footer.php');
?>