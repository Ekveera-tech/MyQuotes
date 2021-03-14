<?
	
	session_start();
	
	$link=mysqli_connect("shareddb-w.hosting.stackcp.net","twitter-313439e52d","ekveera24","twitter-313439e52d");
	
	if(mysqli_connect_errno()){
	    
		echo mysqli_connect_error();
		exit();
		
	}
	
	if(isset($_GET['func'])){
	   if($_GET['func'] == "logout"){
		
		session_unset();
		
		}
	}
	
	function time_since($since) {// 12 minutes ago....such kind of time calculation
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hour'),
        array(60 , 'min'),
        array(1 , 'sec')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    return $print;
    }
	
	function displayTweets($type){
	
	       global $link;//To be able to use that variable inside a function. It gives an error 'undfined variable link' otherwise
		   $message="";
	
	       if($type == "public"){
			   
			   $whereClause = "";
			   
			   }
		   else if($type == "isFollowing"){
			   $query = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id']);
               $result = mysqli_query($link, $query);
               $whereClause = "";
			   if(mysqli_num_rows($result) == 0){
				   $whereClause = "WHERE userid=0";
				   }
               else{
                while ($row = mysqli_fetch_assoc($result)) { //because there can be more than 1 person I might be following
                
				
                if ($whereClause == ""){
				   $whereClause = "WHERE";
				}
                else {
				$whereClause.= " OR";
				}
                
				$whereClause.= " userid = ".$row['isfollowing'];//userid is the id of people who have tweeted and I follow them.
                
				
			   
		       
			   }
			   }
			   
		   }
		   else if ($type == "yourtweets") {
            
                   $whereClause = "WHERE userid = ". mysqli_real_escape_string($link, $_SESSION['id']);
            
             } 
		   else if ($type == 'search') {
            
             echo '<p>Showing search results for "'.mysqli_real_escape_string($link, $_GET['q']).'":</p>';
            
             $whereClause = "WHERE tweet LIKE '%". mysqli_real_escape_string($link, $_GET['q'])."%'";
            
          }
		  else if (is_numeric($type)) {
            
                $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $type)." LIMIT 1";
                $userQueryResult = mysqli_query($link, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
            
               echo "<h2>".mysqli_real_escape_string($link, $user['username'])."'s Tweets</h2>";
            
                $whereClause = "WHERE userid = ". mysqli_real_escape_string($link, $type);
            
            
          }

			   
		    $query = "SELECT * FROM tweets ".$whereClause." ORDER BY datetime DESC";
			
			$result = mysqli_query($link,$query);
			
			if(mysqli_num_rows($result) == 0){
				if($_GET['page']=="tweets"){
					$message.="You haven't posted anything.";
					}
				else if($_GET['page']=="timeline"){
			        $message.="You follow no one.";
					}
				echo $message;
				
				}
			else{
				
				while($row= mysqli_fetch_assoc($result)){  //to loop through every row of the table.
				
				    $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link,$row['userid'])." LIMIT 1";
					$userQueryResult = mysqli_query($link,$userQuery);
					$user = mysqli_fetch_assoc($userQueryResult);
					
					echo "<div class='tweet'><div class='content'><p><a href='?page=profile&userid=".$user['id']."'>".$user['username']."&ensp;</a><span class='time'>". time_since(time() - strtotime($row['datetime']))." ago : </span><a class='toggleFollow' id='followapp' data-userId='".$row['userid']."' href='#'>";
									
					   if(!isset($_SESSION['id'])){
						   echo "<a href='#Modal' data-toggle='modal' data-target='#Modal' id='followapp'>Login to follow</a>&ensp;";
						   }
					   else{
					   $isFollowingQuery = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id'])." AND isfollowing = ". mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
                       $isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);
	
                       if (mysqli_num_rows($isFollowingQueryResult) > 0) {
                
                        echo "Unfollow";
                
                       } else {
                
                       echo "Follow";
                
                      }
						}
						
						echo "</p></a><p>".$row['tweet']."</p>";
						
						$count=0;
						
						$queryCount = 'SELECT comment FROM comments WHERE commentOn='.$row['id'];
						
						$resultCount = mysqli_query($link,$queryCount);
						
						while($rowCount=mysqli_fetch_assoc($resultCount)){
							
							$count=$count+1;
							
							}
							
						$countL=0;
						
						$queryCountL = 'SELECT LikedBy FROM Likes WHERE LikedPost='.$row['id'];
						
						$resultCountL = mysqli_query($link,$queryCountL);
						
						while($rowCount=mysqli_fetch_assoc($resultCountL)){
							
							$countL=$countL+1;
							
							}
						
						echo "<p class='grey'>".$countL;
						
						if($countL==1){
						
						   echo " Like";
						
						}
						else{
							
							echo " Likes";
							
						}
						
						echo " . ".$count;
						
						if($count==1){
						
						   echo " Comment</p>";
						
						}
						else{
							
							echo " Comments</p>";
							
						}
						
						echo "<hr>";
						
						//Like Feature
						
					    echo "<p id='LC'><a href='#' class='star toggleLike' data-userId='".$row['id']."'>";
						
					
						if(isset($_SESSION['id'])){
						    
						  $isLikedQuery = "SELECT * FROM Likes WHERE LikedBy = ". mysqli_real_escape_string($link, $_SESSION['id'])." AND LikedPost = ". mysqli_real_escape_string($link, $row['id'])." LIMIT 1";
                          $isLikedQueryResult = mysqli_query($link, $isLikedQuery);
	
	                    //To show what all posts did I like in the past when I login to my id.
                          if (mysqli_num_rows($isLikedQueryResult) > 0) {
                
                             echo "<span class='Like'>Liked</span> &#9733;</a>&ensp;&ensp;&ensp;";
                
                           } else {
                
                           echo "<span class='Like'>Like</span> &#9734;</a>&ensp;&ensp;&ensp;";
                
                         }
						
						}
						
						//Comment
						
						echo "<a href='#CommentModal".$row['id']."' data-toggle='modal' data-target='#CommentModal".$row['id']."'>View Comments</a></p>";
						
						echo '<div class="modal fade" id="CommentModal'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					          <div class="modal-dialog">
                              <div class="modal-content">
                              <div class="modal-header">
                              <h5 class="modal-title" id="ModalTitle">Comments</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                              </div>
                              <div class="modal-body">';
							  
					    if($count!=0){
							  
					    $queryshow = "SELECT * FROM comments WHERE commentOn=".$row['id'];
						
		                $resultshow = mysqli_query($link,$queryshow);
						
	                    while($row1=mysqli_fetch_assoc($resultshow)){
						
			            $queryUsername = "SELECT username FROM users WHERE id=".$row1['commentBy'];
							 
			            $resultUser = mysqli_query($link,$queryUsername);
							 
			            $rowuser = mysqli_fetch_assoc($resultUser);
							
			            echo "<p class='alert alert-light'><b>".$rowuser['username']."&ensp;</b><span class='time'>". time_since(time() - strtotime($row1['createdAt']))." ago</span>: <br>".$row1['comment']."</p>";
						
	                    echo '<div class="dropdown">
                              <button class="btn dropdown-toggle time" type="button" id="menu1" data-toggle="dropdown">
                              <span class="caret"></span></button>
                              <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                          
                              </ul>
                             </div>';
							
						}
						
						}
						else{
						
							echo "<p class='alert alert-light'>No comments on this post.</p>";
							
						}
						
		                echo '</div></div></div></div>';
						
						
					      echo '<div id="commentSuccess'.$row['id'].'" class="alert alert-success commentSuccess">Your comment was posted successfully. Please refresh the page to view it.</div>
                                <div id="commentFail'.$row['id'].'" class="alert alert-danger commentFail"></div>';
					
						
						echo '
						  <div class="form" id="textarea1">
						  <textarea id="commentContent'.$row['id'].'" class="form-control custom-control" placeholder="Comment" rows="1" style="resize:none"></textarea>
						  <button class="btn btn-light mb-2 postComment" data-userId="'.$row['id'].'">Post</button>
						</div>';
						
					    echo "</div></div>";
					}
					
					
				}
				
				
			
		}
	function displaySearch(){
		
		echo '<form class="form-inline">
               <div class="form-group mb-2">
			      <input type="hidden" name="page" value="search">
                  <input type="text" name="q" class="form-control" id="search" placeholder="Search Tweets">
               </div>
              <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>';
		
		}
		
	function displayTweetBox(){
		
		if(isset($_SESSION['id'])>0){
			
			echo '<div id="tweetSuccess" class="alert alert-success">Your tweet was posted successfully. Please refresh the page to view it.</div>
                    <div id="tweetFail" class="alert alert-danger"></div><div class="form">
                <div class="form-group mb-2">
                    <textarea class="form-control" id="tweetContent"></textarea>
                </div>
                <button class="btn btn-primary mb-2" id="postTweet">Post Tweet</button>
               </div>';
			
			}
		else{
			
			echo "";
			
			}
		
		
		}
    function displayStatusBox(){
	
	 	if(isset($_SESSION['id'])>0){
			
			echo '<div id="statusSuccess" class="alert alert-success">Your status was posted successfully. Refresh the page to view it.</div>
                  <div id="statusFail" class="alert alert-danger"></div>
				  <div class="form">
                <div class="form-group mb-2">
                    <textarea class="form-control" id="StatusContent"></textarea>
                </div>
                <button class="btn btn-primary mb-2" id="postStatus">Post status</button>
               </div>';
			
			}
		else{
			
			echo "";
			
			}
		
		
		}
		
		
	function displayUsers() {
        
        global $link;
        
        $query = "SELECT * FROM users LIMIT 10";
        
        $result = mysqli_query($link, $query);
            
        while ($row = mysqli_fetch_assoc($result)) {
		    
            
            echo "<div class='card w-75'>
                  <div class='card-body'>
                  <h5 class='card-title'>".$row['username']."</a></h5>
                  <p class='card-text'>".$row['status']."</p>
				  <p><a class='toggleFollow' data-userId='".$row['id']."' href='#'>";
				    if(!isset($_SESSION['id'])){
						   echo "<a href='#Modal' data-toggle='modal' data-target='#Modal'>Login to follow<a>&ensp;&ensp;&ensp;";
						   }
				    else{
				          $query1="SELECT * FROM isFollowing WHERE follower=".mysqli_real_escape_string($link, $_SESSION['id'])." AND isfollowing = ". mysqli_real_escape_string($link, $row['id'])." LIMIT 1";;
						  $result1=mysqli_query($link,$query1);
						  if(mysqli_num_rows($result1) > 0) {
                
                               echo "Unfollow";
                
                          } else {
                
                            echo "Follow";
                
                          }
						  
					    }
				 
			echo "</a>&ensp;&ensp;<a href='?page=profile&userid=".$row['id']."'>Visit Profile</a></div></div>";
                 
            
        }
        
        
        
    }
	
	function displayStatus($type){
	  
	    global $link;
		if($type == "mine"){
		  if(isset($_SESSION['id'])){
		      $query = "SELECT * FROM users WHERE id=".mysqli_real_escape_string($link, $_SESSION['id']);
              $result = mysqli_query($link, $query);
		      if(!$result){
			   mysqli_error($link);
			  }
		      $row=mysqli_fetch_array($result);
		      echo $row['status'];
		}
		}
		else if(is_numeric($type)){
		    $query = "SELECT * FROM users WHERE id=".mysqli_real_escape_string($link, $type);
            $result = mysqli_query($link, $query);
			if(!$result){
			   mysqli_error($link);
			  }
		    $row=mysqli_fetch_array($result);
		    echo "<p>".$row['status']."</p>";
		}
    
	}
		
		
	function FollowingList(){
	   
	   global $link;
	    if(isset($_SESSION['id'])){
	   
	     $query="SELECT * FROM isFollowing WHERE follower = ".mysqli_real_escape_string($link, $_SESSION['id']);
	   
	     $result=mysqli_query($link,$query);
	   
	     if(mysqli_num_rows($result) == 0){
		      echo "No following yet.";
		   }
	     else{
	      while($row=mysqli_fetch_assoc($result)){
		     $query1 = "SELECT * FROM users WHERE id =".$row['isfollowing'];
		     $result1=mysqli_query($link,$query1);
			 $row2=mysqli_fetch_assoc($result1);
			 echo "<p><a href='?page=profile&userid=".$row2['id']."'>".$row2['username']."</a></p>";
		    }
		   
		   }
	   }
	}
	   
	function FollowersList(){
	      global $link;
	    if(isset($_SESSION['id'])){
	      $query="SELECT * FROM isFollowing WHERE isfollowing = ".mysqli_real_escape_string($link, $_SESSION['id']);
	   
	      $result=mysqli_query($link,$query);
	   
	      if(mysqli_num_rows($result)){
		     while($row=mysqli_fetch_assoc($result)){
		       $query1 = "SELECT * FROM users WHERE id =".$row['follower'];
		       $result1=mysqli_query($link,$query1);
			   $row2=mysqli_fetch_assoc($result1);
			   echo "<p><a href='?page=profile&userid=".$row2['id']."'>".$row2['username']."</a></p>";
		     }
		  }
		  else{
			 echo "No followers yet.";
			  }
		}
	}
?>