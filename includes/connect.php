<?php
// Connection Informations
  define('DB_NAME', 'posts');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '1594200159');
  define('DB_HOST', 'localhost');
  define('DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME);

  ## Options Of Connection
  $connection_options = array(
    PDO::ATTR_ERRMODE                 => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND      => 'SET NAMES UTF8'
    ## More Options ...
  );

  ## Try To Connected
  try {
    $conn = new PDO(DSN, DB_USERNAME, DB_PASSWORD, $connection_options);
  }

  ## Show Connection Errors
  catch (PdoException $getErrMsg) {
    print($getErrMsg->getMessage());
  }
