<?php

namespace StudentsList\App\Controllers;

use StudentsList\Kernel\DI;

class MainController extends AppController
{
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_SORT_TYPE = 'points_down';

    private $studentMapper;

    public function __construct(DI $di)
    {
        parent::__construct($di);

        $this->studentMapper = $di->getDependency('students_mapper');
        session_start();

        if (!isset($_COOKIE['token'])) {
            setcookie('token', uniqid('', true), mktime() + 86400, '/', null, false, true);
        }
    }

    public function indexAction(): void
    {
        $this->viewTemplate = 'index';
        $this->setMeta('Список абитуриентов');
        $this->setData(['h1' => 'Список абитуриентов']);
        $this->setData(['header_btn_action' => '/signup']);
        $this->setData(['header_btn_text' => 'Мой профиль']);
        $this->setData(['token' => $_COOKIE['token']]);

        $get = $_GET ?? [];

        $currentPage = $this->getCurrentPage($get, self::DEFAULT_PAGE);
        $sortParams = $this->getSortParams($get, self::DEFAULT_SORT_TYPE);

        $limit = 6;
        $offset = $currentPage * $limit - $limit;

        try {
            $studentsPerPage = $this->studentMapper->find('*', 'students', '' , [], $sortParams['orderBy'], $sortParams['orderDir'], $limit, $offset);
            $allPages = $this->countPages($this->studentMapper->countAll(), $limit);
        } catch (\PDOException $ex) {
            echo 'Извините, какие-то проблемы со ссылкой, возможно, вы случайно дописали лишний символ :(';
            exit();
        }

        $this->setData(['current_page' => $currentPage]);
        $this->setData(['students' => $studentsPerPage]);
        $this->setData(['all_pages' => $allPages]);
    }

    public function searchAction(): void
    {
        $this->viewTemplate = 'index';
        $this->setMeta('Поиск');
        $this->setData(['h1' => 'Поиск']);
        $this->setData(['header_btn_action' => '/']);
        $this->setData(['header_btn_text' => 'Показать всех']);
        $this->setData(['token' => $_COOKIE['token']]);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $get = $_GET ?? [];

            $currentPage = $this->getCurrentPage($get, self::DEFAULT_PAGE);
            $sortParams = $this->getSortParams($get, self::DEFAULT_SORT_TYPE);
            $subject = $this->getSearchSubject($get);

            $searchWhere = ['first_name', 'last_name', 'group_number', 'points'];
            $limit = 6;
            $offset = $currentPage * $limit - $limit;

            if ($subject === '') goto empty_search_query;

            try {
                $students = $this->studentMapper->find('*', 'students', "%$subject%", $searchWhere, $sortParams['orderBy'], $sortParams['orderDir']);
                $studentsPerPage = $this->studentMapper->find('*', 'students', "%$subject%", $searchWhere, $sortParams['orderBy'], $sortParams['orderDir'], $limit, $offset);
            } catch (\PDOException $ex) {
                echo 'Какие-то проблемы со ссылкой или поисковой строкой, возможно, вы случайно дописали лишний символ. Если нет, попробуйте немного изменить поисковой запрос';
                exit();
            }

            $pages = $this->countPages(count($students), $limit);
            $this->setData(['current_page' => $currentPage]);
            $this->setData(['students' => $studentsPerPage]);
            $this->setData(['founded_pages' => $pages]);
            empty_search_query:
            $this->setData(['search' => $subject]);
        }
    }

    private function countPages(int $items, int $times): int
    {
        $pages = ceil($items / $times);
        return $pages;
    }

    private function getSortParams($get, $default): array
    {
        $html = function ($arr) {
            return array_map(function ($arr) {
                return htmlspecialchars($arr, ENT_QUOTES);
            }, $arr);
        };

        if (isset($get['search_btn'])) {
            unset($get['sort']);
            goto default_sort_params;
        } elseif (isset($get['sort'])) {
            $params = $html($this->makeSortParams($get['sort']));
            $_SESSION['sort'] = $get['sort'];
        } elseif (isset($_SESSION['sort'])) {
            $params = $html($this->makeSortParams($_SESSION['sort']));
        } else {
            default_sort_params:
            $params = $html($this->makeSortParams($default));
        }

        return $params;
    }

    private function makeSortParams(string $data): array
    {
        $params = [];
        $patterns = ['#up$#', '#down$#'];
        $replacements = ['ASC', 'DESC'];

        $explodedData = explode('_', $data);
        $orderDir = preg_replace($patterns, $replacements, array_pop($explodedData));
        $orderBy = implode('_', $explodedData);

        $params['orderBy'] = $orderBy;
        $params['orderDir'] = $orderDir;

        return $params;
    }

    private function getCurrentPage(array $get, string $default): int
    {

        if (isset($get['search_btn'])) {
            unset($get['page']);
            goto default_page;
        } elseif (isset($get['page'])) {
            $page = htmlspecialchars($get['page'], ENT_QUOTES);
            $_SESSION['page'] = $page;
        } elseif (isset($_SESSION['page'])) {
            $page = htmlspecialchars($_SESSION['page'], ENT_QUOTES);
        } else {
            default_page:
            $page = $default;
        }

        return $page;
    }

    private function getSearchSubject($get): string
    {

        if (isset($get['search_btn'])) {
            unset($_SESSION['search']);

            if ($get['search'] === '') {
                goto default_subject;
            }

            $subject = htmlspecialchars($get['search'], ENT_QUOTES);
            $_SESSION['search'] = $subject;
        } elseif (isset($_SESSION['search'])) {
            $subject = htmlspecialchars($_SESSION['search'], ENT_QUOTES);
        } else {
            default_subject:
            $subject = '';
        }

        return $subject;
    }
}