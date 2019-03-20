<?php

namespace StudentsList\App\Models\Mappers;

use StudentsList\App\Models\Entities\Student;
use StudentsList\Kernel\Base\DataMapper;
use StudentsList\Kernel\DB\Connection;
use StudentsList\Kernel\Helpers\QueryBuilder;

class StudentsMapper extends DataMapper
{
    public function __construct(Connection $connection, QueryBuilder $builder)
    {
        parent::__construct($connection, $builder);

        $this->countAllStmt = $this->connection->pdo()->prepare("
            SELECT COUNT(*) FROM `students`
        ");

        $this->selectStmt = $this->connection->pdo()->prepare("
            SELECT * FROM `students` WHERE id=?
        ");

        $this->insertStmt = $this->connection->pdo()->prepare("
            INSERT INTO `students` (
                                    `first_name`, 
                                    `last_name`, 
                                    `gender`,
                                    `year_of_birth`,
                                    `locate`,
                                    `group_number`, 
                                    `email`, 
                                    `points`
                                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $this->updateStmt = $this->connection->pdo()->prepare("
            UPDATE `students` SET `first_name` = ?,
                                  `last_name` = ?,
                                  `gender` = ?,
                                  year_of_birth = ?,
                                  `locate` = ?,
                                  `group_number` = ?,
                                  `email` = ?,
                                  `points` = ? WHERE id = ?
        ");
    }

    protected function doCountAll(): int
    {
        $this->countAllStmt->execute();

        $number = $this->countAllStmt->fetch(7);
        $this->countAllStmt->closeCursor();

        return $number;
    }

    protected function doFind(array $values): array
    {
        $query = $this->builder->select($values);
        $selectAllStmt = $this->connection->pdo()->prepare($query);

        $selectAllStmt->execute();

        $table = $selectAllStmt->fetchAll();
        $selectAllStmt->closeCursor();

        if (!is_array($table) || empty($table) ) {
            return [];
        }

        $objects = [];
        foreach ($table as $row) {
            array_push($objects, $this->createObject($row));
        }

        return $objects;
    }

    protected function doCreateObject(array $row): Student
    {
        $object = new Student(

            $row['first_name'], $row['last_name'], $row['gender'], $row['year_of_birth'], $row['locate'], $row['group_number'], $row['email'], (int)$row['points'], (int)$row['id']
            );

        return $object;
    }

    protected function doInsert(object $object): void
    {

        $values = [
            $object->getFirstName(),
            $object->getLastName(),
            $object->getGender(),
            $object->getYearOfBirth(),
            $object->getLocate(),
            $object->getGroupNumber(),
            $object->getEmail(),
            $object->getPoints(),
        ];

        $this->insertStmt->execute($values);
        $id = $this->connection->pdo()->lastInsertId();
        $object->setId($id);
    }

    protected function doUpdate(object $object): void
    {
        $values = [
            $object->getFirstName(),
            $object->getLastName(),
            $object->getGender(),
            $object->getYearOfBirth(),
            $object->getLocate(),
            $object->getGroupNumber(),
            $object->getEmail(),
            $object->getPoints(),
            $object->getId()
        ];

        $this->updateStmt->execute($values);
    }

}