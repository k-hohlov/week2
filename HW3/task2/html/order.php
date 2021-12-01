<?php

include './src/classdb.php';
include './src/functions.php';


$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = implode(',',[$_POST['street'],$_POST['home'],$_POST['part'],$_POST['appt'],$_POST['floor']]);
$orderOptions = [
    'comment' => $_POST['comment'],
    'payment' => $_POST['payment'],
    'callback' => (isset($_POST['callback'])) ? 1 : 0,
];

//var_dump($orderOptions);
/* проверить нет ли в базе пользователя с таким email */

$user = GetUser($email);

if ($user) {
    /* пользователь есть, необходимо создать заказ и увеличить счетчик заказов */
    $orderId = NewOrder($user['id'],$address, $orderOptions);
    UpdateUserOrders($user['id']);
    $orderNumber = $user['orders_count'] + 1;
} else {
    /* пользователя нет, создаем пользователя и заказ */
    $NewUserId = CreateUser($email,$name,$phone);
    $orderId = NewOrder($NewUserId,$address, $orderOptions);
    $orderNumber = 1;
}



echo "Спасибо, ваш заказ будет доставлен по адресу: $address<br>
Номер вашего заказа: $orderId <br>
Это ваш $orderNumber заказ! ";