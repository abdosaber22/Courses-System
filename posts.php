<?php
  require('includes/connect.php');
  include ("includes/header.php"); ?>

    <div class="header">
      <?php include "includes/nav-bar.php";?>
      <h2 class="ar">بعض الأفكار اللتي قد تنال إعجابك</h2>
    </div>

    <div class="posts">
      <?php
        $select_posts = $conn->prepare('SELECT * FROM posts WHERE status = 1 AND type = "new_ideas" ORDER BY dates DESC');
        $select_posts->execute();
        $posts = $select_posts->fetchAll();
        foreach ($posts as $post) {

          $date_1 = explode(' ', $post['dates']);
          $date_2 = explode(':', $date_1[1]);
          $hour = $date_2[0] - 12 + 1;
          $minutes = $date_2[1] + 10;
          $final_date = ' يوم ' .$date_1[0] . ' الساعة ' . $hour . ':' . $minutes;
      ?>
        <div class="post">
          <div class="post-txt">
            <h1 class="ar">الكاتب:<?php echo $post['publisher'] ?></h1>
            <span><i class='fa fa-envelope'></i><?php echo $post['email'] ?></span>
            <span><i class='fa fa-clock-o'></i><?php echo $final_date ?></span>
            <p class="ar">
              <?php echo readMoreFunction($post['content'], 'view.php', 'post_id', $post['id']); ?>
            </p>
          </div>

          <div class="post-img">
            <img src="uplode-avatar/<?php echo $post['avatar'] ?>">
          </div>
        </div>
      <?php } ?>
    </div>

<?php include "includes/footer.php";?>
