<?php

namespace StudentsList\App\Controllers;

use StudentsList\Kernel\Base\Controller;
use StudentsList\Kernel\DI;

/**
 * Просто для того, чтобы наследовать от него все контроллеры
 *
 */
abstract class AppController extends Controller
{
    public function __construct(DI $di)
    {
        parent::__construct($di);

    }
}