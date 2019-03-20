<?php

namespace StudentsList\Kernel;

/**
 * Класс-контейнер IoC
 */
class DI
{
    /**
     * @var array Контейнер, хранящий зависимости
     */
    private $container = [];

    /**
     * Добавляет зависимость
     *
     * @param string $key Ключ
     * @param mixed $value Значение (зависимость)
     * @return void
     */
    public function setDependency(string $key, $value): void
    {
        $this->container[$key] = $value;
    }

    /**
     * Возвращает зависимость из контейнера
     *
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function getDependency(string $key)
    {
        try {
            if ($this->hasKey($key)) {
                return $this->container[$key];
            }
            throw new \Exception("Сервис $key не найден", 503);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            exit();
        }



    }

    /**
     * Проверка на существование ключа в массиве зависимостей
     *
     * @param string $key Ключ
     * @return bool
     */
    public function hasKey(string $key): bool
    {
        return isset($this->container[$key]);
    }

}