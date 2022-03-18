<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $server_uri = $_SERVER['PHP_SELF'];
    if ($server_uri == '/first/view.php') {
      if (isset($_GET['post_id'])) {
        $getpostid = $conn->prepare("SELECT * FROM posts WHERE id = " . $_GET['post_id']);
        $getpostid->execute();
        $gotData = $getpostid->fetch();
        $page_title = $gotData['publisher'] . ' كتب المنشور';
      }
    }
  ?>
  <?php require('title.php'); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php title(); ?></title>
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Scheherazade:400,700&amp;subset=arabic" rel="stylesheet">
  <link rel="stylesheet" href="layout/css/bootstrap.min.css">
  <link rel="stylesheet" href="layout/css/material-dashboard.css">
  <link rel="stylesheet" href="layout/css/style.css">
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <?php require('readmore.php'); ?>
