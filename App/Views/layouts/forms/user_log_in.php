<form class="mb-3" action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
    <div class="mb-3">
        <label for="user-name" class="form-label">Имя</label>
        <input type="text" class="form-control" id="user-name" name="user_name" value="<?= $data['user_name'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="user-password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="user-password" name="user_password" value="<?= $data['user_password'] ?? ''; ?>">
    </div>
    <div class="d-flex justify-content-between">
        <a class="btn btn-secondary" href="/">Отмена</a>
        <button type="submit" class="btn btn-primary">Войти</button>
    </div>
</form>
<?php foreach ($errors as $error) : ?>
    <div class="alert alert-danger" role="alert">
        <?= $error; ?>
    </div>
<?php endforeach; ?>