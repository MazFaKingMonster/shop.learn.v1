<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";

    $id = $_GET['id'];
    if($id){
        delete_item_from_cart($id);
        header("Location: cart.php");
        exit;

    }