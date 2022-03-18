<?php
  session_start();
  require('includes/connect.php');
  include "includes/header.php";

    $ud = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $ud->execute(array($_SESSION['user_id']));
    $user = $ud->fetch();  ?>

    <div id="new-header" class="header">
        <?php include "includes/nav-bar.php";?>
        <h2 class="ar">!شارك بفكرتك الآن </h2>

        <div class="form">
      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
          $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
          $idea     = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
          $type     = filter_var($_POST['post_type'], FILTER_SANITIZE_STRING);

          // Upload Image
          $avatarName      = $_FILES['admin_picture']['name'];
          $avatarSize      = $_FILES['admin_picture']['size'];
          $avatarTmp       = $_FILES['admin_picture']['tmp_name'];
          $avatarType      = $_FILES['admin_picture']['type'];

          $avatarAllowedExtension = array('jpg', 'png', 'jpeg');

          $value = explode('.', $avatarName);
          $avatarExtension = strtolower(end($value));

          $errors = array();

          if ($type == 'emtpy') { $errors[] = "من فضلك اختر نوع المنشور الذى تريده من القائمه"; }
          if (empty($username)) { $errors[] = "من فضلك ادخل اسم المستخدم"; }
          if (empty($email)) { $errors[] = "من فضلك ادخل البريد الالكترونى"; }
          if (empty($idea)) { $errors[] = "من فضلك اكتب فكرتك الجميله !"; }
          if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
              $errors[] = "من فضلك اختر صوره صحيحه";
          }
          if(empty($avatarName)){
              $errors[] = "من فضلك ادخل صوره ";
          }
          if($avatarSize > 5000000){
              $errors[] = "من فضلك اختر صوره اقل من 5 ميجا بايت";
          }

          if (strlen($username) <= 5 && !empty($username)) { $errors[] = "اسم المستخدم ﻻ يمكن ان يكون اقل من 5 حروف"; }
          if (strlen($idea) <= 60 && !empty($idea)) { $errors[] = "من فضلك اكتب شئ كبير فى فكرتك"; }

          foreach ($errors as $error) {
            echo "<div class='alert-error'>$error</div>";
          }

          if (empty($errors)) {

            $avatar = rand(0, 10000) . '_' . $avatarName;

            move_uploaded_file($avatarTmp , "uplode-avatar/" . $avatar);

            $new_post = $conn->prepare('INSERT INTO posts(publisher, email, content, avatar, type) VALUES(?, ?, ?, ?, ?)');
            $new_post->execute(array($username, $email, $idea, $avatar, $type));
            if ($new_post->rowCount() > 0) {
              echo "<div class='alert-success'>Your Idea Has Been Created!</div>";
            }
          }

        }
      ?>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                    <select class="select-post ar" name='post_type'>
         <option value="emtpy">...نشر في </option>
         <option value="new_ideas">أفكار جديدة</option>
         <option value="advices">نصائح</option>
         <option value="success">قصص النجاح</option>
        </select>
                    <input type="text" class="form-input" placeholder="الاسم" name="username" value="<?php echo $user['id'] ?>">
                    <input type="email" class="form-input" placeholder="البريد الالكتروني" name="email" value="<?php if (isset($email)) { echo $email; } ?>">
                    <textarea name='content' class="form-input" placeholder="الفكرة اللتى تود مشاركتها" value="<?php if (isset($idea)) { echo $idea; } ?>"></textarea>


                    <!-- Uploaded picture goes here -->
                    <div class="setup-picture">
                        <img src='#' id='uploaded'>
                        <div class="picture">
                            <input type="file" name="admin_picture">
                            <i class='fa fa-camera'></i>
                            <h3 class="ar">اختر صورة لعرضها</h3>
                            <div class='clearfix'></div>
                        </div>
                        <!-- <button>Upload Picture</button>-->
                    </div>
                    <input type="submit" class="submit-form ar" value="نشر">
                </form>
        </div>
    </div>


    <?php include "includes/footer.php";?>
