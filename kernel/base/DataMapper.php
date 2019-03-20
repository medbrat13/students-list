<?php

namespace StudentsList\Kernel\Base;

use StudentsList\Kernel\DB\Connection;
use StudentsList\Kernel\Helpers\QueryBuilder;

abstract class DataMapper
{
    protected $connection;
    protected $builder;

    protected $countAllStmt;
    protected $selectStmt;
    protected $updateStmt;
    protected $insertStmt;

    public function __construct(Connection $connection, QueryBuilder $builder)
    {
        $this->connection = $connection;
        $this->builder = $builder;
    }

    public function countAll(): int
    {
        return $this->doCountAll();
    }

    public function create(array $values): object
    {
        return $this->createObject($values);
    }

    public function findOne(int $id): object
    {
        $this->selectStmt->execute([$id]);

        $row = $this->selectStmt->fetch();
        $this->selectStmt->closeCursor();

        if (!is_array($row) || empty($row)) {
            return null;
        }

        $object = $this->createObject($row);
        return $object;
    }

    public function find(string $col, string $table, string $searchBy = null, array $searchWhere = null, string $orderBy = null, string $orderDir = null, int $limit = null, $offset = null): array
    {
        $values = [$col, $table, $searchBy, $searchWhere, $orderBy, $orderDir, $limit, $offset];
        return $this->doFind($values);
    }

    public function insert(object $object): void
    {
        $this->doInsert($object);
    }

    public function update(object $object): void
    {
        $this->doUpdate($object);
    }

    protected function createObject(array $row): object
    {
        $object = $this->doCreateObject($row);
        return $object;
    }

    abstract protected function doCountAll();
    abstract protected function doFind(array $values);
    abstract protected function doInsert(object $object);
    abstract protected function doUpdate (object $object);
    abstract protected function doCreateObject(array $row);

}