<?php


namespace controllers;


use core\Controller;
use core\FM;
use models\Task;

class SiteController extends Controller
{
    const LIMIT = 3;
    private $_sortList = ['task.id', 'username', 'email', 'task.status'];
    private $_sortType = ['asc', 'desc'];

    public static function access()
    {
        return [
            'actionSignIn' => '?',
            'actionLogout' => '@',
        ];
    }

    /**
     * @param int $page
     * @param int $sort
     * @param int $sort_type
     * @return string
     * @throws \Throwable
     */
    public function actionIndex($page = 1, $sort = 0, $sort_type = 0, $show_alert = 0)
    {
        $page = (int)$page;
        $sort = (int)$sort;
        $sort_type = (int)$sort_type;

        if ($page <= 0 || $sort < 0 || $sort > 3 || $sort_type < 0 || $sort_type > 1) {
            return false;
        }

        $tasks = Task::findAsArray(
            $this->_sortList[$sort],
            $this->_sortType[$sort_type],
            self::LIMIT,
            ($page - 1) * self::LIMIT
        );

        return $this->render('task', [
            'tasks' => $tasks,
            'page' => $page,
            'sort' => $sort,
            'sort_type' => $sort_type,
            'limit' => self::LIMIT,
            'row_count' => Task::count(),
            'show_alert' => $show_alert,
        ]);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionSignIn()
    {

        if (isset($_POST['username']) && isset($_POST['password'])) {
            if (FM::$app->getAuth()->login($_POST['username'], $_POST['password'])) {
                header('location: /');
                die();
            }

            return $this->render('sign-in', [
                'username' => $_POST['username'],
                'loginError' => true
            ]);
        }

        return $this->render('sign-in', [
            'username' => '',
            'loginError' => false
        ]);
    }

    public function actionLogout()
    {
        FM::$app->getAuth()->logout();

        header('location: /');
    }
}