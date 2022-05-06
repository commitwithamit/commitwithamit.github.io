<?php
$msg_class = "";
$message = "";
// from profile update form
if(isset($_GET['msg']) && $_GET['msg']=='up_suc'){
  $message = "Profile updated successfully";
  $msg_class = "msg-suc";
}
if(isset($_GET['msg']) && $_GET['msg']=='up_failed'){
  $message = "Profile update failed try again";
  $msg_class = "msg-err";
}
if(isset($_GET['msg']) && $_GET['msg']=='in_suc'){
  $message = "Profile updated successfully";
  $msg_class = "msg-suc";
}
if(isset($_GET['msg']) && $_GET['msg']=='in_failed'){
  $message = "Profile updated failed try again";
  $msg_class = "msg-err";
}
if(isset($_GET['msg']) && $_GET['msg']=='dob_empty'){
  $message = "Please enter your date of birth";
  $msg_class = "msg-err";
}
// from add-post-handler.php when user choose file other than video/image
if(isset($_GET['msg']) && $_GET['msg']=='invalid_file'){
  $message = "Please select valid Image or Video file.";
  $msg_class = "msg-err";
}
// from add-post-handler when adding post is successful (pas = postaddsuccessful / paus = unsuccessful)
if(isset($_GET['msg']) && $_GET['msg']=='pas'){
  $message = "Your post was successfully added!";
  $msg_class = "msg-suc";
}
if(isset($_GET['msg']) && $_GET['msg']=='paus'){
  $message = "Unbale to add your post, try again.";
  $msg_class = "msg-err";
}
if(isset($_GET['msg']) && $_GET['msg']=='nopo'){
  $message = "There's nothing to post.";
  $msg_class = "msg-err";
}
# delete user's post message
if(isset($_GET['msg']) && $_GET['msg']=='p_del'){
  $message = "Post deleted successfully.";
  $msg_class = "msg-suc";
}
if(isset($_GET['msg']) && $_GET['msg']=='un_p_del'){
  $message = "Unable to delete post, try again.";
  $msg_class = "msg-err";
}
if(isset($_GET['msg']) && $_GET['msg']=='sww'){
  $message = "Something went wrong, try again.";
  $msg_class = "msg-err";
}
# editing caption on user's post message
if(isset($_GET['msg']) && $_GET['msg']=='cap_up'){
  $message = "Post updated successfully.";
  $msg_class = "msg-suc";
}
if(isset($_GET['msg']) && $_GET['msg']=='cap_up_fail'){
  $message = "Unable to update post, try again.";
  $msg_class = "msg-err";
}
# for textual post's if during editing text post user tries to empty the post
if(isset($_GET['msg']) && $_GET['msg']=='txt_emp'){
  $message = "There's nothing to post.";
  $msg_class = "msg-err";
}

# for adding moderators 
if(isset($_GET['msg']) && $_GET['msg']=='mod_suc'){
  $message = "Moderator added successfully.";
  $msg_class = "msg-suc";
}
if(isset($_GET['msg']) && $_GET['msg']=='mod_uns'){
  $message = "Failed to add moderator, try again.";
  $msg_class = "msg-err";
}
# for deletin moderators 
if(isset($_GET['msg']) && $_GET['msg']=='mod_del'){
  $message = "Moderator removed successfully.";
  $msg_class = "msg-suc";
}
if(isset($_GET['msg']) && $_GET['msg']=='mod_del_un'){
  $message = "Failed to remove moderator, try again.";
  $msg_class = "msg-err";
}

/* if(isset($_GET["msg"]) && $_GET["msg"]!==''){
  $_GET["msg"] = 'gffd';
  echo $_GET["msg"];
} */
?>