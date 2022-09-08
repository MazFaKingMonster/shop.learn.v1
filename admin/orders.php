<?php
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/config.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Поступившие заказы</title>
	<meta charset="utf-8">
</head>
<body>
<h1>Поступившие заказы:</h1>
<?php
if(!$orders = get_orders()){
    echo "Заказов нет!";
    exit;
}
foreach ($orders as $order):
?>
<hr>
<h2>Заказ номер: <?= $order["orderid"] ?></h2>
<p><b>Заказчик</b>: <?= $order["name"] ?></p>
<p><b>Email</b>: <?= $order["email"] ?></p>
<p><b>Телефон</b>: <?= $order["phone"] ?></p>
<p><b>Адрес доставки</b>: <?= $order["address"] ?></p>
<p><b>Дата размещения заказа</b>: <?= date('d-m-Y H:m', $order["date"]);?></p>

<h3>Купленные товары: </h3>
<table border="1" cellpadding="5" cellspacing="0" width="90%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
</tr>
    <?php
    $i = 1;
    $sum = 0;
    foreach ($order['goods'] as $item):
        ?>
        <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo $item['title'];?></td>
            <td><?php echo $item['author'];?></td>
            <td><?php echo $item['publication_year'];?></td>
            <td>Цена,<?php echo $item['price'];?> UAH.</td>
            <td><?php echo $item['quantity'];?></td>
        </tr>
        <?php
        $sum += $item['price'] * $item['quantity'];
    endforeach;
    ?>

</table>
<p>Всего товаров в заказе на сумму:<?= $sum?>UAH.</p>
<?php
endforeach;
?>
</body>
</html>