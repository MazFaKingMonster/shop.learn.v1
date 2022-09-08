<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Корзина пользователя</title>
</head>
<body>
	<h1>Ваша корзина</h1>
<?php
if(!$count){
    echo "Корзина пуста! Вернитесь в <a href='catalog.php'>Каталог</a>";
    exit;
}else{
    echo "Вернутся в <a href='catalog.php'>Каталог</a>";
}
?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, UAH.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?php
	$items = my_cart();
    $i = 1;
    $sum = 0;
    foreach ($items as $item):
    ?>
    <tr>
	    <td><?php echo $i++;?></td>
	    <td><?php echo $item['title'];?></td>
	    <td><?php echo $item['author'];?></td>
	    <td><?php echo $item['publication_year'];?></td>
	    <td>Цена,<?php echo $item['price'];?> UAH.</td>
	    <td><?php echo $item['quantity'];?></td>
	    <td><a href="delete_from_cart.php?id=<?php echo $item['id'];?>">Удалить</a></td>
</tr>
<?php
        $sum += $item['price'] * $item['quantity'];
endforeach;
?>
</table>

<p>Всего товаров в корзине на сумму: <?php echo $sum;?> UAH.</p>

<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='order_form.php'" />
</div>

</body>
</html>







