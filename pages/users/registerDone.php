<?php
session_start();
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once('Models/Database.php');
require_once("components/navbar.php");
require_once('Utils/validator.php');  
$dbContext = new Database();
$username = $dbContext
              ->getUsersDatabase()
              ->getAuth()
              ->getEmail();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Tack för registreringen</title>
</head>
<body>
  <?php navBar(); ?>

  <h1>Välkommen, <?php echo $username; ?>!</h1>
  <p>Tack för din registrering. Du är nu inloggad.</p>
  <p><a href="/">Gå till startsidan</a></p>

  <?php Footer(); ?>
</body>
</html>
