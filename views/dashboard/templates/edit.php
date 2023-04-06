<?php 
require_once("../includes/session.php");
require_once("../includes/dbconnection.php");

// email mp 
if(isset($_POST['email_mp_update'])){
// $id = $_POST['id'];

if($_POST['is_mp'] != 'yes'){
    $is_mp = 'no';
    $email_sub = null;
    $message = null;
}else{
    $is_mp = $_POST['is_mp'];
    $email_sub = $_POST['email_sub'];
$message = $_POST['message'];
}

$query = "UPDATE `template` SET `is_mp`='$is_mp',`email_sub` = '$email_sub', `message`='$message'";
$result = mysqli_query($conn,$query);
print_r(mysqli_error($conn));
         if($result){
?>
<script>
        localStorage.setItem("message_success", 'Email Mp Updated Successfully');
         location.href = '<?php  echo BASEURL; ?>/dashboard/templates';
</script>
<?php
         }else{
             ?>
             <script>
             localStorage.setItem("message_error", '<?php echo mysqli_error($conn); ?>');
       location.href = '<?php echo $_SERVER['HTTP_REFERER']; ?>';
        </script>
             <?php
         }
}

// social share 

if(isset($_POST['update'])){

if($_POST['is_social_share'] != 'yes'){
    $is_social_share = 'no';
      $is_tweet_mp = 'no';
}else{
    
    $is_social_share = $_POST['is_social_share'];
    if($_POST['is_facebook'] != 'yes'){
        $is_facebook = 'no';
    }else{
         $is_facebook = $_POST['is_facebook_text'];
    }
    
     if($_POST['is_insta'] != 'yes'){
        $is_insta = 'no';
    }else{
         $is_insta = $_POST['is_insta_text'];
    }
    
      if($_POST['is_twitter'] != 'yes'){
        $is_twitter = 'no';
    }else{
         $is_twitter = $_POST['is_twitter_text'];
    }
     if($_POST['is_linkedin'] != 'yes'){
        $is_linkedin = 'no';
    }else{
         $is_linkedin = $_POST['is_linkedin_text'];
    }
    
}
  
     if($_POST['is_tweet_mp'] != 'yes'){
    $is_tweet_mp = 'no';
    $tweet_mp_text = null;
}else{
    $is_tweet_mp = $_POST['is_tweet_mp'];
    $tweet_mp_text = $_POST['tweet_mp_text'];
}

   if($_POST['is_email_friend'] != 'yes'){
    $is_email_friend = 'no';
}else{
    $is_email_friend = $_POST['is_email_friend'];
}

$email_friend_text  = $_POST['email_friend_text'];
$email_friend_title = $_POST['email_friend_title'];

$query = "UPDATE `template` SET `is_social_share`='$is_social_share',`is_tweet_mp`='$is_tweet_mp',`tweet_mp_text`='$tweet_mp_text', `is_facebook` = '$is_facebook', `is_insta` = '$is_insta',  `is_twitter` = '$is_twitter',`is_linkedin` = '$is_linkedin',`email_friend_text`='$email_friend_text',`email_friend_title`='$email_friend_title',`is_email_friend` = '$is_email_friend'";
  
$result = mysqli_query($conn,$query);

print_r(mysqli_error($conn));


         if($result){
?>
<script>
        localStorage.setItem("message_success", 'Social Share Updated Successfully');
         location.href = '<?php  echo BASEURL; ?>/dashboard/templates';
</script>
<?php
         }else{
             ?>
             <script>
             localStorage.setItem("message_error", '<?php echo mysqli_error($conn); ?>');
       location.href = '<?php echo $_SERVER['HTTP_REFERER']; ?>';
        </script>
             <?php
         }

}

?>