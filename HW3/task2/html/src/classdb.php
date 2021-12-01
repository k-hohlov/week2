<?php
const DB_HOST = '127.0.0.1';
const DB_NAME = 'burgers';
const DB_USER = 'root';
const DB_PASSWORD = 'root';

class Db
{


    private static $instance;
    /** @var \PDO */
    private $pdo;
    private $log = [];

    private function  __construct()
    {

    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance =  new self();
        }

        return self::$instance;
    }

    private function connect()
    {
        if (!$this->pdo) {
            $this->pdo = new PDO("mysql:host=". DB_HOST. ";dbname=". DB_NAME, DB_USER, DB_PASSWORD);
    }
        return $this->pdo;

    }

    public function exec(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $pdo_prepare = $this->pdo->prepare($query);
        $ret = $pdo_prepare->execute($params);
        $t = microtime(1) - $t;

        if (!$ret) {
            if ($pdo_prepare->errorCode()) {
                trigger_error($pdo_prepare->errorInfo());
            }
            return false;
        }

        $this->log[] = [
            'query' => $query,
            'time' => $t,
            'method' => $method
        ];

        return $pdo_prepare->rowCount();

    }

    public function fetchAll(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $pdo_prepare = $this->pdo->prepare($query);
        $ret = $pdo_prepare->execute($params);
        $t = microtime(1) - $t;

        if (!$ret) {
            if ($pdo_prepare->errorCode()) {
                trigger_error(json_encode($pdo_prepare->errorInfo()));
            }
            return false;
        }

        $this->log[] = [
            'query' => $query,
            'time' => $t,
            'method' => $method
        ];

        return $pdo_prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne(string $query, array $params = [], string $method = '')
    {
        $this->connect();
        $t = microtime(1);
        $pdo_prepare = $this->pdo->prepare($query);
        $ret = $pdo_prepare->execute($params);
        $t = microtime(1) - $t;

        if (!$ret) {
            if ($pdo_prepare->errorCode()) {
                trigger_error(json_encode($pdo_prepare->errorInfo()));
            }
            return false;
        }

        $this->log[] = [
            'query' => $query,
            'time' => $t,
            'method' => $method
        ];

        $result = $pdo_prepare->fetchAll(PDO::FETCH_ASSOC);
        return reset($result);
    }

    public function  lastInsertId()
    {
        $this->connect();
        return $this->pdo->lastInsertId();
    }

    public function getLog()
    {
        return $this->log;
    }


}
