<?php
  include('dbconnect.php');//passes username and password to PDO object and creates $db variable
  
  $SQL = 'SELECT screenID, seat_capacity, Screen.theaterID, theater_name
  FROM Screen
    INNER JOIN Theater
    ON Screen.theaterID = Theater.theaterID;';
  $screens = $db->query($SQL);//Creates PDO object containing query results to be used in table

  $title = 'Screen Table';
  $message = '';
  include('header.php');
  echo "<h2>$title</h2>";
?>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="theater.php">Theater Table</a></li>
    <li><a class="active" href="screen.php">Screen Table</a></li>
    <li><a href="movie.php">Movie Table</a></li>
    <li><a href="showtime.php">Showtime Table</a></li>
  </ul>

  <div class="container">
    <table>
      <tr>
        <th>Screen ID</th>
        <th>Seating Capacity</th>
        <th>Theater ID</th>
        <th>Theater Name</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($screens as $screen) { ?>
      <tr>
        <td><?php echo $screen['screenID']; ?></td>
        <td><?php echo $screen['seat_capacity']; ?></td>
        <td><?php echo $screen['theaterID']; ?></td>
        <td><?php echo $screen['theater_name']; ?></td>
        <td><a href="updateitem.php?table=screen&screenID=<?php echo $screen['screenID'];?>
        &seat_capacity=<?php echo $screen['seat_capacity'];?>&theaterID=<?php echo $screen['theaterID']; ?>">Update</a></td>
        <?php 
        /*this block queries the db for references to this item.
          If any are found, the delete button is not displayed and an indication
          is made to the user that this item cannot be deleted.
        */
          $screenID = $screen['screenID'];
          $SQL = "SELECT screenID FROM MovieShowtime
                  WHERE screenID = '$screenID';";
          $canDelete = $db->query($SQL);
          if ($canDelete->rowCount() == 0) {
        ?>
        <td><a href="deleteitem.php?table=screen&screenID=<?php echo $screen['screenID'];?>
        &seat_capacity=<?php echo $screen['seat_capacity'];?>&theaterID=<?php echo $screen['theaterID']; ?>">Delete</a></td>
        <?php } else { ?>
          <?php $message = '<h4>An item cannot be deleted if it is referenced in another table...</h4>'; ?>
          <td>Cannot Delete</td>
        <?php } ?>
        </tr>
      <?php } ?>
      <?php if (empty($screen['screenID'])) 
        echo "<tr><td>Empty</td><td>Empty</td><td>Empty</td><td>Empty</td></tr>"; ?>
    </table>
    <?php if (empty($screen['screenID'])) echo '<h4>No screens to display</h4>'; ?>
    <form action="addform.php" method="get">
      <input type="hidden" name="table" value="screen">
      <input type="submit" value="Add Screen" />
    </form>
    <?php echo $message; ?>
  </div>
  
<?php
  include('footer.php');
?>