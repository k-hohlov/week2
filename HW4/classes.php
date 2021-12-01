<?php


// 1.
interface interfaceTarif
{
    public function GetPrice(): int;
    public function addService(interfaceService $service);
}

// 2.
interface interfaceService
{
    public function applyService(interfaceTarif $tariff, &$price);
}

// 3.
abstract class Tariff implements interfaceTarif
{
    protected $priceBykm;
    protected $priceByTime;
    protected $distance;
    protected $time;
    protected $services = [];


    public $price_total;

    public function __construct(int $dist, int $time)
    {
        $this->distance = $dist;
        $this->time = $time;
    }

    public function GetPrice() : int
    {
        $price_total = ($this->distance * $this->priceBykm) + ($this->time * $this->priceByTime);

        foreach ($this->services as $service) {
            $service->applyService($this, $price_total);
        }
        return $price_total;
    }

    public function AddService(interfaceService $service) : interfaceTarif
    {
        array_push($this->services, $service);
        return $this;
    }

    public function GetMinutes()
    {
        return $this->time;
    }

}

// 4.
class BasicTariff extends Tariff
{
    protected $priceBykm = 10;
    protected $priceByTime = 3;

}

class HourlyTariff extends Tariff
{
    protected $priceBykm = 0;
    protected $priceByTime = 200 / 60;
}
class StudentTariff extends Tariff
{
    protected $priceBykm = 4;
    protected $priceByTime = 1;

}

// 5.
class ServiceDriver implements interfaceService {

    protected $servicePrice = 100;

    public function applyService($tariff, &$price)
    {
        return $price = $price + $this->servicePrice;

    }
}

class ServiceGPS implements interfaceService {

    protected $priceByTime = 15;

    public function applyService($tariff, &$price)
    {
        $hours = ceil($tariff->getMinutes() / 60);
        $price += $this->priceByTime * $hours;
    }
}
