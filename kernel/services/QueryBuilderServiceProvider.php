<?php

namespace StudentsList\Kernel\Services;

use StudentsList\Kernel\Helpers\QueryBuilder;

class QueryBuilderServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string Имя сервиса
     */
    public $serviceName = 'query_builder';

    /**
     * Создает сервис
     *
     * @return void
     */
    public function init(): void
    {

        $builder = new QueryBuilder();
        $this->di->setDependency($this->serviceName, $builder);
    }
}