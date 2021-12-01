<?php


// проверка существования пользователя
function GetUser(string $email)
{
    $db = Db::getInstance();
    $query = "SELECT * FROM users WHERE email = :email";

    return $db->fetchOne($query, [':email' => $email]);
}

// создание пользователя
function CreateUser(string $email, string $name, $phone) {
    $db = Db::getInstance();
    $query = "INSERT INTO users(email, `name`, phone) VALUES (:email, :name, :phone)";
    $result = $db->exec($query, [
        ':email' => $email,
        ':name' => $name,
        ':phone' => $phone
    ]);

    return $db->lastInsertId();
}

//создание заказа
function NewOrder(int $userId, $address, $options)
{
    $db = Db::getInstance();
    $query = "INSERT INTO orders(user_id, address, created_at, comment, payment, callback) VALUES (:user_id, :address, :created_at, :comment, :payment, :callback)";
    $db->exec($query, [
        ':user_id' => $userId,
        ':address' => $address,
        ':created_at' => date('Y-m-d H:i:s'),
        ':comment' => $options['comment'],
        ':payment' => $options['payment'],
        ":callback" => $options['callback']
        ]);

    return $db->lastInsertId();
}

//обновление кол-ва заказов
function UpdateUserOrders($user_id)
{
    $db = Db::getInstance();
    $query = "UPDATE users SET orders_count = orders_count +1 WHERE id = $user_id";

    return $db->exec($query);
}