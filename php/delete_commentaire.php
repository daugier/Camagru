<?php
include "../function/image.php";
include "../function/comment.php";

if(isset($_POST['user']) && isset($_POST['text']) && isset($_POST['uniq']) && isset($_POST['id']))
{
	$user = $_POST['user'];
	$text = $_POST['text'];
	$uniq = $_POST['uniq'];
	$id = $_POST['id'];

	$com = get_comment_by_id($id);
	$comment = 'user='.$user.'&text='.$text.'&uniq='.$uniq.'//';
	echo $comment;


	$comment = str_replace("user= ", 'user=', $comment);
	$comment = str_replace("text= ", 'text=', $comment);
	$comment = str_replace("uniq= ", 'uniq=', $comment);
	echo $comment;
	$comment = str_replace($comment, '', $com['comment']);
	sub_commentaire($comment, $id);

}
?>