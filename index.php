<?php require("includes/configuration.inc.php"); ?>

<!-- PHP CODE EXECUTED ONCE THE PAGE IS RELOADED -->

<!-- Handling PHP validation, sanitization and insertion inside form page -->

<?php require_once("includes/db-config.local.inc.php"); ?>

<?php

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once("includes/utils/utils.inc.php"); //Includes functions utils
    $errors = []; //Array for errors
    
    //SANITIZATION

    $guestName = filter_var($_POST["guestName"], FILTER_SANITIZE_STRING);
    $guestRating = filter_var($_POST["guestRating"], FILTER_SANITIZE_NUMBER_INT);
    $guestMessage = filter_var($_POST["guestMessage"], FILTER_SANITIZE_STRING);
    
    //VALIDATION

    //Validate Not Empty and Field Size

    if (trim($guestName) == '' || strlen($guestName) > 255) {
       array_push($errors, "ERR: Name must contain a value less than 30 chars");
    }
    
    if ($guestRating < 1 || $guestRating > 5) {
       array_push($errors, "ERR: Rating must be between 1 and 5");
    }

    if (trim($guestMessage) == '' || strlen($guestMessage) > 500) {
      array_push($errors, "ERR: Meal must contain a value less than 30 chars");
    }

    //Check if Errors Array has errors and returns a message with errors
    if(!empty($errors)) {
      $message = "ERR: Server rejected data";

      foreach($errors as $error) {
        $message .= "<br>$error";
      }

      exit($message); //Stop PHP code and return error message
    }

    //When no errors found insert field forms to database
    $mysqli = retrieveConnectionToDB(); //Calls function in includes/db-config.inc.php

    //Prepare insert query
    $sql = "INSERT INTO suites (Guest, Rating, Message) VALUES (?, ?, ?)";
    
    //Send insert query to database
    $stmt = $mysqli->prepare($sql);

    //Bind form fields value types with database types in first parameter "ssssss" s for string 
    $stmt->bind_param("sis", $guestName, $guestRating, $guestMessage);

    //Handle error after executing query
    if(!$stmt->execute()) { //When error is retrieved from database while inserting fields popup a modal message
      $modal = "
        <div class='modal fade' id='successModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLongTitle'>Order save failed!</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                Execute failed: {$stmt->errno}
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
              </div>
            </div>
          </div>
        </div>
      ";

    } else { //When insertion to database is successful popup a modal message

      $modal = "
        <div class='modal fade' id='successModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
          <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLongTitle'>Order saved!</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                Thank you for rating our apartment!
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
              </div>
            </div>
          </div>
        </div>
      ";
    }

    //Close connection to database
    $mysqli->close();
  }

?>

<!-- END OF PHP CODE EXECUTED ONCE THE PAGE IS RELOADED -->

<!-- HTML PAGE FIRST LOAD -->

<!doctype html>
<html lang="en">

<head>

  <!-- Page title -->  
  <title>Luxury Suite</title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css" />

</head>

<body>
            
    <!-- Hero -->
    <div class="custom-container mb-5">
        <h1 class="h4 text-center my-auto py-3 text-danger">Luxury Suite by Jane Doe</h1>
        <div class="jumbotron">
            <div class="text-center text-white">
              <h1 class="display-4">Luxury Suite</h1>
              <p class="lead">An exclusive place to visit and have a great time</p>
              <button type="submit" formaction="#rate" class="btn btn-info align-center" onClick="document.getElementById('rate').scrollIntoView()">Rate Our Apartment</button>
            </div>
        </div>
    </div>
    <!-- End of Hero -->
    
    <!-- The Apartment -->

    <div class="custom-container my-5 apartment">

        <h1 class="mb-5">The Apartment We Understand Luxury</h1>

        <div class="row mb-5">

              <!-- CARD 1 -->

              <div class="col-lg-4 col-md-12">
                <div class="card">
                    <img src="img/home/article1-ralph-kayden.jpg" class="card-img-top" alt="">
                </div>
              </div>

              <!-- CARD 2 -->

              <div class="col-lg-6 col-md-12">
                <div class="card">
                    <p class="card-text lead info">Lorem ipsum dolor sit amet, vestibulum suspendisse dui, metus sed reprehenderit nonummy, 
                      et libero adipiscing aliquet fermentum iaculis quisque, ullamcorper et in erat vestibulum pellentesque ligula, 
                      vestibulum purus. Ad lectus sed id venenatis imperdiet dolor, a volutpat tellus viverra sapien dolor velit, euismod sit, 
                      ligula dui nonummy id sed, litora nullam eget vestibulum lectus eu massa. Sagittis aliquet sagittis, at odio eget ante, 
                      ultricies odio turpis turpis sodales diam, condimentum ut ultricies. Tristique sodales aenean sed, parturient lacinia 
                      faucibus mauris, tellus lorem ridiculus consectetuer proin, eleifend elementum pellentesque mi volutpat libero. 
                      Vestibulum vestibulum mi at nullam, auctor ante a integer, at curabitur et pretium.
                    </p>
                </div>
              </div>

              <!-- CARD 3 -->

              <div class="col-lg-2 col-md-12">
                <div class="card">
                    <img src="img/home/article2-zane-lee.jpg" class="card-img-top" alt="Steak image">
                </div>
              </div>

              <!-- END OF CARDS -->

        </div>

        <!-- END OF ROW -->

    </div>

    <!-- End of Section The Apartment -->

    <!-- Rules -->

    <div class="custom-container rules my-5">

        <h1 class="">Guest Rules</h1>

        <div class="row my-5" id="rules-container">

        <!-- RULES GENERATED BY JAVASCRIPT -->
         
        </div>

        <!-- END OF ROW -->

    </div>

    <!-- End of Rules Section -->
    
    <!-- Rating Form -->

    <div class="custom-container my-1">

      <div class="row">

          <!-- FORM CONTAINER -->

          <div class="col-lg-12 col-md-12 my-5">

              <div class="card">
                    
                    <div class="card-header"  id="rate">
                        <h2>Rate Us</h2>
                    </div>
                    
                    <div class="card-body">
                        
                        <!-- Form  -->
                        <form class="p-2 mb-4 w-100 mx-auto"
                              name="ratingForm" 
                              action="" 
                              onsubmit="" 
                              method="post">
                            
                            <div class="form-row">
                              <div class="col-md-12 mb-3">
                                <label class="pl-1 control-label">Guest name</label>
                                <input class="form-control" type="text" name="guestName" id="guestName" placeholder="e.g. Marcy Johnson" required >
                              </div>
                            </div>

                            <div class="form-row email-info">
                              <div class="col-md-12 mb-3">
                                <input class="form-control text-white" type="text" name="" id="" placeholder="Please do not share your email address here." disabled>
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="col-md-12 mb-3">
                                <select class="form-control custom-select" type="number" name="guestRating" id="guestRating">
                                    <option value="1">Yuck!</option>
                                    <option value="2">Awh</option>
                                    <option value="3">OK</option>
                                    <option value="4">Great</option>
                                    <option value="5" selected>Amazing!!!</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="col-md-12 mb-3">
                                <label class="pl-1 control-label" for="guestMessage">Your message</label>
                                <textarea class="form-control" type="text" name="guestMessage" id="guestMessage" placeholder="Max 500 characters in length" rows="4"></textarea>
                              </div>
                            </div>

                            <button class="btn btn-info w-100" type="submit">
                              <div>Send</div>
                            </button>

                        </form>

                        <!-- End of Form -->

                    </div>

                    <!-- End of Form Card Body -->

              </div>

              <!-- End of Form Card Rating -->

          </div>

          <!-- RATINGS CONTAINER -->

          <div class="col-lg-12 col-md-12">

              <div class="card rating">
                
                  <div class="card-header">
                      <h2>Guest Ratings</h2>
                  </div>
                  
                  <div class="card-body">
                      <h5 class="card-title text-primary pl-1">We share ratings &gt; 3</h5>
                      <hr>
                      
                      <?php 
                        //Calls function in includes/db-config.inc.php
                        $mysqli = retrieveConnectionToDB(); 
                        
                        //Prepare SQL query
                        $sql = "SELECT Rating, Guest, Message FROM suites WHERE Rating > 3";
                        
                        $result = $mysqli->query($sql); //Assign SQL query result to variable
                        $numOfRows = $result->num_rows; //Assign to variable $numberOfRows the rows retrieved from database

                        //Check query result
                        if($numOfRows > 0) { //When query to database has values matching criteria
                            
                            $htmlList = ""; //Declare string variable to add results from data

                            while($row = $result->fetch_assoc()) {
                                $htmlList .= "<p class='list-group-item'>User({$row['Rating']}): {$row['Guest']}, Message: {$row['Message']}</p>";
                            }

                            echo $htmlList;

                        } else { //When query to database retrieves no values

                            echo "There are not ratings yet!";
                        }

                        //Close database connection
                    
                        $mysqli->close();
                  
                      ?>

                  </div>

                  <!-- End of Card Body -->

              </div>

              <!-- End of Card Rating -->

          </div>

          <!--  END OF RATING CONTAINER -->

      </div>

      <!-- END OF ROW -->

    </div>

    <!-- END OF FORM AND RATINGS CONTAINER -->

    <!-- FOOTER -->
    
    <footer class="custom-container my-2 bg-dark">

      <!-- Footer Container -->

      <div class="text-center py-2">
          
          <!-- Copyright -->

          <div class="text-white">
              © Jane Doe - Janedoe, RIT Croatia, 2020
          </div>

          <!-- End of Copyright -->

      </div>

    </footer> 

    <!-- END OF FOOTER -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

     <!-- PHP SCRIPT WHEN POST -->
     <?php 
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            echo $modal;
            echo "<script>$('#successModal').modal('show');</script>"; 
        }
    ?>
    
    <!-- Custom JavaScript -->
    <script src="js/script.js"></script>

</body>
</html>