<?php

namespace StudentsList\Kernel\Helpers;

use StudentsList\App\Models\Entities\Student;
use StudentsList\App\Models\Mappers\StudentsMapper;

class StudentsValidator
{
    private $mapper;

    public function __construct(StudentsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function validate(Student $student, $editMode = false): array
    {
        $studentInvalidFields = [];

        if ($student->getFirstName() === '') {
            $studentInvalidFields['first_name'] = 'Имя не может состоять из пробелов :)';
        } else if (mb_strlen($student->getFirstName()) < 2) {
            $studentInvalidFields['first_name'] = 'Слишком короткое имя, вероятно, вас зовут не так :)';
        } else if (mb_strlen($student->getFirstName()) > 35) {
            $studentInvalidFields['first_name'] = 'Слишком длинное имя, вероятно, вас зовут не так :)';
        } else if (!preg_match('#^[A-Za-zА-ЯЁа-яё]+$#iu', $student->getFirstName())) {
            $studentInvalidFields['first_name'] = 'В имени не должно быть ничего, кроме букв :)';
        }

        if ($student->getLastName() === '') {
            $studentInvalidFields['last_name'] = 'Фамилия не может состоять из пробелов :)';
        } else if (mb_strlen($student->getLastName()) > 45) {
            $studentInvalidFields['last_name'] = 'Слишком длинная фамилия, вероятно, ее не существует :)';
        } else if (!preg_match('#^[A-Za-zА-ЯЁа-яё]+$#iu', $student->getLastName())) {
            $studentInvalidFields['last_name'] = 'В фамилии не должно быть ничего, кроме букв :)';
        }

        if (mb_strlen($student->getYearOfBirth()) !== 4) {
            $studentInvalidFields['year_of_birth'] = 'Введите ваш полный год рождения';
        } else if ((int)$student->getYearOfBirth() >= (int)date('Y') || (int)$student->getYearOfBirth() < (int)date('Y') - 100) {
            $studentInvalidFields['year_of_birth'] = 'Вероятно, вы еще не родились или уже умерли, но учиться никогда не поздно :)';
        }

        if (!preg_match('#^[A-Za-zА-ЯЁа-яё0-9]{5}$#iu', $student->getGroupNumber())) {
            $studentInvalidFields['group_number'] = 'Номер группы состоит из 5 букв одного алфавита и/или цифр, не больше, не меньше';
        }


        if ($editMode === true) {
            if (!$this->mapper->find('*', 'students', $student->getEmail(), ['email'])) {
                goto validate_new_email;
            }
        } else if ($editMode === false) {
            validate_new_email:
            if (mb_strlen($student->getEmail()) >= 255) {
                $studentInvalidFields['email'] = 'Email слишком длинный, и может быть не обработан нашим почтовым сервером. Пожалуйста, заведите почтовый ящик с более коротким именем';
            } else if (!filter_var($student->getEmail(), FILTER_VALIDATE_EMAIL)) {
                $studentInvalidFields['email'] = 'Некорректный email-адрес. Введите его в формате xxxx@yyy.zz, чтобы мы могли с вами связаться';
            } else if ($this->mapper->find('*', 'students', $student->getEmail(), ['email'])) {
                $studentInvalidFields['email'] = 'Такой email уже существует. Вероятно, вы уже зарегистрировались, кто-то использовал ваш email, или вы ошиблись в его написании';
            }
        }

        if ((int)$student->getPoints() > 300) {
            $studentInvalidFields['points'] = 'Вы не могли получить больше 300 баллов за 3 предмета :)';
        } else if ((int)$student->getPoints() === 0) {
            $studentInvalidFields['points'] = 'Нет смысла даже пытаться поступить в ВУЗ с такими баллами :)';
        } else if ((int)$student->getPoints() < 0) {
            $studentInvalidFields['points'] = 'С отрицательными баллами вам точно не поступить в ВУЗ :)';
        }

        return $studentInvalidFields;
    }
}