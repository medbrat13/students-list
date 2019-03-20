<?php

require_once '../config/init.php';

$app =  new \StudentsList\Kernel\App($di);
$app->launch();
