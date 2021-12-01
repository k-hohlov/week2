<?php
include './classes.php';

//$Tariff = new BasicTariff(5, 120);
$Tariff = new HourlyTariff(9, 60);

echo "Стоимость по тарифу без услуг: <br>";
echo $Tariff->GetPrice() . '<br>';

$Tariff->AddService(new ServiceDriver());
$Tariff->AddService(new ServiceGPS());


echo "Тариф + услуги: <br>";
echo $Tariff->GetPrice() . '<br>';


