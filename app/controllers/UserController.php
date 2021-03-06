<?php

namespace StudentsList\App\Controllers;

use StudentsList\Kernel\DI;

class UserController extends AppController
{
    private $studentMapper;
    private $studentsValidator;

    public function __construct(DI $di)
    {
        parent::__construct($di);
        $this->studentMapper = $di->getDependency('students_mapper');
        $this->studentsValidator = $di->getDependency('students_validator');
    }

    public function signUpAction(): void
    {
        $this->viewTemplate = 'form';
        $this->setMeta('Форма регистрации');
        $this->setData(['h1' => 'Форма регистрации']);
        $this->setData(['header_btn_action' => '/']);
        $this->setData(['header_btn_text' => 'Главная']);
        $this->setData(['form_title_text' => 'Заполните информацию о себе:']);
        $this->setData(['submit_data_text' => 'Отправить']);

        if (isset($_COOKIE['user'])) {
            $student = $this->studentMapper->findOne($_COOKIE['user']);
            header('Location: /user/' . $student->getId() . '/edit');
        }

        $token = $this->setToken();
        $this->setData(['token' => $token]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $values = $this->html($_POST);

            $student = $this->studentMapper->create($values);
            $errors = $this->studentsValidator->validate($student);

            if ($errors !== []) {
                $this->setData(['form_values' => $values]);
                $this->setData(['errors' => $errors]);

            } else {
                $postToken = $_POST['token'] ?? '';
                $cookieToken = $_COOKIE['token'] ?? '';

                $this->checkToken($postToken, $cookieToken);

                $this->studentMapper->insert($student);
                setcookie('user', $student->getId(), mktime() + 315360000, '/', null, false, true);
                header('Location: /user/' . $student->getId() . '/edit?reg=success');
            }
        }
    }

    public function editAction(): void
    {
        if (!isset($_COOKIE['user'])) {
            http_response_code('404');
            exit();
        }

        $this->viewTemplate = 'form';
        $this->setMeta('Редактирование информации');
        $this->setData(['h1' => 'Редактирование информации']);
        $this->setData(['header_btn_action' => '/']);
        $this->setData(['header_btn_text' => 'Главная']);
        $this->setData(['form_title_text' => 'Вы можете отредактировать информацию о себе:']);
        $this->setData(['submit_data_text' => 'Сохранить']);

        if (isset($_GET['edit']) && $_GET['edit'] === 'ok') {
            $this->setData(['form_edit_result' => 'Данные сохранены :)']);
        }

        $student = $this->studentMapper->findOne((int)$_COOKIE['user']);
        $studentURINumber = (int)explode('/', $_SERVER['QUERY_STRING'])[1];

        if ($studentURINumber === $student->getId()) {
            $values = $this->objToArr($student);
            $values = $this->setAttrValues($values);
            $this->setData(['form_values' => $values]);
        } else {
            http_response_code(404);
            exit();
        }

        $token = $this->setToken();
        $this->setData(['token' => $token]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $values = $this->setAttrValues($this->html($_POST));
            $values['id'] = $student->getId();

            $updatedStudent = $this->studentMapper->create($values);
            $errors = $this->studentsValidator->validate($updatedStudent, true);

            if ($errors !== []) {
                $this->setData(['form_values' => $values]);
                $this->setData(['errors' => $errors]);

            } else {
                $postToken = $_POST['token'] ?? '';
                $cookieToken = $_COOKIE['token'] ?? '';

                $this->checkToken($postToken, $cookieToken);

                $this->studentMapper->update($updatedStudent);
                header('Location: /user/' . $student->getId() . '/edit?edit=ok');

            }
        }
    }

    private function setToken(): string
    {
        if (!isset($_COOKIE['token'])) {
            $token = uniqid('', true);
            setcookie('token', $token, mktime() + 86400, '/', null, false, true);
        } else {
            $token = $_COOKIE['token'];
            setcookie('token', $token, mktime() + 86400, '/', null, false, true);
        }

        return $token;
    }

    private function checkToken(string $postToken, string $cookieToken): void
    {
        if ($postToken === '' || $cookieToken === '' || $postToken !== $cookieToken) {
            echo 'Небольшие неполадки в системе, попробуйте отправить позже...';
            exit();
        }
    }

    private function objToArr(object $object)
    {
        $classNameToCut = get_class($object);
        $array = (array)$object;
        $newArray = [];

        foreach ($array as $key => $item) {
            $newCamelKey = str_replace($classNameToCut, '', $key);
            $newUnderscoreKey = trim(strtolower(preg_replace('#(?<!^)[A-Z]#', '_$0', $newCamelKey)));
            $newArray[$newUnderscoreKey] = $item;

        }

        return $newArray;
    }

    private function setAttrValues(array $data): array
    {
        $values = [];
        $attrNames = [
            'first_name', 'last_name', 'gender', 'group_number', 'email', 'points', 'year_of_birth', 'locate'
        ];

        foreach ($attrNames as $attrName) {
            if ($attrName === 'gender' || $attrName === 'locate') {
                if (array_key_exists($attrName, $data)) {
                    $value = trim(strval($data[$attrName]));
                    $values[$attrName] = $value;
                    $values[$attrName . '_is_checked'] = [$value => 'checked'];
                }
            } else {
                $values[$attrName] = array_key_exists($attrName, $data) ? trim(strval($data[$attrName])) : '';
            }
        }

        return $values;
    }

    private function html($arr): array
    {
        return array_map(function ($arr) {
            return htmlspecialchars($arr, ENT_QUOTES);
        }, $arr);
    }
}