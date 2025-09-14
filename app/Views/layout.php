<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection("title") ?></title>
    <link href="<?= base_url("assets/fonts/fonts.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("assets/css/dashboard.css") ?>">

    <?= $this->renderSection('style') ?>

</head>

<body>
    <div class="d-flex">
        <aside class="sidebar p-3">
            <div class="d-flex align-items-center mb-4">
                <i class="bi bi-check2-circle fs-2 text-success"></i>
                <span class="fs-4 fw-bold ms-2">SiAkad</span>
            </div>

            <p class="text-muted small text-uppercase ps-3">Menu Utama</p>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" aria-current="page">
                        Mahasiswa
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" aria-current="page">
                        Course
                    </a>
                </li>
            </ul>
        </aside>

        <main class="p-4 pt-3 flex-grow-1 position-relative">
            <nav class="navbar navbar-expand-lg bg-white position-sticky py-2 rounded-4 mb-3" style="left: 0; right: 0;">
                <div class="container-fluid">
                    <button class="btn btn-outline-light" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">

                        <div class="d-flex">
                            <button class="btn btn-outline-danger" data-bs-target="#modal-logout" data-bs-toggle="modal" type="submit">Logout</button>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="modal fade" id="modal-logout" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">konfirmasi Logout</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin akan logout?
                        </div>
                        <form method="post" action="<?= base_url('logout') ?>" class="modal-footer border-0">
                            <?= csrf_field() ?>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-outline-danger">Ya, Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>

    <?= $this->renderSection('script') ?>
</body>

</html>