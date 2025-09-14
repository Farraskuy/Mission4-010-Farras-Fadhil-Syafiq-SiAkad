<?= $this->extend('auth/layout') ?>

<?= $this->section('title') ?>
Masuk ke akun
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex w-100 vh-100 align-items-center justify-content-center justify-content-sm-end position-relative login">

    <!-- Background -->
    <div class="w-100 h-100 overflow-hidden position-absolute">
        <img src="<?= base_url("") ?>assets/img/40330795_8767770.jpg" alt="Gedung H Polban" class="position-absolute w-100 object-fit-cover" style="z-index: -1; filter: brightness(0.4);">
    </div>

    <!-- Card Login -->
    <div class="card shadow-lg border-0 rounded-4 p-4 me-0 me-sm-5" style="width: 380px; background: rgba(255,255,255,0.9);">
        <div class="gap-3 d-flex mb-4 align-items-center flex-wrap flex-sm-nowrap">
            <img src="<?= base_url("") ?>assets/img/189982191_17242e90-fe2c-4ea2-be5c-1f50c2df067b.jpg" alt="Logo polban" class="mb-2 bg-white rounded-3 p-3" height="65" width="65">
            <div class="d-flex flex-column justify-content-center">
                <h5 class="fw-semibold m-0">SiAkad</h5>
                <p class="text-muted text-secondary m-0">Sistem Akademik</p>
            </div>
        </div>

        <h1 class="fs-4 fw-medium mb-4">Masuk</h1>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger "><?= session()->getFlashdata('error') ?></div>
        <?php endif ?>

        <form method="post" class="w-100">
            <?= csrf_field() ?>

            <div class="form-floating mb-3">
                <input type="text" id="username" name="username" class="form-control rounded-3 <?= isset($validation['username']) ? 'is-invalid' : '' ?>" placeholder="Username atau email" value="<?= old("username", "") ?>">
                <label for="username">Username / Email</label>
                <?php if (isset($validation['username'])):  ?>
                    <div class="invalid-feedback">
                        <?= $validation['username'] ?>
                    </div>
                <?php endif ?>
            </div>

            <div class="form-floating mb-3">
                <input type="password" id="password" name="password" class="form-control rounded-3 <?= isset($validation['password']) ? 'is-invalid' : '' ?>" placeholder="Password" value="<?= old("password", "") ?>">
                <label for="password">Password</label>
                <?php if (isset($validation['password'])):  ?>
                    <div class="invalid-feedback">
                        <?= $validation['password'] ?>
                    </div>
                <?php endif ?>
            </div>

            <!-- <div class="mb-3 small">
                <a href="#" class="text-decoration-none">Lupa password?</a>
            </div> -->

            <button class="btn btn-primary fw-semibold rounded-pill w-100 py-2">
                Masuk
            </button>

        </form>
    </div>
</div>


<?= $this->endSection('content') ?>