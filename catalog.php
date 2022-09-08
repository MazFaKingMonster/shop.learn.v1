<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Каталог товаров</title>
</head>
<body>
<p>Товаров в <a href="cart.php">корзине</a>: <?= $count?></p>
<table border="1" cellpadding="5" cellspacing="0" width="100%">

<tr>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, UAH.</th>
	<th>Добавить</th>
</tr>
    <?php
    $stuff = select_all_items();

    foreach ($stuff as $item):
    ?>
        <tr>
            <td><?=$item['title']?></td>
            <td><?=$item['author']?></td>
            <td><?=$item['publication_year']?></td>
            <td><?=$item['price']?></td>
            <td><a href="add_to_cart.php?id=<?php echo $item['id']?>">В корзину</td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
</body>
</html>