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
     */
    public function init(): void
    {
        $connection = new Connection($this->di);
        $this->di->setDependency($this->serviceName, $connection);
    }
}