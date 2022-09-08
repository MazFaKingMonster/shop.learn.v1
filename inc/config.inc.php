<?php
const DB_HOST = "localhost";
const DB_LOGIN = "root";
const DB_PASS = "";
const DB_NAME = "shop";
const ORDERS_LOG = "orders.log";

global $cart;
$cart = [];

global $link;
$link = mysqli_connect(
    DB_HOST,
    DB_LOGIN,
    DB_PASS,
    DB_NAME
);

$count = 0;

cart_init();
