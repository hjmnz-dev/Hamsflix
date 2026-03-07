<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/CategoryContainers.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/VideoProvider.php");
require_once("includes/classes/User.php");

if (!isset($_SESSION["userLoggedIn"])) {
    header("Location: login.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Hamsflix</title>
    <link rel="icon" type="image/png" href="assets/images/icon.png">
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    <script src="https://code.jquery.com/jquery-4.0.0.min.js"
        integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/60c603600b.js" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</head>

<body>
    <div class="wrapper">

        <?php
        if (!isset($hideNav)) {
            include_once("includes/navBar.php");
        }
        ?>