<?= template('layouts/common/head.php'); ?>
    <h1 class="mb-3 text-center"><?= $h1 ?? ''; ?></h1>
    <?php if ($mode === 'log_in') : ?>
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-6 col-lg-4">
                <?= template('layouts/forms/user_log_in.php', ['data' => $data, 'errors' => $errors]); ?>
            </div>
        </div>
    <?php endif; ?>
<?= template('layouts/common/footer.php'); ?>