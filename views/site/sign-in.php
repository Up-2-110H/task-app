<?php

/* @var $username string */
/* @var $loginError bool */

?>
<form method="post">
    <div class="form-group is-invalid">
        <label for="username">Имя пользователя</label>
        <input
                class="form-control<?= $loginError ? ' is-invalid' : '' ?>"
                id="username"
                name="username"
                value="<?= $username ?>"
                required
        >
        <?php if ($loginError): ?>
            <div class="invalid-feedback">
                Неверное имя пользователя или пароль
            </div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-block btn-success">Войти</button>
    </div>
</form>

