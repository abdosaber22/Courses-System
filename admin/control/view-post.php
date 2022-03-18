<?php
  session_start();
  $page_title = 'Dashboard';
  require('../includes/connect.php');
  include ("../includes/header.php");
  if (!isset($_SESSION['idaaa'])) {
    echo "<script>window.location.href = '../'; </script>";
  }
  if (!isset($_GET['post_id'])) {
    die('Choose Post <a href="index.php">Home</a>');
  }
  if (isset($_GET['post_id'])) {
    $getpost = $conn->prepare('SELECT * FROM posts WHERE id = ?');
    $getpost->execute(array($_GET['post_id']));
    if ($getpost->rowCount() == 0) {
      die("Can't Find Post");
    } elseif ($getpost->rowCount() > 0) {
      $post_data = $getpost->fetch();
    }
  }
?>
  <style media="screen">
    .view-post {
      text-align: center;
    }
    .view-post h1 {
      margin: 5px;
    }
    .view-post span {
      display: block;
      color: gray;
      font-weight: bold;
      margin: 0;
    }
  </style>
  <div class="view-post">
    <h1>Publisher: <?php echo $post_data['publisher']; ?></h1>
    <span>Date: <?php echo $post_data['dates']; ?></span>
    <span>Email: <?php echo $post_data['email'] ?></span>
    <p><?php echo $post_data['content']; ?></p>
  </div>

<?php include ("../includes/footer.php"); ?>
