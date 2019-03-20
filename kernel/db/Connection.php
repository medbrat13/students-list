<?php

namespace StudentsList\Kernel\DB;

use StudentsList\Kernel\DI;

/**
 * Класс для соединения с бд
 */
class Connection {

    /**
     * @var Config Конфиг базы данных
     */
    private $config;

    /**
     * @var \PDO Экземпляр класса \PDO
     */
    private $pdo;

    public function __construct(DI $di)
    {
        $this->config = $di->getDependency('db_config');

        $this->connect();
    }

    /**
     * Выполняется соединение с бд
     *
     * @return void
     */
    private function connect(): void
    {
        $this->pdo = new \PDO(
            $this->config->getDsn(), $this->config->getUser(), $this->config->getPass(), $this->config->getOpt());
    }

    public function pdo(): \PDO
    {
        return $this->pdo;
    }


}
