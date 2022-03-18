<?php
  require('../includes/connect.php');
  if (isset($_GET['user_id'])) {
    $delete_user = $conn->prepare("DELETE FROM users WHERE id = " . $_GET['user_id']);
    $delete_user->execute();
    if ($delete_user->rowCount() > 0) {
      echo "User with id " . $_GET['user_id'] . " Has been Deleted Successfully";
      echo "<script> setTimeout(function () { window.location.href = 'index.php' }, 1000); </script>";
    }
  }

  if (isset($_GET['post_id'])) {
    $delete_post = $conn->prepare("DELETE FROM posts WHERE id = " . $_GET['post_id']);
    $delete_post->execute();
    if ($delete_post->rowCount() > 0) {
      echo "Post with id " . $_GET['post_id'] . " Has been Deleted Successfully";
      echo "<script> setTimeout(function () { window.location.href = 'index.php' }, 1000); </script>";
    }
  }
