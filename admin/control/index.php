<?php
  session_start();
  $page_title = 'Dashboard';
  require('../includes/connect.php');
  include ("../includes/header.php");
  if (!isset($_SESSION['idaaa'])) {
    echo "<script>window.location.href = '../'; </script>";
  }

  $admin = $conn->prepare("SELECT * FROM users WHERE status = 1 AND id = " . $_SESSION['idaaa']);
  $admin->execute();
  $admin_data = $admin->fetch();
  echo "<h1 style='font-size: 3em'>Admin Logined Data - بيانات المتحكم المسجل دخوله</h1>";
  echo "<h1>Username: " . $admin_data['username'] . "</h1>";
  echo "<h3>Fullname: " . $admin_data['fullname'] . "</h3>";
  echo "<p>Email: " . $admin_data['email'] . "</p>";
  echo "<a href='logout.php'>Logout</a>";
  echo "<br><hr />";

  $gUsers = $conn->prepare('SELECT * FROM users WHERE STATUS = 0 And id != ' . $_SESSION['idaaa']);
  $gUsers->execute();
  $users = $gUsers->fetchAll();

  $gPosts = $conn->prepare('SELECT * FROM posts');
  $gPosts->execute();
  $posts = $gPosts->fetchAll();
?>
    <h1>Users</h1>
    <?php if (count($users) == 0) {
      echo "<div style='background: #bf4141; padding: 15px; color: #FFF;'>No Posts Yet</div>";
      echo "<style>.container.usrs-tbls { display: none; } </style>";
    } ?>
    <div class="container usrs-tbls">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                <?php
      foreach ($users as $user) {
    ?>
                    <tr>
                        <td>
                            <?php echo $user['id'] ?>
                        </td>
                        <td>
                            <?php echo $user['fullname'] ?>
                        </td>
                        <td>
                            <?php echo $user['username'] ?>
                        </td>
                        <td>
                            <?php echo $user['email'] ?>
                        </td>
                        <td>
                          <a href='delete.php?delete=user&user_id=<?php echo $user["id"] ?>'>Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
            </table>

        </div>
    </div>



    <h1>Posts</h1>
    <?php if (count($posts) == 0) {
      echo "<div style='background: #bf4141; padding: 15px; color: #FFF;'>No Posts Yet</div>";
      exit;
    } ?>
    <div class="container">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Publisher</th>
                    <th>Date</th>
                    <th>Email</th>
                    <th>Type</th>
                </tr>
                <?php

      foreach ($posts as $post) {
    ?>
                    <tr>
                        <td>
                            <?php echo $post['id'] ?>
                        </td>
                        <td>
                            <?php echo $post['publisher'] ?>
                        </td>
                        <td>
                            <?php echo $post['dates'] ?>
                        </td>
                        <td>
                            <?php echo $post['email'] ?>
                        </td>
                        <td>
                            <?php echo $post['type'] ?>
                        </td>
                        <td>
                          <a href='delete.php?delete=post&post_id=<?php echo $post["id"] ?>'>Delete</a> -- 
                          <a href='view-post.php?post_id=<?php echo $post["id"] ?>'>View</a>
                          <?php if ($post['status'] == 0) { ?>
                             --
                            <a href='approve.php?post_id=<?php echo $post["id"] ?>'>Approve</a>
                          <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
            </table>
        </div>
    </div>
<?php include ("../includes/footer.php"); ?>
