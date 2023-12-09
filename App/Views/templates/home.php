<?= template('layouts/common/head.php'); ?>
    <h1 class="text-center">Задачи</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Имя пользователя</th>
                <th>Email пользователя</th>
                <th>Задача</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($tasks as $task) : ?>
                <tr>
                    <td><?= $task['user_name']; ?></td>
                    <td><?= $task['user_email']; ?></td>
                    <td><?= $task['task_description']; ?></td>
                    <td>
                        <?= $task['task_status']; ?>
                        <?= ! empty($task['task_admin_edited']) ? '<br>Отредактировано администратором' : ''; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between">
        <div></div>
        <a class="btn btn-primary" href="/add-task">Добавить задачу</a>
    </div>
    <?php if (! empty($task_add_edit_result_cookie)) : ?>
        <div class="alert alert-success" role="alert">
            <?= $task_add_edit_result_cookie; ?>
        </div>
    <?php endif; ?>
<?= template('layouts/common/footer.php'); ?>