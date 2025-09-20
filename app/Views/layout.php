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
    <div class="d-flex vh-100">
        <aside class="sidebar p-3">
            <div class="gap-3 d-flex mb-4 align-items-center flex-wrap flex-sm-nowrap">
                <img src="<?= base_url("") ?>assets/img/189982191_17242e90-fe2c-4ea2-be5c-1f50c2df067b.jpg" alt="Logo polban" class="mb-2 bg-white rounded-3 p-3" height="65" width="65">
                <div class="d-flex flex-column justify-content-center">
                    <h5 class="fw-semibold m-0">SiAkad</h5>
                    <p class="text-muted text-secondary m-0">Sistem Akademik</p>
                </div>
            </div>

            <p class="text-muted small text-uppercase ps-3">Menu Utama</p>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="<?= base_url('/') ?>" class="nav-link <?= service('uri')->getSegment(1) == ''  ? 'active' : '' ?>" aria-current="page">
                        Dashboard
                    </a>
                </li>
                <?php if (session()->has('users') && session()->get('users')['role'] == 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('/student') ?>" class="nav-link <?= service('uri')->getSegment(1) == 'student' ? 'active' : '' ?>" aria-current="page">
                            Student
                        </a>
                    </li>
                <?php endif ?>

                <li class="nav-item">
                    <a href="<?= base_url('/course') ?>" class="nav-link <?= service('uri')->getSegment(1) == 'course' ? 'active' : '' ?>" aria-current="page">
                        Course
                    </a>
                </li>

            </ul>
        </aside>

        <main class="p-4 pt-3 flex-grow-1 position-relative overflow-auto">
            <nav class="navbar navbar-expand-lg bg-white position-sticky py-2 rounded-4 mb-3" style="left: 0; right: 0; top: 0;">
                <div class="container-fluid">
                    <button class="btn btn-outline-light" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="d-flex">
                        <button class="btn btn-outline-danger" data-bs-target="#modal-logout" data-bs-toggle="modal" type="submit">Logout</button>
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

            <div class="d-flex justify-content-between align-items-center mb-4 w-100">
                <div class="py-3 px-4 w-100">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>
    </div>

    <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>

    <?= $this->renderSection('script') ?>
</body>

</html>