<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once('Models/Database.php');
require_once("components/navbar.php");

$dbContext = new Database();



$errorMessage = "";
$username = ""; 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    try{  
       
        $dbContext->getUsersDatabase()->getAuth()->login($username, $password);
        header('Location: /');
        exit;
    }
    catch(Exception $e){
        $errorMessage = "Kunde inte logga in";
    }
}else{
    
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        
       
        <link href="/styles/login.css" rel="stylesheet" />
    </head>
<body>
<?php navBar(); ?>

    <section class="login-section">
  <div class="container">
    <h1 class="welcome">Welcome fellow Strawhat!</h1>
    <h1>Log in</h1>
    <?php if($errorMessage): ?>
      <div class="error"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <p>Logga in med din email och lösenord</p>
    <form method="POST">  
      <div class="form-group">
        <label for="username">Email</label>
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password">
      </div>
      <div class="login-group">
        <input type="submit" value="Login">
        <a href="/register">Register</a>
        <a href="/forgot">Forgot password</a>
      </div>
    </form>
  </div>
</section>




</div>
</section>



<?php Footer(); ?>


</body>
</html>
