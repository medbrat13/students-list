<?php

namespace StudentsList\Kernel\Services;

use StudentsList\Kernel\Helpers\StudentsValidator;

class StudentsValidatorServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string Имя сервиса
     */
    public $serviceName = 'students_validator';

    /**
     * Создает сервис
     *
     * @return void
     * @throws \Exception
     */
    public function init(): void
    {
        $mapper = $this->di->getDependency('students_mapper');
        $validator = new StudentsValidator($mapper);

        $this->di->setDependency($this->serviceName, $validator);
    }
}