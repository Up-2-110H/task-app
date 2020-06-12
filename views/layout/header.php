<?php

/* @var $show_alert int */

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Задачи</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5 mx-auto">
    <?php if (isset($show_alert) && $show_alert): ?>
        <div class="alert alert-success alert-dismissible fade show" id="task-alert" style="" role="alert">
            <?php if ($show_alert == 1): ?>
                Задача успешно добавлена
            <?php elseif ($show_alert == 2): ?>
                Задача успешно обновлена
            <?php endif; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <button class="btn btn-block btn-dark mb-2">Авторизация</button>