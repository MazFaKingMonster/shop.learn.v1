<?php
	require "inc/lib.inc.php";
	require "inc/config.inc.php";

    global $cart;

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$order_id = $cart['cart_id'];
$time_order = time();
$order = "$name|$email|$phone|$address|$order_id|$time_order\n";

file_put_contents("admin/". ORDERS_LOG, $order, FILE_APPEND);
save_order($time_order);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>