
<div class="row">
 <div class="col mainContainer">
	<h4>People you follow..</h4>
	<?php FollowingList(); ?>
	<hr>
	<h4>People who follow you</h4>
	<?php FollowersList(); ?>
	<hr>
	<div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Your current status</h5>
        <p class="card-text"><?php displayStatus('mine'); ?>
			</p>
        <a href="#statusModal" class="btn btn-success" data-toggle="modal" data-target="#statusModal" class="card-link">Change</a>
      </div>
    </div>
  </div>
  <div class="col-6 mainContainer">
	<h4>Your recent tweets</h4>
	<?php displayTweets('yourtweets'); ?>
   </div>
   <div class="col mainContainer">
		
		<?php displaySearch(); ?>
		<hr>
		<?php displayTweetBox() ?>

		
   </div>

</div>
