<?php
  require('includes/connect.php');
  include ("includes/header.php");
  if (isset($_COOKIE['views_status'])) {

  } else {
    setcookie('views_status', 'Views', time() + 500000000);
    $update_viewsDB = $conn->prepare("UPDATE posts SET view = view + 1 WHERE id = ?");
    $update_viewsDB->execute(array($_GET['post_id']));
  }
?>
  <?php
    ## If There's No PostID To Vied
    if (!isset($_GET['post_id'])) {
      header('Location: index.php');
    }
  ?>

  <div class="header">
    <?php include "includes/nav-bar.php";?>
    <h2 class="ar">تكمله القراءه</h2>
  </div>

  <div class="posts">
    <?php
      $select_posts = $conn->prepare("SELECT * FROM posts WHERE id = ?");
      $post_id = $_GET['post_id'];
      $select_posts->execute(array($post_id));
      $posts = $select_posts->fetch();

      $date_1 = explode(' ', $posts['dates']);
      $date_2 = explode(':', $date_1[1]);
      $hour = $date_2[0] - 12 + 1;
      $minutes = $date_2[1] + 10;
      $final_date = ' يوم ' .$date_1[0] . ' الساعة ' . $hour . ':' . $minutes;
    ?>
      <div class="post">
        <div class="post-txt">
          <h1 class="ar">الكاتب:<?php echo $posts['publisher'] ?></h1>
          <span><i class='fa fa-envelope'></i><?php echo $posts['email'] ?></span>
          <span><i class='fa fa-clock-o'></i><?php echo $final_date ?></span>
          <p class="ar"><?php echo $posts['content']; ?></p>
        </div>

        <div class="post-img">
          <img src="uplode-avatar/<?php echo $posts['avatar'] ?>">
        </div>
      </div>
    </div>

<?php include "includes/footer.php"; ?>
