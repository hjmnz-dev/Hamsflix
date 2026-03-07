<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once("includes/header.php");

    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createPreviewVideo(null);

     $containers = new CategoryContainers($con, $userLoggedIn);
    echo $containers->showAllCategories();
?>