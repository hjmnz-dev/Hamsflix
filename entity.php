<?php 
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMessage::show("No ID passed into page");
}


$entityId = $_GET["id"];
$entity = new Entity($con, $entityId);

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonProvider($con, $userLoggedIn);
echo $seasonProvider->create($entity);

$categoryContainers = new CategoryContainers($con, $userLoggedIn);
echo $categoryContainers->showCategory($entity->getCategoryId(),"You might also like");

?>
