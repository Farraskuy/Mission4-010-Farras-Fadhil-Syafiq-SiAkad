<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection("title") ?></title>
    <link href="<?= base_url("assets/fonts/fonts.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("assets/css/login.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/register.css") ?>">

    <?= $this->renderSection('style') ?>

</head>

<body>
    <?= $this->renderSection("content") ?>

    <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>

    <?= $this->renderSection('script') ?>
</body>

</html>