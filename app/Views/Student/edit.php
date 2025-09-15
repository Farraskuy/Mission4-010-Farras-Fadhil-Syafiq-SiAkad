<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
Update Student
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-5">
    <h2 class="fw-bold">Edit Student</h2>
    <p class="text-muted">Form to edit student list</p>
    <div class="d-flex justify-content-between flex-wrap">
        <a href="<?= base_url("student") ?>" class="btn btn-secondary">Back</a>
        <a href="<?= base_url("student/update/password/{$student['nim']}") ?>" class="btn btn-warning fw-semibold">Update Password</a>
    </div>
</div>

<form action="<?= base_url('student/tambah') ?>" method="post">
    <?= csrf_field() ?>
    <!-- <?= d($validation) ?> -->

    <div class="mb-3">
        <label for="nim" class="form-label">NIM</label>
        <input type="text"
            class="form-control <?= isset($validation['nim']) ? 'is-invalid' : '' ?>"
            id="nim" name="nim" maxlength="9" value="<?= old('nim', $student['nim']) ?>">
        <?php if (isset($validation['nim'])): ?>
            <div class="invalid-feedback">
                <?= $validation['nim'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date"
            class="form-control <?= isset($validation['tanggal_lahir']) ? 'is-invalid' : '' ?>"
            id="tanggal_lahir" name="tanggal_lahir" value="<?= old('tanggal_lahir', $student['tanggal_lahir']) ?>">
        <?php if (isset($validation['tanggal_lahir'])): ?>
            <div class="invalid-feedback">
                <?= $validation['tanggal_lahir'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="entry_year" class="form-label">Entry Year</label>
        <input type="date"
            class="form-control <?= isset($validation['entry_year']) ? 'is-invalid' : '' ?>"
            id="entry_year" name="entry_year" value="<?= old('entry_year', $student['entry_year']) ?>">
        <?php if (isset($validation['entry_year'])): ?>
            <div class="invalid-feedback">
                <?= $validation['entry_year'] ?>
            </div>
        <?php endif; ?>
    </div>

    <br>
    <hr>
    <br>

    <div class="mb-3">
        <label for="full_name" class="form-label">Nama Lengkap</label>
        <input type="text"
            class="form-control <?= isset($validation['full_name']) ? 'is-invalid' : '' ?>"
            id="full_name" name="full_name" value="<?= old('full_name', $student['full_name']) ?>">
        <?php if (isset($validation['full_name'])): ?>
            <div class="invalid-feedback">
                <?= $validation['full_name'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email"
            class="form-control <?= isset($validation['email']) ? 'is-invalid' : '' ?>"
            id="email" name="email" value="<?= old('email', $student['email']) ?>">
        <?php if (isset($validation['email'])): ?>
            <div class="invalid-feedback">
                <?= $validation['email'] ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text"
            class="form-control <?= isset($validation['username']) ? 'is-invalid' : '' ?>"
            id="username" name="username" value="<?= old('username', $student['username']) ?>">
        <?php if (isset($validation['username'])): ?>
            <div class="invalid-feedback">
                <?= $validation['username'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tombol -->
    <div class="d-flex justify-content-end">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button type="submit" class="btn btn-warning">Update Student</button>
    </div>
</form>


<?= $this->endSection() ?>