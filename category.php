<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once("includes/header.php");

if (!isset($_GET["id"])) {
    ErrorMessage::show("No id passed to page");
}

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createCategoryPreviewVideo($_GET["id"]);

$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showCategory($_GET["id"]);
?>