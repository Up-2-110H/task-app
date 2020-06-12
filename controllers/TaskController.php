<?php


namespace controllers;


use core\Controller;
use models\Task;
use models\User;

class TaskController extends Controller
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function actionCreate()
    {
        $task = new Task();
        $data = $this->formCheck();

        $users = User::findAll();

        if ($data) {
            $task->user_id = $data['user_id'];
            $task->text = $data['text'];

            if ($task->insert()) {
                $task_page = floor((Task::count() - 1) / SiteController::LIMIT) + 1;
                return $this->render('form', [
                    'users' => $users,
                    'task' => $task,
                    'show_alert' => 1,
                    'page' => $task_page,
                ]);
            }
        }

        return $this->render('form', [
            'users' => $users,
            'task' => $task,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \Throwable
     */
    public function actionUpdate($id)
    {
        $task = Task::findOne(['id' => $id]);

        $data = $this->formCheck();

        $users = User::findAll();

        if ($data) {
            $task->user_id = $data['user_id'];
            $task->text = $data['text'];
            $task->edited = 1;

            if ($task->update()) {
                return $this->render('form', [
                    'users' => $users,
                    'task' => $task,
                    'show_alert' => 2,
                ]);
            }
        }

        return $this->render('form', [
            'users' => $users,
            'task' => $task,
        ]);
    }

    public function actionStatusChange($id)
    {
        $task = Task::findOne(['id' => $id]);

        if ($task) {
            $task->status = ($task->status + 1) % 2;
            return $task->update();
        }

        return false;
    }

    private function formCheck()
    {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $text = isset($_POST['text']) ? htmlspecialchars(trim($_POST['text'])) : null;

        if (!$user_id || !$text) {
            return false;
        }

        $user = User::findOne(['id' => $user_id]);

        if (!$user || !strlen($text)) {
            return false;
        }

        return [
            'user_id' => $user->id,
            'text' => $text,
        ];
    }
}