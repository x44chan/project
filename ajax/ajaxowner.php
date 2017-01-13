<?php
	include '../config/conf.php';
	if(!isset($_GET['module'])){
		echo '<script type = "text/javascript">window.location.replace("/project/");</script>';
	}
?>
<?php
	if(isset($_GET['comment']) && isset($_GET['postid'])){
		if (!empty($_GET['comment']) && !empty($_GET['postid'])) {
			$comment =  $_GET['comment'];
			$postid = $_GET['postid'];
			$accid = $_GET['accid'];

			$stmt = $conn->prepare("INSERT INTO comment (comment, post_id, account_id) VALUES (?, ?, ?)");
			$stmt->bind_param("sii", $comment, $postid, $accid);
			$stmt->execute();
?>
<?php 
			//Comments
			$comment = "SELECT a.account_id,a.post_id,a.comment,a.comment_date,b.fname,b.lname FROM projectx.comment as a,testnew.login as b where a.post_id = '$postid' and a.account_id = b.account_id ORDER BY comment_date DESC";
			$comment = $conn->query($comment);
			if($comment->num_rows > 0){
				while ($comments = $comment->fetch_object()) {										
?>									
					<p><?php echo $comments->comment;?></p>
					<footer style ="font-size: 13px;"><i><?php echo $comments->fname . ' ' . $comments->lname . " ( " . date("M j, Y h:i:s A",strtotime($comments->comment_date)) . " ) ";?></i></footer>
					<hr>	
<?php
				}
			}
		}
	}
?>