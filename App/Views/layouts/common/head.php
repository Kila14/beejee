<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Beejee задачник</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    </head>
    <body>
        <div class="container mt-3">
            <div class="d-flex justify-content-end">
                <?php if (\App\Models\User::isAuthenticated()) : ?>
                    <a class="btn btn-secondary" href="<?= buildLink('log-out') ?>">Выход</a>
                <?php elseif($_SERVER['REQUEST_URI'] !== buildLink('log-in')) : ?>
                    <a class="btn btn-primary" href="<?= buildLink('log-in') ?>">Войти</a>
                <?php endif; ?>
            </div>