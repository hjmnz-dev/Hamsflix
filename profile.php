<?php
require_once("includes/header.php");
require_once("includes/paypalConfig.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/billingDetails.php");

$user = new User($con, $userLoggedIn);

$detailsMessage = "";
$passwordMessage = "";
$subscriptionMessage = "";

if (isset($_POST["saveDetailsButton"])) {
    $account = new Account($con);

    $firstName = formSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = formSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = formSanitizer::sanitizeFormString($_POST["email"]);

    if ($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
        $detailsMessage = "<div class='alertSuccess'>
                                Details updated successfully!
                            </div>";
    } else {
        $errorMessage = $account->getFirstError();
        $detailsMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";

    }
}

if (isset($_POST["savePasswordButton"])) {
    $account = new Account($con);

    $oldPassword = formSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = formSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = formSanitizer::sanitizeFormPassword($_POST["newPassword2"]);


    if ($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
        $passwordMessage = "<div class='alertSuccess'>
                                Password updated successfully!
                            </div>";
    } else {
        $errorMessage = $account->getFirstError();
        $passwordMessage = "<div class='alertError'>
                                $errorMessage
                            </div>";

    }
}

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $token = $_GET['token'];
    $agreement = new \PayPal\Api\Agreement();

    $subscriptionMessage = "<div class='alertError'>
                                Something went wrong!
                            </div>";

    try {
        //Execute agreement
        $agreement->execute($token, $apiContext);

        //Update user's account status
        $result = BillingDetails::insertDetails($con,$agreement, $token, $userLoggedIn);
        $result = $result && $user->setIsSubscribed(1);

        if($result){
            $subscriptionMessage = "<div class='alertSuccess'>
                                You're all signed up!
                            </div>";
        }

    } catch (Paypal\Exception\PayPalConnectionException $ex) {
        echo $ex->getCode();
        echo $ex->getData();
        die($ex);
    } catch (Exception $ex) {
        die($ex);
    }
} else if (isset($_GET['success']) && $_GET['success'] == 'false') {
    $subscriptionMessage = "<div class='alertError'>
                                User cancelled or something went wrong!
                            </div>";
}

?>

<div class="settingsContainer column">
    <div class="formSection">
        <form method="POST">
            <h2>User details</h2>


            <?php

            $firstName = isset($_POST["first_name"]) ? $_POST["first_name"] : $user->getFirstName();
            $lastName = isset($_POST["last_name"]) ? $_POST["last_name"] : $user->getLastName();
            $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();

            ?>
            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName; ?>">
            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

            <div class="message">
                <?php echo $detailsMessage; ?>
            </div>

            <input type="submit" name="saveDetailsButton" value="Save">
        </form>
    </div>

    <div class="formSection">
        <form method="POST">
            <h2>Update password</h2>
            <input type="password" name="oldPassword" placeholder="Old password">
            <input type="password" name="newPassword" placeholder="New password">
            <input type="password" name="newPassword2" placeholder="Confirm new password">

            <div class="message">
                <?php echo $passwordMessage; ?>
            </div>

            <input type="submit" name="savePasswordButton" value="Save">
        </form>
    </div>

    <div class="formSection">
        <h2>Subscription</h2>

        <div class="message">
            <?php echo $subscriptionMessage; ?>
        </div>

        <?php
        if ($user->getIsSubscribed()) {
            echo "<h3>You are subscribed! Go to Paypal to cancel. </h3>";
        } else {
            echo "<a href='billing.php'>Subscribe to Hamsflix</a>";
        }
        ?>
    </div>

</div>
