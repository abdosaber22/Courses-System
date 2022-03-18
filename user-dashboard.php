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

    if (!isset($_GET['username'])) {
      header('Location: ?username='.$user['username']);
    }

    if ($_GET['username'] !== $user['username']) {
      header('Location: ?username='.$user['username']);
    }

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

            <div class="content" style="direction: rtl">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 pull-right">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="blue">
                                    <i class="material-icons">public</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">الافكار</p>
                                    <h3 class="title"><?php echo count($posts_data) ?></h3>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 pull-right">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="blue">
                                    <i class="material-icons">remove_red_eye</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">المشاهدات</p>
                                      <h3 class="title">

                                        <?php foreach ($posts_data as $postdataforviews) {
                                          $posviews = array_map('intval', str_split($postdataforviews['view']));
                                          echo array_sum($posviews);
                                        } ?>
                                      </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 pull-right">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="blue">
                                    <i class="material-icons">remove_red_eye</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">الرصيد الكلى</p>
                                      <h3 class="title"><?php
                                        foreach ($posts_data as $psd) {

                                          $post_views = $psd['view'];
                                          $total_viewsin1000 = $post_views / 100;
                                          $total_price = $total_viewsin1000 * 2;
                                          $convert = array($total_price);
                                          echo array_sum($convert);
                                        }
                                      ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-12 pull-right">
                            <div class="card card-nav-tabs">
                                <div class="card-header" data-background-color="blue">
                                    <div class="nav-tabs-navigation">
                                        <h4 class="title">اخر الأفكار</h4>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="profile">
                                            <table class="table">
                                                <tbody>
                                                  <?php
                                                  if (count($posts_data) == 0) {
                                                    echo "<div align=center>No Posts Yet</div>";
                                                    die;
                                                  }
                                                    foreach ($posts_data as $pd) {

                                                  ?>
                                                    <tr>
                                                        <td><?php echo $pd['content']; ?></td>
                                                        <td class="td-actions text-right">
                                                            <button type="button" onclick='window.location.href = "posts_actions.php?action=edit&post_id=<?php echo $pd['id'] ?>"' rel="tooltip" title="تعديل" class="btn btn-primary btn-simple btn-xs">
																<i class="material-icons">edit</i>
															</button>
                                                            <button type="button"onclick='window.location.href = "posts_actions.php?action=delete&post_id=<?php echo $pd['id'] ?>"' rel="tooltip" title="حذف" class="btn btn-danger btn-simple btn-xs">
																<i class="material-icons">close</i>
															</button>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">
                                    <h4 class="title">الأفكار الأكثر مشاهدة</h4>
                                </div>
                                <div class="card-content table-responsive">
                                  <?php
                                    $latest_posts = $conn->prepare("SELECT * FROM posts WHERE publisher = ? AND view >= 150 ORDER BY id LIMIT 3");
                                    $latest_posts->execute(array($user['fullname']));
                                    $lpd = $latest_posts->fetchAll();
                                    if (count($lpd) == 0) {
                                      die('<div align=center>No High Posts</div>');
                                    }
                                  ?>
                                    <table class="table table-hover">
                                        <thead class="text-warning">
                                            <th>ID</th>
                                            <th>حاله المنشور</th>
                                            <th>المشاهدات</th>
                                            <th>رصيدك</th>
                                        </thead>
                                        <tbody>
                                          <?php foreach ($lpd as $lpdd) { ?>
                                            <tr>
                                                <td><?php echo $lpdd['id'] ?></td>
                                                <td><?php if ($lpdd['status'] == 0) { echo "لم يتم الموافقه عليه"; } else { echo "تم الموافقه عليه"; } ?></td>
                                                <td><?php echo $lpdd['view'] . ' شخص شاهد هذا'; ?></td>
                                                <td>
                                                  <?php
                                                      $post_views = $lpdd['view'];
                                                      $total_viewsin1000 = $post_views / 100;
                                                      $total_price = $total_viewsin1000 * 2;
                                                      echo '<strong>$' . $total_price . '</strong>';
                                                  ?>
                                                </td>
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include "includes/footer.php"; ?>
