<?php

namespace StudentsList\Kernel\Services;

use StudentsList\Kernel\DB\DBConfig;

class DBConfigServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string Имя сервиса
     */
    public $serviceName = 'db_config';

    /**
     * Создает сервис
     *
     * @return void
     */
    public function init(): void
    {
        $params = require_once CONF . '/dbconf.php';
        $config = new DBConfig($params);
        $this->di->setDependency($this->serviceName, $config);
    }
}