<?= template('layouts/common/head.php'); ?>
    <h1 class="text-center"><?= $data['h1'] ?? ''; ?></h1>
    <?= template('layouts/forms/task.php', $data ?? []); ?>
<?= template('layouts/common/footer.php'); ?>