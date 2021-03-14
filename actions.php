<?php
	
	include("functions.php");
if(isset($_GET['action'])){
     if ($_GET['action'] == "logSign") {
	        
		$error = "";
        
        if (!$_POST['email']) {
            
            $error = "An email address is required.";
            
        } 
		else if (!$_POST['password']) {
            
            $error = "A password is required";
            
        }
		
		
		if ($error != "") {
            
            echo $error;
            exit();
		
		}
		
        
        
        if ($_POST['loginActive'] == "0") {
            
            $query = "SELECT * FROM users WHERE email = '". mysqli_real_escape_string($link, $_POST['email'])."'";
			
            $result = mysqli_query($link, $query);
			
            if (mysqli_num_rows($result) > 0){ 
			
				$error= "That email address is already taken!";
				
			}
			
		    else{
                
                $query = "INSERT INTO users (email, password,username) VALUES ('". mysqli_real_escape_string($link, $_POST['email'])."', '". mysqli_real_escape_string($link, $_POST['password'])."','". mysqli_real_escape_string($link, $_POST['username'])."')";
                
				if (mysqli_query($link, $query)) {
				 
				   $_SESSION['id'] = mysqli_insert_id($link);
				   
				   $_SESSION['username'] = $_POST['username'];
				   
				   $query1 = "UPDATE users SET password = '". md5(md5($_SESSION['id']).$_POST['password']) ."' WHERE id = ".mysqli_insert_id($link);
				   
				   mysqli_query($link,$query1);
				   
				   echo 1;
				   
				   
				   
                } 
				else {
				
                    $error = "Couldn't create user - please try again later";
					
                }
                
            }
				
        }
    	else{
		
			$query = "SELECT * FROM users WHERE email = '". mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            
            $result = mysqli_query($link, $query);
            
            $row = mysqli_fetch_assoc($result);
			
			if ($row['password'] == md5(md5($row['id']).$_POST['password'])) {
                    
                    echo 1;
					
					$_SESSION['id'] = $row['id'];
					$_SESSION['username'] = $row['username'];
					
                    
                } 
			else {
                    
                    $error = "Could not find that username/password combination. Please try again.";
                    
			}
		}
                
         
		if ($error != "") {
            
            echo $error;
            exit();
            
        }
		
	}

  if ($_GET['action'] == 'toggFoll') {
        
            $query = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id'])." AND isfollowing = ". mysqli_real_escape_string($link, $_POST['userId'])." LIMIT 1";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) > 0) {
                
                $row = mysqli_fetch_assoc($result);
                
                mysqli_query($link, "DELETE FROM isFollowing WHERE id = ". mysqli_real_escape_string($link, $row['id'])." LIMIT 1");
                
                echo "1";
                  
            } else {
                
                mysqli_query($link, "INSERT INTO isFollowing (follower, isfollowing) VALUES (". mysqli_real_escape_string($link, $_SESSION['id']).", ". mysqli_real_escape_string($link, $_POST['userId']).")");
                
                echo "2";
                
            }
        
    }
	
  if ($_GET['action'] == 'toggLike') {
         
            $query = "SELECT * FROM Likes WHERE LikedBy = ". mysqli_real_escape_string($link, $_SESSION['id'])." AND LikedPost = ". mysqli_real_escape_string($link, $_POST['TweetId'])." LIMIT 1";
            $result = mysqli_query($link, $query);
            if (mysqli_num_rows($result) > 0) {
                
                $row = mysqli_fetch_assoc($result);
                
                mysqli_query($link, "DELETE FROM Likes WHERE id = ". mysqli_real_escape_string($link, $row['id'])." LIMIT 1");
                
                echo "1";
                  
            } else {
                
                mysqli_query($link, "INSERT INTO Likes (LikedBy, LikedPost) VALUES (". mysqli_real_escape_string($link, $_SESSION['id']).", ". mysqli_real_escape_string($link, $_POST['TweetId']).")");
                
                echo "2";
                
            }
        
    }
	
    if ($_GET['action'] == 'test') {
         
            echo $_POST['value'];        
    }
	
  if ($_GET['action'] == 'postTweet'){
	  
	  if(!$_POST['tweetContent']){
	       echo "Your tweet is empty.";   
	    }
	  else if (strlen($_POST['tweetContent']) > 140){
		    echo "Your tweet is too long.";
		  }
	  else
	    {
		  $query = "INSERT INTO tweets (tweet,userid,datetime) VALUES ('". mysqli_real_escape_string($link, $_POST['tweetContent'])."', ". mysqli_real_escape_string($link, $_SESSION['id']).", NOW())";
		  if(mysqli_query($link, $query))
		  {
			  echo "1";
		  }
		  else{
		     echo mysqli_error($link);
		  }
	  }
	  
	}
  if ($_GET['action'] == 'postStatus'){
	  
	  if(!$_POST['statusContent']){
	       echo "Your tweet is empty.";   
	    }
	  else if (strlen($_POST['tweetContent']) > 140){
		    echo "Your tweet is too long.";
		  }
	  else
	    {
		  $query = "UPDATE users SET status='".mysqli_real_escape_string($link,$_POST['statusContent'])."' WHERE id=".mysqli_real_escape_string($link, $_SESSION['id']);
		  if(mysqli_query($link, $query))
		  {
			  echo "1";
		  }
		  else{
		     echo mysqli_error($link);
		  }
	  }
	  
	}
  if ($_GET['action'] == 'postComment'){
      if(!$_POST['commentContent']){
	       echo "Your comment is empty.";   
	    }
	  else if (strlen($_POST['commentContent']) > 140){
		    echo "Your comment is too long.";
		  }
	   else
	    {
		  $query = "INSERT INTO comments (comment,commentOn,commentBy,createdAt) VALUES ('". mysqli_real_escape_string($link, $_POST['commentContent'])."','". mysqli_real_escape_string($link, $_POST['id'])."','". mysqli_real_escape_string($link, $_SESSION['id'])."',NOW())";
		  if(mysqli_query($link, $query))
		  {
			  echo "1";
		  }
		  else{
		     echo mysqli_error($link);
		  }
	  }
	  
	}

}
?>