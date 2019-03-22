<?php

namespace StudentsList\Kernel\Services;

use StudentsList\Kernel\DB\Connection;

class ConnectionServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string Имя сервиса
     */
    public $serviceName = 'connection';

    /**
     * Создает сервис
     *
     * @return void
     * @throws \Exception
     */
    public function init(): void
    {
        $config = $this->di->getDependency('db_config');
        $connection = new Connection($config);
        $this->di->setDependency($this->serviceName, $connection);
    }
}