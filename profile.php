<?php
  session_start();
  $page_title = 'Personal Information';
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
                    <li>
                        <a href="user-dashboard.php">
	                        <i class="material-icons">dashboard</i>
	                        <p>لوحة تحكم المستخدم</p>
	                    </a>
                    </li>
                    <li class="active">
                        <a href="#">
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
	 							   <a herf='logout.php'><p class="hidden-lg hidden-md">خروج</p></a>
		 						</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

    <div class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-md-8">
                <div class="card" style="direction: rtl;">
                    <div class="card-header" data-background-color="blue">
                      <h4 class="title">تعديل الملف الشخصي</h4>
                    </div>
                    <div class="card-content">
                      <?php $un = $user['username'] ?>
      <?php
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $new_username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $new_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $spassword = sha1($new_password);
            $new_fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
            $new_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
            $errors = array();
            if (empty($new_email)) { $errors[] = "Please enter your email"; }
            if (empty($new_username)) { $errors[] = "Please enter your username"; }
            if (empty($new_password)) { $errors[] = "Please enter your password"; }
            if (empty($new_fullname)) { $errors[] = "Please enter your fullname"; }
            if (empty($new_phone)) { $errors[] = "Please enter your phome"; }
            if (strlen($new_username) <= 3 && !empty($username)) {
              $errors[] = "الاسم لا يجب أن يقل عن 5 أحرف!";
            }
            if (strlen($new_fullname) <= 6 && !empty($fullname)) {
              $errors[] = "الاسم لا يجب أن يقل عن 5 أحرف!";
            }
            if (strlen($new_password) <= 8 && !empty($password)) {
              $errors[] = "كلمة المرور لا يجب أن تقل عن 8 أحرف أو علامات";
            }
            if (filter_var($new_email, FILTER_VALIDATE_EMAIL) == false && !empty($email)) {
              $errors[] = "من فضلك ادخل بريد إلكتروني صحيح";
            }
            foreach ($errors as $error) {
              echo "<div>$error</div>";
            }

            if (empty($errors)) {
              $update_info = $conn->prepare("UPDATE users SET
                username = ?, password = ?, fullname = ?,
                email = ?, phone = ? WHERE id = ?");
              $update_info->execute(array(
                $new_username,
                $spassword,
                $new_fullname,
                $new_email, $new_phone, $user['id']
              ));
              if ($update_info->rowCount() > 0) {
                echo "Informations Updated!";
                echo "<script>window.location.href = 'profile.php'; </script>";
              }
            }
          }
      ?>
  <form method='POST'>
      <div class="row">
          <div class="col-md-6">
              <div class="form-group label-floating">
                  <label class="control-label">البريد الإلكتروني</label>
                  <input type="email" class="form-control" value='<?php echo $user['email'] ?>' name='email'>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group label-floating">
                  <label class="control-label">اسم المستخدم</label>
                  <input type="text" class="form-control" value='<?php echo $user['username'] ?>' name='username'>
              </div>
          </div>
      </div>

      <div class="row">
          <div class="col-md-6">
              <div class="form-group label-floating">
                  <label class="control-label">رقم الهاتف</label>
                  <input type="tel" class="form-control" value='<?php echo $user['phone'] ?>' name='phone'>
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group label-floating">
                  <label class="control-label">الاسم كاملا</label>
                  <input type="text" class="form-control" value='<?php echo $user['fullname'] ?>' name='fullname'>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-sm-12">
              <div class="form-group label-floating">
                  <label class="control-label">كلمة المرور</label>
                  <input type="password" class="form-control" name='password'>
              </div>
          </div>
      </div>

      <button type="submit" class="btn btn-primary pull-right">تحديث البيانات</button>
      <div class="clearfix"></div>
  </form>
                                </div>
                            </div>
                        </div>
                        <form action="index.html" method="post">
                          <div class="col-md-4">
                            <div class="card card-profile">
                              <div class="card-avatar">
                                <a href="#pablo">
                                  <img class="img" src="layout/img/faces/marc.jpg" />
                                </a>
                              </div>
                              <div class="content">
                                <h4 class="card-title"><?php echo $user['fullname'] ?></h4>
                              </div>
                              <button onsubmit='return false;' class="btn btn-primary open-user-picture"><input type="file" name="user_pic" class='user_picture'></button>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <?php include "includes/footer.php"; ?>
