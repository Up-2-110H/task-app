<?php

/* @var $users models\User[] */
/* @var $task models\Task */

?>
<form method="post">
    <div class="form-group">
        <label for="user_id">Имя пользователя</label>
        <select class="form-control" id="user_id" name="user_id">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->id ?>"<?= $task->user_id == $user->id ? ' selected' : '' ?>><?= $user->username ?></option>
            <?php endforeach; ?>
        </select>
        <!--        <div class="invalid-feedback">-->
        <!--            Please choose a username.-->
        <!--        </div>-->
    </div>
    <div class="form-group">
        <label for="text">Текст</label>
        <textarea class="form-control" id="text" name="text" rows="3" required><?= $task->text ?></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-block btn-success">Сохранить</button>
    </div>
</form>

