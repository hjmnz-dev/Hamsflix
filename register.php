<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account = new Account($con);

if (isset($_POST["submitButton"])) {

  $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
  $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
  $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
  $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
  $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
  $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
  $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

  $success = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);

  if ($success) {
    $_SESSION["userLoggedIn"] = $username;
    header("Location: index.php");
  }

}

function getInputValue($name)
{
  if (isset($_POST[$name])) {
    echo $_POST[$name];
  }
}


?>
<!DOCTYPE html>
<html>

<head>
  <title>Welcome to Hamsflix</title>
  <link rel="icon" type="image/png" href="assets/images/icon.png">

  <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
</head>

<body>
  <div class="signInContainer">
    <div class="column">
      <div class="header">
        <img src="assets/images/logo.png" alt="Site logo">
        <h3>Sign Up</h3>
        <span>to continue to Hamsflix</span>
      </div>
      <form method="POST">

        <?php
        echo $account->getError(Constants::$firstNameCharacters);
        ?>
        <input type="text" placeholder="First Name" name="firstName" value="<?php getInputValue("firstName"); ?>"
          required>

        <?php
        echo $account->getError(Constants::$lastNameCharacters);
        ?>
        <input type="text" placeholder="Last Name" name="lastName" value="<?php getInputValue("lastName"); ?>" required>

        <?php
        echo $account->getError(Constants::$usernameCharacters);
        ?>
        <?php
        echo $account->getError(Constants::$usernameTaken);
        ?>
        <input type="text" placeholder="Username" name="username" value="<?php getInputValue("username"); ?>" required>

        <?php
        echo $account->getError(Constants::$emailsDontMatch);
        ?>
        <?php
        echo $account->getError(Constants::$emailInvalid);
        ?>
        <?php
        echo $account->getError(Constants::$emailTaken);
        ?>
        <input type="email" placeholder="Email" name="email" value="<?php getInputValue("email"); ?>" required>

        <input type="email" placeholder="Confirm Email" name="email2" value="<?php getInputValue("email2"); ?>"
          required>

        <?php
        echo $account->getError(Constants::$passwordsDontMatch);
        ?>
        <?php
        echo $account->getError(Constants::$passwordLength);
        ?>
        <input type="password" placeholder="Password" name="password" required>

        <input type="password" placeholder="Confirm Password" name="password2" required>

        <input type="submit" value="SUBMIT" name="submitButton">
      </form>

      <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>
    </div>
  </div>
</body>

</html>