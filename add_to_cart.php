<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";

$item_id = $_GET['id'];
if($item_id){
    add_to_cart($item_id);
    header("Location: catalog.php");
    exit;
}