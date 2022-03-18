<?php
  session_start();
  $page_title = 'User Dashboard';
  require('includes/connect.php');
  include ("includes/header.php");

    if (!isset($_SESSION['user_id'])) {
      header('Location: login.php');
      exit;
    }

    $userinfo = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $userinfo->execute(array($_SESSION['user_id']));
    $user = $userinfo->fetch();

    $getuserposts = $conn->prepare("SELECT * FROM posts WHERE publisher = ?");
    $getuserposts->execute(array($user['fullname']));
    $posts_data = $getuserposts->fetchAll();
    $post_data = $getuserposts->fetch();

?>

    <div class="wrapper">

        <div class="sidebar" data-color="blue" data-image="layout/img/sidebar-1.jpg">
            <div class="logo">
                <a href="#" class="simple-text">
					لوحة تحكم المستخدم
				</a>
            </div>

            <div class="sidebar-wrapper" style="direction: rtl">
                <ul class="nav">
                    <li class="active">
                        <a href="#">
	                        <i class="material-icons">dashboard</i>
	                        <p>لوحة تحكم المستخدم</p>
	                    </a>
                    </li>
                    <li>
                        <a href="profile.php">
	                        <i class="material-icons">person</i>
	                        <p>المعلومات الشخصية</p>
	                    </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="logout.php" class="dropdown-toggle" data-toggle="dropdown" title="خروج">
	 							   <i class="material-icons">exit_to_app</i>
	 							   <p class="hidden-lg hidden-md">خروج</p>
		 						</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php if ($_GET['action'] === 'delete') { ?>
              <?php
                if (!isset($_GET['post_id'])) {
                  echo "No Post Selected to delete";
                  exit;
                } else {
                  $delete_post = $conn->prepare("DELETE FROM posts WHERE id = ?");
                  $delete_post->execute(array($_GET['post_id']));
                  if ($delete_post->rowCount() > 0) {
                    echo "Post With ID: " . $_GET['post_id'] . " Has Been Deleted";
                    echo "<script>setTimeout(function (){ window.location.href = 'user-dashboard.php'; }, 2000);</script>";
                  }
                }
              ?>
            <?php } ?>

            <?php if ($_GET['action'] === 'edit') { ?>
              <?php
                if (!isset($_GET['post_id'])) {
                  echo "No Post Selected to edit";
                  exit;
                } else {
                  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                    $idea     = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
                    $type     = filter_var($_POST['post_type'], FILTER_SANITIZE_STRING);

                    $errors = array();

                    if ($type == 'emtpy') { $errors[] = "من فضلك اختر نوع المنشور الذى تريده من القائمه"; }
                    if (empty($email)) { $errors[] = "من فضلك ادخل البريد الالكترونى"; }
                    if (empty($idea)) { $errors[] = "من فضلك اكتب فكرتك الجميله !"; }

                    if (strlen($idea) <= 60 && !empty($idea)) { $errors[] = "من فضلك اكتب شئ كبير فى فكرتك"; }

                    foreach ($errors as $error) {
                      echo "<div class='alert-error'>$error</div>";
                    }

                    if (empty($errors)) {

                      $update_post = $conn->prepare('UPDATE
                        posts SET email = ?, content = ?, type = ?');
                      $update_post->execute(array($email, $idea, $type));
                      if ($update_post->rowCount() > 0) {
                        echo "<div class='alert-success'>Your Idea Has Been Update!. Redirecting....</div>";
                      }
                    }

                  }
                        $getpost = $conn->prepare("SELECT * FROM posts WHERE id = " . $_GET['post_id']);
                        $getpost->execute();
                        $post = $getpost->fetch();
                  ?>
                  <br><br><br><br><br><br>
                  <form action="?action=edit&post_id=<?php echo $_GET['post_id']; ?>" method="post" enctype="multipart/form-data">
                    <select name="post_type"class="select-post ar">
                      <option value="emtpy">...نشر في </option>
                      <option value="new_ideas">أفكار جديدة</option>
                      <option value="advices">نصائح</option>
                      <option value="success">قصص النجاح</option>
                    </select>
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">البريد الإلكتروني</label>
                            <input type="text" class="form-control" name="email" value="<?php echo $post['email']; ?>">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group label-floating">
                            <label class="control-label">Content</label>
                            <textarea class="form-control" name="content"><?php echo $post['content']; ?></textarea>
                        </div>
                      </div>
                      <div class="clearfix">  </div>
                        <input type="submit" class="btn btn-success submit-form ar" value="نشر">
                  </form>
              <?php
                }
              ?>
            <?php } ?>

            <?php include "includes/footer.php"; ?>
