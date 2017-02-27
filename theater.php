<?php
  include('dbconnect.php');//passes username and password to PDO object and creates $db variable
  
  $SQL = 'SELECT * from Theater;';
  $theaters = $db->query($SQL);//Creates PDO object containing query results to be used in table
    
  $title = 'Theater Table';
  $message = '';
  include('header.php');
  echo "<h2>$title</h2>";
?>
  
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a class="active" href="theater.php">Theater Table</a></li>
    <li><a href="screen.php">Screen Table</a></li>
    <li><a href="movie.php">Movie Table</a></li>
    <li><a href="showtime.php">Showtime Table</a></li>
  </ul>
  
  <div class="container">
    <table>
      <tr>
        <th>Theater ID</th>
        <th>Name</th>
        <th>Location</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($theaters as $theater) { ?>
      <tr>
        <td><?php echo $theater['theaterID']; ?></td>
        <td><?php echo $theater['theater_name']; ?></td>
        <td><?php echo $theater['theater_location']; ?></td>
        <td><a href="updateitem.php?table=theater&theaterID=<?php echo $theater['theaterID'];?>
        &theater_name=<?php echo $theater['theater_name']; ?>&theater_location=<?php echo $theater['theater_location']; ?>">Update</a></td>
        <?php 
        /*this block queries the db for references to this item.
          If any are found, the delete button is not displayed and an indication
          is made to the user that this item cannot be deleted.
        */
          $theaterID = $theater['theaterID'];
          $SQL = "SELECT theaterID from Screen
                  WHERE theaterID = '$theaterID';";
          $canDelete = $db->query($SQL);
          if ($canDelete->rowCount() == 0) {
        ?>
        <td><a href="deleteitem.php?table=theater&theaterID=<?php echo $theater['theaterID'];?>
        &theater_name=<?php echo $theater['theater_name']; ?>&theater_location=<?php echo $theater['theater_location']; ?>">Delete</a></td>
        <?php } else { ?>
          <?php $message = '<h4>An item cannot be deleted if it is referenced in another table...</h4>'; ?>
          <td>Cannot Delete</td>
        <?php } ?>
      </tr>
      <?php } ?>
      <?php if (empty($theater['theaterID'])) {echo "<tr><td>Empty</td><td>Empty</td><td>Empty</td></tr>";} ?>
    </table>
    <?php if (empty($theater['theaterID'])) echo '<h4>No theaters to display</h4>'; ?>
    <form action="addform.php" method="get">
      <input type="hidden" name="table" value="theater">
      <input type="submit" value="Add Theater" />
    </form>
    <?php echo $message; ?>
  </div>
<?php
  include('footer.php');
?>