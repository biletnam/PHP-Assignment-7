<?php
  include('dbconnect.php');//passes username and password to PDO object and creates $db variable
  $title = 'Add Form';
  $button = true;
  include('header.php');
?>
  <div class="container">
    <?php /*
    This block handles the data if this page was accessed from the add button.
    It first checks which table is being affected.
    */ ?>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
      //Check which table to affect
      $table = filter_input(INPUT_GET, 'table'); ?>
      <?php echo "<h2>Add to the $table table</h2>"; ?>
      <!-- Start Form -->
      <form action="addform.php" method="post">
      <!-- Theater Table -->
      <?php if ($table === 'theater') { ?>
        Theater Name: <input type="text" name="theater_name"><br>
        Location: <input type="text" name="theater_location"><br>
        <input type="hidden" name="table" value="theater" /><br>
      <?php } //close theater?>
      <!-- Screen Table -->
      <?php if ($table === 'screen') { ?>
        <?php $SQL = 'SELECT theaterID from Theater;';//check to ensure Theaters exist
              $theaters = $db->query($SQL); ?>
              <?php if ($theaters->rowCount() == 0) {
                echo "<p>You must add Theaters before you can add screens.</p>";
                $button = false; //to prevent the add button from showing
              } else { //close if?>
                  Seating Capacity: <input type="number" name="seat_capacity"><br>
                  <input type="hidden" name="table" value="screen" /><br>
                  <?php foreach ($theaters as $theater) { ?>
                    Theater: <?php echo $theater['theaterID']; ?>
                    <input type="radio" name="theaterID" value="<?php echo $theater['theaterID']; ?>" /><br>
                    <?php } //close foreach?>      
                <?php } //close screen else?>
      <?php } //close screen?>
      <!-- Movie Table -->
      <?php if ($table === 'movie') { ?>
        Title: <input type="text" name="movie_title"><br>
        Genre: <input type="text" name="movie_type"><br>
        <input type="hidden" name="table" value="movie" /><br>
      <?php } //close movie?>
      <!-- Movieshowtime Table -->
      <?php if ($table === 'movieshowtime') { ?>
        <?php $SQL1 = 'SELECT movieID FROM Movie;'; //checks to ensure both movies and screens exist
              $movies = $db->query($SQL1);
              $SQL2 = 'SELECT screenID FROM Screen;';
              $screens = $db->query($SQL2); ?>
              <?php if (($movies->rowCount() == 0) || ($screens->rowCount() == 0)) {
                echo "<p>You must add a movie and a screen before you can add a showtime.</p>";
                $button = false; //to prevent the add button from showing
              } else {//close if ?>
                  DateTime <input type="datetime-local" name="show_time" /><br>
                  <input type="hidden" name="table" value="movieshowtime" /><br>
                  <h4>Movie</h4>
                  <?php foreach ($movies as $movie) { ?>
                    Movie ID: <?php echo $movie['movieID']; ?>
                    <input type="radio" name="movieID" value="<?php echo $movie['movieID']; ?>" /><br>
                  <?php } //close movie foreach?>
                  <h4>Screen</h4>
                  <?php foreach ($screens as $screen) { ?>
                    Screen ID: <?php echo $screen['screenID']; ?>
                    <input type="radio" name="screenID" value="<?php echo $screen['screenID']; ?>" /><br>
                  <?php } //close screen foreach?>
              <?php } //close else ?>
      <?php } //close movieshowtime?> 
        <?php if ($button) { //if flase, prevents the add button from existing?>
        <input type="submit" value="Add Item" />
        <?php } //close button if?>
      </form>
    <?php } //close method post?>
    <?php/*
    This section of code accepts data from the page itself via the post method.
    It accepts the data entered in the form section above.
    It then carries out the row insertion to the appropriate table.
    */?>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
      $table = filter_input(INPUT_POST, 'table'); ?>
      <?php if ($table == 'theater') { 
      //begin theater insert
        $theater_name = filter_input(INPUT_POST, 'theater_name');
        $theater_location = filter_input(INPUT_POST, 'theater_location');
        $SQL = "INSERT INTO Theater
                (theater_name, theater_location)
                VALUES
                ('$theater_name', '$theater_location');";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error inserting the item</h4>';
        } else {
          //redirect to theater page if successful
          header('Location: theater.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'screen') { 
      //begin screen insert
        $seat_capacity = filter_input(INPUT_POST, 'seat_capacity');
        $theaterID = filter_input(INPUT_POST, 'theaterID');
        $SQL = "INSERT INTO Screen
                (seat_capacity, theaterID)
                VALUES
                ('$seat_capacity', '$theaterID');";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error inserting the item</h4>';
        } else {
          //redirect to screen page if successful
          header('Location: screen.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'movie') { 
      //begin movie insert
        $movie_title = filter_input(INPUT_POST, 'movie_title');
        $movie_type = filter_input(INPUT_POST, 'movie_type');
        $SQL = "INSERT INTO Movie
                (movie_title, movie_type)
                VALUES
                ('$movie_title', '$movie_type');";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error inserting the item</h4>';
        } else {
          //redirect to movie page if successful
          header('Location: movie.php');
        }
      ?>
      <?php } ?>
      <?php if ($table == 'movieshowtime') { 
      //begin movieshowtime insert
        $show_time = filter_input(INPUT_POST, 'show_time');
        $movieID = filter_input(INPUT_POST, 'movieID');
        $screenID = filter_input(INPUT_POST, 'screenID');
        $SQL = "INSERT INTO MovieShowtime
                (movieID, screenID, show_time)
                VALUES
                ('$movieID', '$screenID', '$show_time');";
        $success = $db->exec($SQL);
        if ($success < 1) {
          echo '<h4 class="error">There was an error inserting the item</h4>';
        } else {
          //redirect to movieshowtime page if successful
          header('Location: showtime.php');
        }
      ?>
      <?php } ?>
    <?php } //close method get?>
  </div>
  


<?php 
  include('footer.php');
?>