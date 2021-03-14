
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
<!-- Modal -->

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalTitle">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	      <div class="alert alert-danger" id="loginAlert"></div>
        <form>
		    <input type="hidden" id="LogInActive" value="1">
		  <div class='form-group row' id='User'>
		     <div class='col-sm-10'>
			     <input type='hidden' class='form-control' id='username' placeholder='Enter Username'>
			 </div>
		  </div>
		  <div class="form-group row">
             <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
             <div class="col-sm-10">
                  <input type="email" id="email" class="form-control" placeholder="email@example.com">
              </div>
          </div>
           <div class="form-group row">
             <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                 <input type="password" class="form-control" id="password">
               </div>
           </div>
       </form>
      </div>
      <div class="modal-footer">
	     <a id="toggleLogIn" href="#">Sign Up</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="loginSignUp" class="btn btn-primary">Login</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <?php displayStatusBox(); ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
	
		$("#toggleLogIn").click(function(){
			if($("#LogInActive").val()=="1"){
			//By Default the value would be one so that only LogIn modal displays first.
				$("#LogInActive").val("0");
				$("#ModalTitle").html("Sign Up");
				$("#loginSignUp").html("Sign Up");
				$("#toggleLogIn").html("Log In");
				$("#username").attr("type","text");
				}
			else{
				$("#LogInActive").val("1");
				$("#ModalTitle").html("Login");
				$("#loginSignUp").html("Login");
				$("#toggleLogIn").html("Sign Up");
				$("#username").attr("type","hidden");
				}
			    return true; 
			});
			
	
			$("#loginSignUp").click(function(){
				$.ajax({
					type:"POST",
					url:"actions.php?action=logSign",
					data:"email="+$("#email").val()+"&password="+$("#password").val()+"&loginActive="+$("#LogInActive").val()+"&username="+$("#username").val(),
					success:function(result){
						if(result == "1"){
							window.location.assign("http://ekveerajoshi-com.stackstaging.com/myQuotes.php");
						}
						else{
							$("#loginAlert").html(result).show();
						}
					}
				})
			});
			
			$(".toggleFollow").click(function(){
				var id = $(this).attr("data-userId");
				$.ajax({
					type:"POST",
					url:"actions.php?action=toggFoll",
					data:"userId=" + id,
					success:function(result){
					  if (result == "1") {
                    
                            $("a[data-userId='" + id + "']").html("Follow");
                    
                     } else if (result == "2") {
                    
                           $("a[data-userId='" + id + "']").html("Unfollow");
                    
                   }
					
					}
						
				})
				return false;
				
				});
				
			$(".toggleLike").click(function(){
				var id = $(this).attr("data-userId");
				$.ajax({
					type:"POST",
					url:"actions.php?action=toggLike",
					data:"TweetId=" + id,
					success:function(result){
					  if (result == "1") {
                    //To toggle Like 
                            $("a[data-userId='" + id + "']").html('<span class="Like">Like</span> &#9734;');
                    
                     } else if (result == "2") {
                    
                           $("a[data-userId='" + id + "']").html('<span class="Like">Liked</span> &#9733;');
                    
                   }
					
					}
						
				})
				return false;
				
				});
				
			$("#postTweet").click(function(){
				$.ajax({
					type:"POST",
					url:"actions.php?action=postTweet",
					data:"tweetContent=" + $("#tweetContent").val(),
					success:function(result){
					      if (result == "1") {
                    
                           $("#tweetSuccess").show();
                           $("#tweetFail").hide();
                    
                         } else if (result != "") {
                    
                           $("#tweetFail").html(result).show();
                           $("#tweetSuccess").hide();
                    
                        }
					}
						
				})
				});
			$("#postStatus").click(function(){
				$.ajax({
					type:"POST",
					url:"actions.php?action=postStatus",
					data:"statusContent=" + $("#StatusContent").val(),
					success:function(result){
					      if (result == "1") {
                    
                           $("#statusSuccess").show();
                           $("#statusFail").hide();
                    
                         } else if (result != "") {
                    
                           $("#statusFail").html(result).show();
                           $("#statusSuccess").hide();
                    
                        }
					}
						
				})
				});
			
			$(".postComment").click(function(){
			
			    <?php if(isset($_SESSION['id'])) {?>
				    var id= $(this).attr("data-userId");
					var cls="#commentContent"+id;
					var is="#commentSuccess"+id;
					var iF="#commentFail"+id;
				    $.ajax({
					type:"POST",
					url:"actions.php?action=postComment",
					data:"commentContent=" +$(cls).val()+"&id="+id,
					success:function(result){
					      if (result == "1") {
                    
                           $(is).show();
                           $(iF).hide();
                    
                          } else if (result != "") {
                    
                           $(iF).html(result).show();
                           $(is).hide();
                    
                        }  
					}
						
				    })
				
				<?php } else { ?>
				
					$('#Modal').modal('show'); 
				
				<?php } ?>

				});

		});		
			
		
		
	</script>
  </body>
</html>