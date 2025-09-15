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

    <div class="d-flex w-100 vh-100 align-items-center justify-content-center justify-content-sm-end position-relative login">

        <!-- Background -->
        <div class="w-100 h-100 overflow-hidden position-absolute">
            <img src="<?= base_url("") ?>assets/img/40330795_8767770.jpg" alt="Gedung H Polban" class="position-absolute w-100 object-fit-cover h-100" style="z-index: -1; filter: brightness(0.4);">
        </div>
        
        <?= $this->renderSection("content") ?>

    </div>
    <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>

    <?= $this->renderSection('script') ?>
</body>

</html>