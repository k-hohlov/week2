<?php

const NAMES = [ 'Dima', 'Vasya', 'Masha', 'Ivan', 'Alex'];
$users = [];

for ($i = 1; $i <= 50 ; $i++) {
    $user = [
        'id' => $i,
        'name' => NAMES[mt_rand(0,4)],
        'age' => mt_rand(18,45),
    ];
    $users[] = $user;
}
echo '<pre>';
//echo var_dump($users);

$json = json_encode($users);

//echo var_dump($json);

file_put_contents('./users.json', $json);


$users_json = json_decode(file_get_contents('./users.json'), true);

echo '<pre>';
echo var_dump($users_json);


$counters = [
    'Dima' => 0,
    'Vasya' => 0,
    'Masha' => 0,
    'Ivan' => 0,
    'Alex' => 0,
];

$age_sum = 0;

foreach ($users_json as $user) {
    $age_sum += $user['age'];
    $counters[$user['name']] += 1;
}


echo var_dump($counters);
echo 'Средний возраст:' . ($age_sum / count($users_json));
