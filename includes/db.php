<?php
  require __DIR__.'/../classes/Database.php';

  $config = (require __DIR__.'/../config.php');

  //$con = mysqli_connect("127.0.0.1","root","pass","cp");
  try {
    $db = new Database(
      $config['mysql']['host'],
      $config['mysql']['user'],
      $config['mysql']['password'],
      $config['mysql']['database']
    ); // $db ist jetzt eine neue instanz von Database, du kannst also die objektorientierte MySQLi api verwenden
  } catch (Exception $ex) {
    die('Failed to connect to database.'); // niemals informationen über dein backend auf der seite anzeigen
  }
