<?php


// 1.
interface interfaceTariff
{
    public function getPrice(): int;
    public function addService(interfaceService $service);
}

// 2.
interface interfaceService
{
    public function applyService(interfaceTariff $tariff, $price);
}

// 3.
abstract class Tariff implements interfaceTariff
{
    protected $priceBykm;
    protected $priceByTime;
    protected $distance;
    protected $time;
    protected $services = [];


    public $priceTotal;

    public function __construct(int $dist, int $time)
    {
        $this->distance = $dist;
        $this->time = $time;
    }

    public function getPrice() : int
    {
        $this->priceTotal = ($this->distance * $this->priceBykm) + ($this->time * $this->priceByTime);

        foreach ($this->services as $service) {
            $this->priceTotal = $service->applyService($this, $this->priceTotal);
        }
        return $this->priceTotal;
    }

    public function addService(interfaceService $service) : interfaceTariff
    {
        array_push($this->services, $service);
        return $this;
    }

    public function getMinutes()
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

    public function applyService($tariff, $price)
    {
        return $price + $this->servicePrice;

    }
}

class ServiceGPS implements interfaceService {

    protected $priceByTime = 15;

    public function applyService($tariff, $price)
    {
        $hours = ceil($tariff->getMinutes() / 60);
        return $price + $this->priceByTime * $hours;
    }
}
