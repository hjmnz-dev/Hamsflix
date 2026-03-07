<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account = new Account($con);

if (isset($_POST["submitButton"])) {

    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

    $success = $account->login($username, $password);

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
                <h3>Sign In</h3>
                <span>to continue to Hamsflix</span>
            </div>
            <form method="POST">
                <?php
                echo $account->getError(Constants::$loginFailed);
                ?>
                <input type="text" placeholder="Username" name="username" value="<?php getInputValue("username"); ?>"
                    required>

                <input type="password" placeholder="Password" name="password" required>

                <input type="submit" value="SUBMIT" name="submitButton">
            </form>

            <a href="register.php" class="signInMessage">Need an acount? Sign up here!</a>
        </div>
    </div>
</body>

</html>