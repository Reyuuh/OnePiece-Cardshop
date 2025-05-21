<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once('Models/Database.php');
require_once("components/navbar.php");
require_once('Utils/validator.php');

$dbContext = new Database();


$data = $_POST ?? [];
$errorMessages = [];
$valid = new Validator($data);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $data['email'];
    $password = $data['password'];
    $passwordRepeat = $data['passwordRepeat'];
    $name = $data['name'];
    $streetAdress = $data['streetAdress'];
    $postalCode = $data['postalCode'];
    $city = $data['city'];

    $valid->field('email')->required()->email();
    $valid->field('password')->required()->min_len(7)->max_len(20);
    $valid->field('passwordRepeat')->equals($password);
    $valid->field('name')->required()->min_len(3)->max_len(50);
    $valid->field('streetAdress')->required()->min_len(3)->max_len(50);
    $valid->field('postalCode')->required()->max_len(5);
    $valid->field('city')->required()->max_len(50);

    if (!$valid->is_valid()) {
        $errorMessages = $valid->error_messages;
    } else {
        try {
            $userId = $dbContext
                ->getUsersDatabase()
                ->getAuth()
                ->register($email, $password, $name);


        $dbContext->addUserDetails($userId, $name, $streetAdress, $postalCode, $city);
            header('Location: /user/registerDone');
            exit;

            

        } catch (\Delight\Auth\InvalidEmailException $e) {
            $errorMessages['email'] = 'Ogiltig e-postadress';
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $errorMessages['password'] = 'Ogiltigt lösenord';
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $errorMessages['email'] = 'Användaren finns redan';
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errorMessages['general'] = 'Något gick fel, var god försök igen';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Registrera</title>
  <link href="/styles/createAccount.css" rel="stylesheet" />
</head>
<body>
  <?php navBar(); ?>

  <section class="register-section">
    <div class="container">
      <h1>Join the strawhats today!</h1>
      <h1 class="register-title">Create account</h1>

      <?php if (isset($errorMessages['general'])): ?>
        <div class="alert"><?= $errorMessages['general'] ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="register-container">

          <div class="form-group">
            <label>E-post</label><br>
            <input type="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
            <div class="error"><?= $errorMessages['email'] ?? '' ?></div>
          </div>

          <div class="form-group">
            <label>Lösenord</label><br>
            <input type="password" name="password">
            <div class="error"><?= $errorMessages['password'] ?? '' ?></div>
          </div>

          <div class="form-group">
            <label>Bekräfta lösenord</label><br>
            <input type="password" name="passwordRepeat">
            <div class="error"><?= $errorMessages['passwordRepeat'] ?? '' ?></div>
          </div>

          <div class="form-group">
            <label>Namn</label><br>
            <input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? '') ?>">
            <div class="error"><?= $errorMessages['name'] ?? '' ?></div>
          </div>

          <div class="form-group">
            <label>Gatuadress</label><br>
            <input type="text" name="streetAdress" value="<?= htmlspecialchars($data['streetAdress'] ?? '') ?>">
            <div class="error"><?= $errorMessages['streetAdress'] ?? '' ?></div>
          </div>

          <div class="form-group">
            <label>Stad</label><br>
            <input type="text" name="city" value="<?= htmlspecialchars($data['city'] ?? '') ?>">
            <div class="error"><?= $errorMessages['city'] ?? '' ?></div>
          </div>

          <div class="form-group">
            <label>Postnummer</label><br>
            <input type="text" name="postalCode" value="<?= htmlspecialchars($data['postalCode'] ?? '') ?>">
            <div class="error"><?= $errorMessages['postalCode'] ?? '' ?></div>
          </div>

          <button type="submit">Register Now!</button>

        </div>
      </form>
    </div>
  </section>

  <?php Footer(); ?>
</body>
</html>
