<?php

/* @var $tasks array */
/* @var $page int */
/* @var $sort int */
/* @var $sort_type int */
/* @var $limit int */
/* @var $row_count int */

?>
<nav class="text-center">
    <ul class="pagination">
        <?php for ($i = 1; $i <= floor(($row_count - 1) / $limit) + 1; $i++): ?>
            <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                <a class="page-link" href="/site/index/<?= $i ?>/<?= $sort ?>/<?= $sort_type ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th scope="col">
            <a href="/site/index/<?= $page ?>/0/<?= $sort == 0 && $sort_type == 0 ? 1 : 0 ?>">
                ID <i class="fa fa-arrow-<?= $sort == 0 && $sort_type == 0 ? 'up' : 'down' ?>"></i>
            </a>
        </th>
        <th scope="col">
            <a href="/site/index/<?= $page ?>/1/<?= $sort == 1 && $sort_type == 0 ? 1 : 0 ?>">
                Имя пользователя <i class="fa fa-arrow-<?= $sort == 1 && $sort_type == 0 ? 'up' : 'down' ?>"></i>
            </a>
        </th>
        <th scope="col">
            <a href="/site/index/<?= $page ?>/2/<?= $sort == 2 && $sort_type == 0 ? 1 : 0 ?>">
                Email <i class="fa fa-arrow-<?= $sort == 2 && $sort_type == 0 ? 'up' : 'down' ?>"></i>
            </a>
        </th>
        <th scope="col">Текст</th>
        <th scope="col">Отредактировано администратором</th>
        <th scope="col">
            <a href="/site/index/<?= $page ?>/3/<?= $sort == 3 && $sort_type == 0 ? 1 : 0 ?>">
                Выполнено <i class="fa fa-arrow-<?= $sort == 3 && $sort_type == 0 ? 'up' : 'down' ?>"></i>
            </a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task): ?>
        <tr>
            <td onclick="document.location = '/task/update/<?= $task['id'] ?>';">
                <?= $task['id'] ?>
            </td>
            <td onclick="document.location = '/task/update/<?= $task['id'] ?>';">
                <?= $task['username'] ?>
            </td>
            <td onclick="document.location = '/task/update/<?= $task['id'] ?>';">
                <?= $task['email'] ?>
            </td>
            <td onclick="document.location = '/task/update/<?= $task['id'] ?>';">
                <?= $task['text'] ?>
            </td>
            <td onclick="document.location = '/task/update/<?= $task['id'] ?>';">
                <?= $task['edited'] ? 'Да' : 'Нет' ?>
            </td>
            <td>
                <div class="form-check text-center">
                    <input
                            class="form-check-input status-checkbox"
                            type="checkbox"
                            data-id="<?= $task['id'] ?>"
                        <?= $task['status'] ? 'checked' : '' ?>
                    >
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="/task/create" class="btn btn-block btn-outline-success mb-2">Добавить задачу</a>
