<form class="mb-3" action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
    <?php if (! empty($data['id'])) : ?>
        <input type="hidden" name="id" value="<?= $data['id']; ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="user-name" class="form-label">Имя пользователя</label>
        <input type="text" class="form-control" id="user-name" name="user_name" value="<?= $data['user_name'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="user-email" class="form-label">Email пользователя</label>
        <input type="text" class="form-control" id="user-email" name="user_email" value="<?= $data['user_email'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="task-description" class="form-label">Задача</label>
        <textarea class="form-control" id="task-description" name="task_description"><?= $data['task_description'] ?? ''; ?></textarea>
    </div>
    <?php if (\App\Models\User::isAdmin()) : ?>
        <div class="mb-3">
            <label for="task-status-id" class="form-label">Статус</label>
            <select class="form-select" id="task-status-id" name="task_status_id">
                <?php foreach ($task_statuses as $task_status) : ?>
                    <option value="<?= $task_status['id']; ?>" <?= isset($data['task_status_id']) && ($data['task_status_id'] === $task_status['id']) ? " selected='selected'" : ''; ?>><?= $task_status['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php else : ?>
        <input type="hidden" name="task_status_id" value="<?= $data['task_status_id'] ?? 1; ?>">
    <?php endif; ?>
    <div class="d-flex justify-content-between">
        <a class="btn btn-secondary" href="<?= buildLink() ?>">Отмена</a>
        <button type="submit" class="btn btn-primary"><?= $submit_button_title ?? 'Отправить'; ?></button>
    </div>
</form>
<?php foreach ($errors as $error) : ?>
    <div class="alert alert-danger" role="alert">
        <?= $error; ?>
    </div>
<?php endforeach; ?>