<?php

namespace StudentsList\Kernel\DB;

class DBConfig
{
    private $driver;

    private $host;

    private $dbName;

    private $charset;

    private $dsn;

    private $user;

    private $pass;

    private $opt;

    public function __construct(array $config)
    {
        $this->driver = $config['driver'];
        $this->host = $config['host'];
        $this->dbName = $config['dbname'];
        $this->charset = $config['charset'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->opt = $config['opt'];

        $this->makeDsn($this->driver, $this->host, $this->dbName, $this->charset);
    }

    /**
     * @return mixed
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @return mixed
     */
    public function getOpt()
    {
        return $this->opt;
    }

    private function makeDsn($driver, $host, $dbName, $charset): void
    {
        $this->dsn = "$driver:host=$host;dbname=$dbName;charset=$charset;";
    }
}