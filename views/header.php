<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="http://ekveerajoshi-com.stackstaging.com/styles.css">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href="assets/css/toolkit.css" rel="stylesheet">

    <title>My Website</title>
	<style type="text/css">
		label{
		   margin:1px;
		}
		a{
		   margin:2px;
		}
		#welcome{
		   position:relative;
		   top:3px;
		   margin-top:1px;
		}
		textarea{
		   padding:15px;
		   height:20px;
		}

		</style>
  </head>
  <body>
    	<nav class="navbar navbar-expand-lg navbar-light bg-light" style='background-color:#E1E9EE;'>
  <a class="navbar-brand" href="http://ekveerajoshi-com.stackstaging.com/myQuotes.php">MyQuotes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item acthttp://fonts.googleapis.com/css?family=Open+Sans:400,300,600ive">
        <a class="nav-link bolds" href="?page=timeline">Your Timeline <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link bolds" href="?page=tweets">My profile</a>
      </li><li class="nav-item">
        <a class="nav-link bolds" href="?page=profile">Public Profile</a>
      </li>
	  
    </ul>
    <div class="form-inline my-lg-0">
	<?php if (isset($_SESSION['id'])) {
	     echo "<p id='welcome'> Welcome <b>".$_SESSION['username']."</b> !&ensp;&ensp;&ensp;&ensp;</p>"; 
    ?>

        <a class="btn btn-outline-success my-sm-0" href="http://ekveerajoshi-com.stackstaging.com/myQuotes.php?func=logout" id="log">Logout</a>
      
    <?php } else { ?>
	
      <button class="btn btn-outline-success my-sm-0" data-toggle="modal" data-target="#Modal">Login/SignUp</button>
	  
	<?php } ?>
    </div>
  </div>
  
</nav>


