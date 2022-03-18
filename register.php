<?php
  $page_title = 'Signup';
  require('includes/connect.php');
  include('includes/header.php');

?>

    <div class="header">
        <?php include "includes/nav-bar.php";?>
        <h2 class="form-h1">تسجيل مستخدم جديد</h2><br><br>
        <div class="main-form">
            <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
          $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
          $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
          $email    = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
          $phone    = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

          $sha1Password = sha1($password);

          $errors = array();

          if (empty($username)) {
            $errors[] = "من فضلك ادخل اسم المستخدم<br>";
          }
          if (empty($password)) {
            $errors[] = "من فضلك ادخل كلمة المرور<br>";
          }
          if (empty($fullname)) {
            $errors[] = "من فضلك ادخل اسمك الكامل<br>";
          }
          if (empty($email)) {
            $errors[] = "من فضلك ادخل البريد الاكتروني<br>";
          }
          if (empty($phone)) {
            $errors[] = "من فضلك ادخل رقم التليفون الخاص بك<br>";
          }

          if (strlen($username) <= 3 && !empty($username)) {
            $errors[] = "الاسم لا يجب أن يقل عن 5 أحرف!";
          }
          if (strlen($fullname) <= 6 && !empty($fullname)) {
            $errors[] = "الاسم لا يجب أن يقل عن 5 أحرف!";
          }
          if (strlen($password) <= 8 && !empty($password)) {
            $errors[] = "كلمة المرور لا يجب أن تقل عن 8 أحرف أو علامات";
          }
          if (filter_var($email, FILTER_VALIDATE_EMAIL) == false && !empty($email)) {
            $errors[] = "من فضلك ادخل بريد إلكتروني صحيح";
          }

          foreach ($errors as $error) {
            echo "<strong style='color: black;'>$error</strong>";
          }
          if (empty($errors)) {
            $newUser = $conn->prepare("INSERT INTO
              `users`(username, password, email, fullname, phone)
              VALUES(?, ?, ?, ?, ?)
              ");
            $newUser->execute(array(
              $username, // Username Value
              $sha1Password, // Password Value
              $email, // Email Value
              $fullname,
              $phone
            ));
            if ($newUser->rowCount() > 0) {
              $getUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
              $getUser->execute(array(
                $username // Username Value
              ));
              $returnedUserData = $getUser->fetch();
              $_SESSION['user_id'] = $returnedUserData['id'];
              echo "Redirecting<br><strong>Your ID = " . $_SESSION['user_id'] ."</strong>";
              $username_user = $returnedUserData['username'];
              echo "<script>";
                echo "setTimeout(function () { window.location.href = 'profile.php?username=$username_user'; }, 3000);";
              echo "</script>";
            } else {
              echo "Username or password is invalid";
            }
          }
        }
      ?>

                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
                    <input type='text' name='username' placeholder="اسم المستخدم" value="<?php if (isset($username)) { echo $username; } ?>">
                    <input type='text' name='fullname' placeholder="اسمك الكامل" value="<?php if (isset($fullname)) { echo $fullname; } ?>">
                    <input type='email' name='email' placeholder="البريد الإلكتروني" value="<?php if (isset($email)) { echo $email; } ?>">
                    <input type='password' name='password' placeholder="كلمة المرور" autocomplete="new-password">
                    <input type='text' name='phone' placeholder="رقمك">
                    <button>تسجيل جديد</button>
                </form>

                <p>لديك حساب بالفعل!
                    <a href="login.php">سجل دخولك الان</a>
                </p>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
