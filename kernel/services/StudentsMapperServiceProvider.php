<?php

namespace StudentsList\Kernel\Services;

use StudentsList\App\Models\Mappers\StudentsMapper;

class StudentsMapperServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string Имя сервиса
     */
    public $serviceName = 'students_mapper';

    /**
     * Создает сервис
     *
     * @return void
     * @throws \Exception
     */
    public function init(): void
    {
        $connection = $this->di->getDependency('connection');
        $builder = $this->di->getDependency('query_builder');
        $mapper = new StudentsMapper($connection, $builder);

        $this->di->setDependency($this->serviceName, $mapper);
    }
}