<? 
  include("functions.php");
  include("views/header.php");
  if(isset($_GET['page'])){
    if($_GET['page'] == "timeline"){
        include("views/timeline.php");
    }
	else if($_GET['page'] == "tweets"){
        include("views/yourTweets.php");
    }
	else if($_GET['page'] == "search"){
        include("views/search.php");
    }
	else if($_GET['page'] == "profile"){
        include("views/publicProfiles.php");
    }
    }
   else {
         include("views/home.php");
    }
  include("views/footer.php");
?>