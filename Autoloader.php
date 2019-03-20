<?php

namespace StudentsList;

/**
 * Класс для автозагрузки других классов
 */
class Autoloader
{
    # массив пространств имен и путей директорий
    private static $namespacesAndPaths = [

        'StudentsList\\Kernel\\'         => __DIR__ . '/kernel',
        'StudentsList\\Kernel\\Base\\'   => __DIR__ . '/kernel/base',
        'StudentsList\\Kernel\\Router\\' => __DIR__ . '/kernel/router',
        'StudentsList\\Kernel\\DB\\'     => __DIR__ . '/kernel/db',

        'StudentsList\\App\\Controllers\\'      => __DIR__ . '/app/controllers',
        'StudentsList\\App\\Models\\'           => __DIR__ . '/app/models',
        'StudentsList\\App\\Models\\Entities\\' => __DIR__ . '/app/models/entites',
        'StudentsList\\App\\Models\\Mappers\\'  => __DIR__ . '/app/models/mappers',
        'StudentsList\\App\\Views\\'            => __DIR__ . '/app/views',

        'StudentsList\\Kernel\\Services\\'      => __DIR__ . '/kernel/services',
        'StudentsList\\Kernel\\Helpers\\'       => __DIR__ . '/kernel/helpers',

    ];


    public function __construct()
    {
        spl_autoload_register(function($class) {
            $file = self::findFile($class);
            if ($file) {
                include $file;
            } else {
                return false;
            }
        });
    }


    /**
     * Ищет путь к файлу класса $class, используя массив пространств имен и путей директорий
     *
     * @param string $class Полное имя класса
     * @return string Путь до класса
     */
    private static function findFile(string $class): string
    {
        if ($class[0] == '\\') {
            $class = substr($class, 1);
        }

        $pathToClass = strtr($class, '\\', '/') . '.php';

        foreach (self::$namespacesAndPaths as $namespace => $path) {
            if (strpos($class, $namespace) === 0 && $file = $path . '/' . substr($pathToClass, strlen($namespace))) {
                if (file_exists($file)) {
                    return $file;
                }
            }
        }

        return '';
    }
}