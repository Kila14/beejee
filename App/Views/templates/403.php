<?= template('layouts/common/head.php'); ?>
    <h1 class="mb-3 text-center">Доступ запрещён</h1>
    <div class="d-flex justify-content-center">
        <a class="mx-2 btn btn-secondary" href="<?= buildLink() ?>">На главную</a>
        <a class="mx-2 btn btn-primary" href="<?= buildLink('log-in') ?>">Авторизоваться</a>
    </div>
<?= template('layouts/common/footer.php'); ?>