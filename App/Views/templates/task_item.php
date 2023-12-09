<?= template('layouts/common/head.php'); ?>
    <h1 class="text-center"><?= $h1; ?></h1>
    <?= template('layouts/forms/task.php', ['data' => $data, 'task_statuses' => $task_statuses, 'errors' => $errors]); ?>
<?= template('layouts/common/footer.php'); ?>