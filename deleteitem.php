<?php
  include('dbconnect.php');//passes username and password to PDO object and creates $db variable
  $title = 'Update Item';
  include('header.php');
?>
  <div class="container">
    <?php /*
    This block handles the data if this page was accessed from the delete button.
    It first checks which table is being affected.  It displays the data of 
    the selected item for deletion and presents a button to confirm.
    */ ?>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
      //Check which table to affect
      $table = filter_input(INPUT_GET, 'table'); ?>
      <?php echo "<h2>Confirm delete from $table table</h2>"; ?>
      <!-- Start Form -->
      <form action="deleteitem.php" method="post">
      <!-- Theater Table -->
      <?php if ($table === 'theater') { 
      //accepts and presents data
        $theaterID = filter_input(INPUT_GET, 'theaterID');
        $theater_name = filter_input(INPUT_GET, 'theater_name');
        $theater_location = filter_input(INPUT_GET, 'theater_location');
      ?>
        Theater Name: <input type="text" name="theater_name" value="<?php echo $theater_name; ?>"><br>
        Location: <input type="text" name="theater_location" value="<?php echo $theater_location; ?>"><br>
        <input type="hidden" name="table" value="theater" /><br>
        <input type="hidden" name="theaterID" value="<?php echo $theaterID; ?>" /><br>
      <?php } //close theater?>
      <!-- screen table -->
      <?php if ($table === 'screen') { 
      //accepts and presents data
        $screenID = filter_input(INPUT_GET, 'screenID');
        $seat_capacity = filter_input(INPUT_GET, 'seat_capacity');
        $theaterID = filter_input(INPUT_GET, 'theaterID');
      ?>  
        <?php $SQL = 'SELECT theaterID from Theater;';
              $theaters = $db->query($SQL); ?>
              <?php if ($theaters->rowCount() == 0) {
                echo "<p>Data reference error....</p>";
              } else { //close if?>
                  Seating Capacity: <input type="number" name="seat_capacity" value="<?php echo $seat_capacity; ?>"><br>
                  <input type="hidden" name="table" value="screen" /><br>
                  <input type="hidden" name="screenID" value="<?php echo $screenID; ?>" /><br>
                  <?php foreach ($theaters as $theater) { ?>
                    Theater: <?php echo $theater['theaterID']; ?>
                    <input type="radio" name="theaterID" value="<?php echo $theater['theaterID']; ?>"
                    <?php if ($theater['theaterID'] == $theaterID) echo 'checked';?> /><br>
                    <?php } //close foreach?>      
                <?php } //close screen else?>
      <?php } //close screen?>
      <!-- Movie Table -->
      <?php if ($table === 'movie') { 
      //accepts and presents data
        $movieID = filter_input(INPUT_GET, 'movieID');
        $movie_title = filter_input(INPUT_GET, 'movie_title');
        $movie_type = filter_input(INPUT_GET, 'movie_type');
      ?>
        Title: <input type="text" name="movie_title" value="<?php echo $movie_title; ?>"><br>
        Genre: <input type="text" name="movie_type" value="<?php echo $movie_type; ?>"><br>
        <input type="hidden" name="table" value="movie" /><br>
        <input type="hidden" name="movieID" value="<?php echo $movieID; ?>" /><br>
      <?php } //close movie?>
      <!-- movieshowtime table -->
      <?php if ($table === 'movieshowtime') { 
      //accepts and presents data
        $showID = filter_input(INPUT_GET, 'showID');
        $movieID = filter_input(INPUT_GET, 'movieID');
        $screenID = filter_input(INPUT_GET, 'screenID');
        $show_time = filter_input(INPUT_GET, 'show_time');
      ?>
        <?php $SQL1 = 'SELECT movieID FROM Movie;';
              $movies = $db->query($SQL1);
              $SQL2 = 'SELECT screenID FROM Screen;';
              $screens = $db->query($SQL2); ?>
              <?php if (($movies->rowCount() == 0) || ($screens->rowCount() == 0)) {
                echo "<p>data reference error.</p>";
              } else {//close if ?>
                  DateTime <input type="text" name="show_time" value="<?php echo $show_time; ?>"/><br>
                  <input type="hidden" name="table" value="movieshowtime" /><br>
                  <input type="hidden" name="showID" value="<?php echo $showID; ?>" />
                  <h4>Movie</h4>
                  <?php foreach ($movies as $movie) { ?>
                    Movie ID: <?php echo $movie['movieID']; ?>
                    <input type="radio" name="movieID" value="<?php echo $movie['movieID']; ?>" 
                    <?php if ($movieID == $movie['movieID']) echo 'checked'; ?>/><br>
                  <?php } //close movie foreach?>
                  <h4>Screen</h4>
                  <?php foreach ($screens as $screen) { ?>
                    Screen ID: <?php echo $screen['screenID']; ?>
                    <input type="radio" name="screenID" value="<?php echo $screen['screenID']; ?>" 
                    <?php if ($screenID == $screen['screenID']) echo 'checked'; ?>/><br>
                  <?php } //close screen foreach?>
              <?php } //close else ?>
      <?php } //close movieshowtime?> 
        <input type="submit" value="Delete Item" />
      </form>
    <?php } //close method post?>
    <?php /*
    After data has been confirmed in the form above,
    the form is submitted and processed below via the post method
    where the appropriate deletion is made from the table.
    */?>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
      $table = filter_input(INPUT_POST, 'table'); ?>
      <?php if ($table == 'theater') { 
      //begin theater deletion
        $theaterID = filter_input(INPUT_POST, 'theaterID');
        $SQL = "DELETE FROM Theater
                WHERE theaterID = '$theaterID';";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error deleting the item</h4>';
        } else {
          //redirect to table if successful
          header('Location: theater.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'screen') { 
      //begin screen deletion
        $screenID = filter_input(INPUT_POST, 'screenID');
        $SQL = "DELETE FROM Screen
                WHERE screenID = '$screenID';";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error deleting the item</h4>';
        } else {
          //redirect to table if successful
          header('Location: screen.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'movie') { 
      //begin movie deletion
        $movieID = filter_input(INPUT_POST, 'movieID');
        $SQL = "DELETE FROM Movie
                WHERE movieID = '$movieID';";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error deleting the item</h4>';
        } else {
          //redirect to table if successful
          header('Location: movie.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'movieshowtime') { 
      //begin movieshowtime deeletion
        $showID = filter_input(INPUT_POST, 'showID');
        $SQL = "DELETE FROM MovieShowtime
                WHERE showID = '$showID';";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error deleting the item</h4>';
        } else {
          //redirect to table if successful
          header('Location: showtime.php');
        }
      ?>
      <?php } ?>
    <?php } //close method get?>
  </div>
  


<?php 
  include('footer.php');
?>