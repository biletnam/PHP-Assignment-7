<?php
  include('dbconnect.php');//passes username and password to PDO object and creates $db variable
  $title = 'Update Item';
  include('header.php');
?>
  <div class="container">
    <?php /*
    This block handles the data if this page was accessed from the update button.
    It first checks which table is being affected.  
    */ ?>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
      //Check which table to affect
      $table = filter_input(INPUT_GET, 'table'); ?>
      <?php echo "<h2>Update the $table item</h2>"; ?>
      <!-- Start Form -->
      <form action="updateitem.php" method="post">
      <!-- Theater Table -->
      <?php if ($table === 'theater') { 
      //accept and display existing data
        $theaterID = filter_input(INPUT_GET, 'theaterID');
        $theater_name = filter_input(INPUT_GET, 'theater_name');
        $theater_location = filter_input(INPUT_GET, 'theater_location');
      ?>
        Theater Name: <input type="text" name="theater_name" value="<?php echo $theater_name; ?>"><br>
        Location: <input type="text" name="theater_location" value="<?php echo $theater_location; ?>"><br>
        <input type="hidden" name="table" value="theater" /><br>
        <input type="hidden" name="theaterID" value="<?php echo $theaterID; ?>" /><br>
      <?php } //close theater?>
      <!-- Screen Table -->
      <?php if ($table === 'screen') { 
      //accept and display existing data
        $screenID = filter_input(INPUT_GET, 'screenID');
        $seat_capacity = filter_input(INPUT_GET, 'seat_capacity');
        $theaterID = filter_input(INPUT_GET, 'theaterID');
      ?>  
        <?php $SQL = 'SELECT theaterID from Theater;';
              $theaters = $db->query($SQL); ?>
              <?php if ($theaters->rowCount() == 0) {
                echo "<p>There was an error with the referential integrity of the data.</p>";
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
      //accept and display existing data
        $movieID = filter_input(INPUT_GET, 'movieID');
        $movie_title = filter_input(INPUT_GET, 'movie_title');
        $movie_type = filter_input(INPUT_GET, 'movie_type');
      ?>
        Title: <input type="text" name="movie_title" value="<?php echo $movie_title; ?>"><br>
        Genre: <input type="text" name="movie_type" value="<?php echo $movie_type; ?>"><br>
        <input type="hidden" name="table" value="movie" /><br>
        <input type="hidden" name="movieID" value="<?php echo $movieID; ?>" /><br>
      <?php } //close movie?>
      <!-- Movieshowtime Table -->
      <?php if ($table === 'movieshowtime') { 
      //accept and display existing data
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
                echo "<p>There was an error with the referential integrity of the data.</p>";
              } else {//close if ?>
                  DateTime <input type="datetime-local" name="show_time" value="<?php echo $show_time; ?>"/><br>
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
        <input type="submit" value="Update Item" />
      </form>
    <?php } //close method post?>
    <?php /*
    After new data has been passed into the form above,
    the form is submitted and processed below via the post method
    where the appropriate update is made to the table.
    */?>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
      $table = filter_input(INPUT_POST, 'table'); ?>
      <?php if ($table == 'theater') { 
      //begin theater update
        $theaterID = filter_input(INPUT_POST, 'theaterID');
        $theater_name = filter_input(INPUT_POST, 'theater_name');
        $theater_location = filter_input(INPUT_POST, 'theater_location');
        $SQL = "UPDATE Theater
                SET theater_name = '$theater_name',
                    theater_location = '$theater_location'
                WHERE theaterID = '$theaterID';";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error updating the item</h4>';
        } else {
          //redirect to table page if successful
          header('Location: theater.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'screen') { 
      //begin screen update
        $screenID = filter_input(INPUT_POST, 'screenID');
        $seat_capacity = filter_input(INPUT_POST, 'seat_capacity');
        $theaterID = filter_input(INPUT_POST, 'theaterID');
        $SQL = "UPDATE Screen
                SET theaterID = '$theaterID',
                    seat_capacity = '$seat_capacity'
                WHERE screenID = '$screenID';";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error updating the item</h4>';
        } else {
          //redirect to table page if successful
          header('Location: screen.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'movie') { 
      //begin movie update
        $movieID = filter_input(INPUT_POST, 'movieID');
        $movie_title = filter_input(INPUT_POST, 'movie_title');
        $movie_type = filter_input(INPUT_POST, 'movie_type');
        $SQL = "UPDATE Movie
                SET movie_title = '$movie_title',
                    movie_type = '$movie_type'
                WHERE movieID = '$movieID';";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error updating the item</h4>';
        } else {
          //redirect to table page if successful
          header('Location: movie.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'movieshowtime') { 
      //begin movieshowtime update
        $showID = filter_input(INPUT_POST, 'showID');
        $show_time = filter_input(INPUT_POST, 'show_time');
        $movieID = filter_input(INPUT_POST, 'movieID');
        $screenID = filter_input(INPUT_POST, 'screenID');
        $SQL = "UPDATE MovieShowtime
                SET show_time = '$show_time',
                    movieID = '$movieID',
                    screenID = '$screenID'
                WHERE showID = '$showID';";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error updating the item</h4>';
        } else {
          //redirect to table page if successful
          header('Location: showtime.php');
        }
      ?>
      <?php } ?>
    <?php } //close method get?>
  </div>
  


<?php 
  include('footer.php');
?>