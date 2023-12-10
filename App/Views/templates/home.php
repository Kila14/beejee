<?= template('layouts/common/head.php'); ?>
    <h1 class="mb-3 text-center">Задачи</h1>
    <?php if (count($tasks)) : ?>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th><?= getTableColumnTitle('#', 'tasks.id'); ?></th>
                        <th><?= getTableColumnTitle('Имя пользователя', 'tasks.user_name'); ?></th>
                        <th><?= getTableColumnTitle('Email пользователя', 'tasks.user_email'); ?></th>
                        <th><?= getTableColumnTitle('Задача', 'tasks.task_description'); ?></th>
                        <th><?= getTableColumnTitle('Статус', 'tasks.task_status_id'); ?></th>
                        <th>Отметки</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($tasks as $task) : ?>
                        <tr>
                            <td><?= $task['id']; ?></td>
                            <td>
                                <a href="<?= buildLink("edit-task?id={$task['id']}") ?>"><?= $task['user_name']; ?></a>
                            </td>
                            <td><?= $task['user_email']; ?></td>
                            <td><?= $task['task_description']; ?></td>
                            <td><?= $task['task_status_title']; ?></td>
                            <td><?= ! empty($task['task_admin_edited']) ? 'Отредактировано администратором' : ''; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>Задач нет</p>
    <?php endif; ?>
    <?php if (! empty($pagination)) : ?>
        <nav class="my-3">
            <ul class="pagination justify-content-center my-0">
                <?= $pagination; ?>
            </ul>
        </nav>
    <?php endif; ?>
    <div class="d-flex justify-content-between my-3">
        <div></div>
        <a class="btn btn-primary" href="<?= buildLink('add-task'); ?>">Добавить задачу</a>
    </div>
    <?php if (! empty($task_add_edit_result_cookie)) : ?>
        <div class="alert alert-success" role="alert">
            <?= $task_add_edit_result_cookie; ?>
        </div>
    <?php endif; ?>
<?= template('layouts/common/footer.php'); ?>