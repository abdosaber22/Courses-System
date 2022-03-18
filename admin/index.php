<?php
  session_start();
  $page_title = 'Login Admin';
  require('includes/connect.php');
  include ("includes/header.php");

?>

  <!-- Admin Login Form -->
  <div class="header">
    <div class="">
      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
          $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
          $sha1Password = sha1($password);
          $errors = array();
          if (empty($username)) { $errors[] = "Please Enter Your Username<br>"; }
          if (empty($password)) { $errors[] = "Please Enter Your Password<br>"; }
          foreach ($errors as $error) {
            echo "<strong style='color: black;'>$error</strong>";
          }
          if (empty($errors)) {
            $getAdmin = $conn->prepare("SELECT username, password, id FROM users WHERE username = ? AND password = ? AND status = 1");
            $getAdmin->execute(array(
              $username, // Username Value
              $sha1Password, // Password Value
            ));
            if ($getAdmin->rowCount() > 0) {
              $returnedAdminData = $getAdmin->fetch();
              $_SESSION['idaaa'] = $returnedAdminData['id'];
              echo "Redirecting";
              header('REFRESH: 2;URL=control');
            } else {
              echo "Username or password is invalid";
            }
          }
        }
      ?>

      <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" autocomplete="off">
        <input type='text' name='username' placeholder="Your Username" value="<?php if (isset($username)) { echo $username; } ?>">
        <input type='password' name='password' placeholder="Your Password" autocomplete="new-password">
        <button>Sign in</button>
      </form>
    </div>
  </div>
<?php include ("includes/footer.php"); ?>