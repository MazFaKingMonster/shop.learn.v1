<?php
	// подключение библиотек
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/config.inc.php";

$title = $_POST['title'];
$author = $_POST['author'];
$publication_year = $_POST['publication_year'];
$price = $_POST['price'];

if(!add_item_to_catalog($title, $author, $publication_year, $price)){
    echo 'Произошла ошибка при добавлении товара в каталог';
}else{
    header("Location: add_to_catalog.php");
    exit;
}
