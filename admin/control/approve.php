<?php
  require('../includes/connect.php');
  if (!isset($_SESSION['idaaa'])) {
    echo "<script>window.location.href = '../'; </script>";
  }
  if (isset($_GET['post_id'])) {
    $approve_post = $conn->prepare("UPDATE posts SET status = 1 WHERE id = " . $_GET['post_id']);
    $approve_post->execute();
    if ($approve_post->rowCount() > 0) {
      echo "Post with id " . $_GET['post_id'] . " Has been Approved Successfully";
      echo "<script> setTimeout(function () { window.location.href = 'index.php' }, 1000); </script>";
    }
  } else {
    die('no post selected');
  }
