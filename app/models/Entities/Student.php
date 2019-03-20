<?php

namespace StudentsList\App\Models\Entities;

class Student
{
    private $id;

    private $firstName;

    private $lastName;

    private $gender;

    private $yearOfBirth;

    private $locate;

    private $groupNumber;

    private $email;

    private $points;

    public function __construct($firstName, $lastName, $gender, $yearOfBirth, $locate, $groupNumber, $email, $points, $id = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->yearOfBirth = $yearOfBirth;
        $this->locate = $locate;
        $this->groupNumber = $groupNumber;
        $this->email = $email;
        $this->points = $points;
        $this->id = $id;
    }

    public function modify($firstName, $lastName, $gender, $yearOfBirth, $locate, $groupNumber, $email, $points)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->yearOfBirth = $yearOfBirth;
        $this->locate = $locate;
        $this->groupNumber = $groupNumber;
        $this->email = $email;
        $this->points = $points;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getGroupNumber()
    {
        return $this->groupNumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return mixed
     */
    public function getYearOfBirth()
    {
        return $this->yearOfBirth;
    }

    /**
     * @return mixed
     */
    public function getLocate()
    {
        return $this->locate;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param mixed $groupNumber
     */
    public function setGroupNumber($groupNumber): void
    {
        $this->groupNumber = $groupNumber;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points): void
    {
        $this->points = $points;
    }


}