<?php
include './classes.php';

$Tariff = new BasicTariff(5, 60);
//$Tariff = new HourlyTariff(9, 60);

echo "Стоимость по тарифу без услуг: <br>";
echo $Tariff->getPrice() . '<br>';

$Tariff->addService(new ServiceDriver());
$Tariff->addService(new ServiceGPS());


echo "Тариф + услуги: <br>";
echo $Tariff->getPrice() . '<br>';


