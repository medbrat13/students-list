<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.03.19
 * Time: 4:02
 */

namespace StudentsList\Kernel\Services;

use StudentsList\Kernel\DI;

abstract class AbstractServiceProvider
{
    /**
     * @var DI Экземпляр класса DI
     */
    protected $di;

    public function __construct(DI $di)
    {
        $this->di = $di;
    }

    /**
     * Инициализирует новый сервис
     *
     * @return mixed
     * @throws \Exception
     */
    abstract function init();
}
