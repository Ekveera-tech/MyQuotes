
<div class="row">
	
    <div class="col-sm-8 mainContainer">
      <?php if (isset($_GET['userid'])) { ?>
      
      <?php displayTweets($_GET['userid']); ?>
	  
      <?php } else { ?> 
        
        <h2>Active Users</h2>
        
        <?php displayUsers(); ?>
      
      <?php } ?>
	</div>
    <div class="col-sm-4 mainContainer">
		
		<?php displaySearch(); ?>
		<hr>
		<?php displayTweetBox() ?>
		
		<?php if (isset($_GET['userid'])) { ?>
		
	    <hr>
	    <h4>Their Status :</h4>
	    <?php displayStatus($_GET['userid']); ?>
		
		<?php } ?> 
		
		</div>
</div>
