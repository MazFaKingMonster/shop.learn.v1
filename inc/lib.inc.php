<?php

function add_item_to_catalog($title, $author, $publication_year, $price): bool{
    global $link;
    $add_to_cat_query =    'INSERT INTO catalog (title, author, publication_year, price) 
                            VALUES (?, ?, ?, ?)';

    if (!$stmt = mysqli_prepare($link, $add_to_cat_query)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "ssii", $title, $author, $publication_year, $price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}
function select_all_items(){
    global $link;
    $items_query = 'SELECT id, title, author, publication_year, price 
                    FROM catalog'
    ;

    if(!$result = mysqli_query($link, $items_query)){
        return false;
    }
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $items;
}

function save_cart(){
    global $cart;
    $cart = base64_encode(serialize($cart));
    setcookie('cart', $cart, 0x7FFFFFFF);
}
function cart_init(){
    global $cart, $count;
    if(!isset($_COOKIE['cart'])){
        $cart = ['cart_id' => uniqid()];
        save_cart();
    }else{ $cart = unserialize(base64_decode($_COOKIE['cart']));
        $count = count($cart) - 1;
    }
}
function remove_cart(){
    setcookie('cart', 'clear', time()-3600);
}
function add_to_cart($id){
    global $cart;
    $cart[$id] = 1;
    save_cart();
}

function my_cart(){
    global $link, $cart;
    $goods = array_keys($cart);
    array_shift($goods);
    if(!$goods){
        return false;
    }
    $ids = implode(",", $goods);
    $sql = "SELECT id, author, title, publication_year, price FROM catalog WHERE id IN ($ids)";
    if(!$result = mysqli_query($link, $sql)){
        return false;
    }
    $items = result_to_array($result);
    mysqli_free_result($result);
    return $items;
}
function result_to_array($data): array{
    global $cart;
    $arr = [];
    while($row = mysqli_fetch_assoc($data)) {
        $row['quantity'] = $cart[$row['id']];
        $arr[] = $row;
    }
    return $arr;
}

function delete_item_from_cart($id){
    global $cart;
    unset ($cart[$id]);
    save_cart();
}

function save_order($time): bool{
    global $link, $cart;
    $items = my_cart();
    $stmt = mysqli_stmt_init($link);
    $sql = 'INSERT INTO orders (title, author, publication_year, price, quantity, order_id, date_time) 
            VALUES (?, ?, ?, ?, ?, ?, ?)';
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    foreach($items as $item) {
        mysqli_stmt_bind_param(
                                $stmt,
                                "ssiiisi",
                                $item['title'],
                                $item['author'],
                                $item['publication_year'],
                                $item['price'],
                                $item['quantity'],
                                $cart['cart_id'],
                                $time
        );

        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    remove_cart();
    return true;
}

function get_orders(){
    global $link;

    if(!is_file(ORDERS_LOG)){
        return false;
    }

    /* Получаем в виде массива персональные данные пользователей из файла */
    $orders = file(ORDERS_LOG);

    /* Массив, который будет возвращен функцией */
    $allorders = [];

    foreach ($orders as $order) {

        list($name, $email, $phone, $address, $orderid, $date) = explode("|", $order);

        /* Промежуточный массив для хранения информации о конкретном заказе */
        $orderinfo = [];

        /* Сохранение информацию о конкретном пользователе */
        $orderinfo["name"] = $name;
        $orderinfo["email"] = $email;
        $orderinfo["phone"] = $phone;
        $orderinfo["address"] = $address;
        $orderinfo["orderid"] = $orderid;
        $orderinfo["date"] = $date;

        /* SQL-запрос на выборку из таблицы orders всех товаров для конкретного покупателя */
        $sql = "SELECT title, author, publication_year, price, quantity 
                FROM orders 
                WHERE order_id = '$orderid' 
                AND date_time = $date";

        /* Получение результата выборки */
        if(!$result = mysqli_query($link, $sql)){
            return false;
        }

        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        /* Сохранение результата в промежуточном массиве */
        $orderinfo["goods"] = $items;

        /* Добавление промежуточного массива в возвращаемый массив */
        $allorders[] = $orderinfo;
    }
    return $allorders;
}
