<?php
require_once "secure/session.inc.php";
require_once "secure/secure.inc.php";
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Админка</title>
	<meta charset="utf-8">
</head>
<body>
	<h1>Администрирование магазина</h1>
	<h3>Доступные действия:</h3>
	<ul>
		<li><a href='add_to_catalog.php'>Добавление товара в каталог</a></li>
		<li><a href='orders.php'>Просмотр готовых заказов</a></li>
		<li><a href='secure/create_user.php'>Добавить пользователя</a></li>
		<li><a href='index.php?logout'>Завершить сеанс</a></li>
	</ul>
</body>
</html>