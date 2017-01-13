<style type="text/css">
	.panel-title{
		font-size: 14.5px;
	}
</style>
<div class="container">
	<i><h4><span class="icon-stack"></span> <u>Welcome to Project Lounge</u></i> <button data-toggle="modal" data-target="#post" class="btn btn-primary btn-sm pull-right" data-toggle="tooltip" title = "New post"><span class = "icon-quill"></span> Post </button></h4>
	<br>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel-group" id="accordion">
				<?php
					//post query
					$posts = "SELECT a.account_id,a.post_id,a.post_title,a.post_body,a.post_date,b.fname,b.lname FROM projectx.post as a,testnew.login as b where a.account_id = b.account_id ORDER BY post_id DESC";
					$posts = $conn->query($posts);
					while ($post = $posts->fetch_object()) {
				?>
		    	<div class="panel panel-success">
		    		<div class="panel-heading">
		        		<h6 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $post->post_id;?>"><?php echo $post->post_title;?> <b class = "caret"></b></a></h6>
		    		</div>
			    	<div id="<?php echo $post->post_id;?>" class="panel-collapse collapse">
			    		<div class="panel-body" style="padding-left: 30px;">
			    			<blockquote style="font-size: 13px;">
								<p><?php echo $post->post_body;?></p>
								<footer style ="font-size: 13px;"><i><?php echo $post->fname . ' ' . $post->lname . " ( " . date("M j, Y h:i:s A",strtotime($post->post_date)) . " ) ";?></i></footer>
								<br>
								<div class ="form-inline">
									<input type = "text" class="form-control input-sm" placeholder = "Write your comment" name = "comment" style="width: 50%;" autocomplete = "off"/>
									<button type="submit" class="btn btn-sm btn-primary hidden-sm hidden-xs" onclick="commentx()"><span class = "icon-bubble"></span> Comment! </button>
				        			<button type="submit" class="btn btn-sm btn-primary visible-sm visible-xs" onclick="commentx()"><span class = "icon-bubble"></span></button>
				        			<input type="hidden" value="<?php echo $post->post_id;?>" name = "postid">
				        		</div>
								<h4 style="font-size: 13px; font-weight: bold;"><i> - Comments - </i></h4>
								<blockquote style="font-size: 13px;" id="cmnt_tab">
								<?php 
									//Comments
									$comment = "SELECT a.account_id,a.post_id,a.comment,a.comment_date,b.fname,b.lname FROM projectx.comment as a,testnew.login as b where a.post_id = '$post->post_id' and a.account_id = b.account_id ORDER BY comment_date DESC";
									$comment = $conn->query($comment);
									if($comment->num_rows > 0){
										while ($comments = $comment->fetch_object()) {										
								?>									
										<p><?php echo $comments->comment;?></p>
										<footer style ="font-size: 13px;"><i><?php echo $comments->fname . ' ' . $comments->lname . " ( " . date("M j, Y h:i:s A",strtotime($comments->comment_date)) . " ) ";?></i></footer>
										<hr>	
								<?php	} ?>
								</blockquote>
								<?php	}	?>
							</blockquote>
			        	</div>
			      	</div>
		    	</div>
		    	<?php } ?>
		  	</div>
		</div>
	</div>
</div>
<?php
	if( (isset($_SESSION['ertile']) && $_SESSION['ertitle'] != "") || (isset($_SESSION['ermsg']) && $_SESSION['ermsg']) ){
		echo "<script type='text/javascript'>$(document).ready(function(){ $('#post').modal({   backdrop: 'static',    keyboard: false  }); }); </script>";
	}
?>
<div class="modal fade" id="post" role="dialog">
	<div class="modal-dialog">    
	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header" style="padding:25px 50px;">
	      <button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" title = "Close">&times;</button>
	      <h4><span class = "icon-quill"></span> Add new post </h4>
	    </div>
	    <div class="modal-body" style="padding:20px 50px;">
	      <form role="form" action = "" method = "post">
	        <div class="form-group">
	        	<label>Title <font color = "red"> * </font> <?php if(isset($_SESSION['ertitle']) && $_SESSION['ertitle'] != ""){ echo '<font color = "red"><i>' . $_SESSION['ertitle'] . '</i></font>'; unset($_SESSION['ertitle']); } ?> </label>
	        	<i><input autocomplete = "off" type = "text" name = "title" <?php if(isset($_SESSION['title']) && $_SESSION['title'] != ""){ echo ' value = "' . $_SESSION['title'] . '" '; unset($_SESSION['title']); } ?> class="form-control input-sm" placeholder = "Enter post title" required></i>
	        </div>
	        <div class="form-group">
	        	<label>Message <font color = "red"> * </font> <?php if(isset($_SESSION['ermsg']) && $_SESSION['ermsg'] != ""){ echo '<font color = "red"><i>' . $_SESSION['ermsg'] . '</i></font>'; unset($_SESSION['ermsg']); } ?> </label>
	        	<i><textarea name = "message" class="form-control input-sm" required rows="4" cols="50" placeholder = "What's on your mind?"><?php if(isset($_SESSION['msg']) && $_SESSION['msg'] != ""){ echo $_SESSION['msg']; unset($_SESSION['msg']); } ?></textarea></i>
	        </div>
	        <button type="submit" name = "postsub" class="btn btn-primary btn-block btn-sm center-block" style="width: 30%;"><span class="icon-quill"></span> Post </button>
	      </form>
	    </div>
	  </div>      
	</div>
</div>
<?php
	if(isset($_POST['postsub'])){
		if(empty($_POST['title'])){
			$_SESSION['ertitle'] = 'Enter post title';
			$err = 1;
		}
		if(empty($_POST['message'])){
			$_SESSION['ermsg'] = 'Enter message';
			$err = 1;
		}
		if($err > 0){
			echo "<script type='text/javascript'>alert('Check you details'); window.location.href = '/project';</script>";
			$_SESSION['msg'] = $_POST['message'];
			$_SESSION['title'] = $_POST['title'];
		}else{
			$stmt = $conn->prepare("INSERT INTO post (account_id, post_title, post_body) VALUES (?, ?, ?)");
			$stmt->bind_param("iss", $_SESSION['acc_idproj'], $_POST['title'], $_POST['message']);
			if($stmt->execute()){
				echo "<script type='text/javascript'>alert('Success'); window.location.href = '/project';</script>";
			}else{
				$conn->error();
			}
		}
		$conn->close();
	}
?>