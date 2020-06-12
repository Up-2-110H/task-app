<?php


namespace controllers;


use core\Controller;
use models\Task;

class SiteController extends Controller
{
    const LIMIT = 3;
    private $_sortList = ['task.id', 'username', 'email', 'task.status'];
    private $_sortType = ['asc', 'desc'];

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
}